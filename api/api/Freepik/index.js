const { getTypeCookie, updateTypeCookie, saveFreepikLD } = require('../../controllers/MysqlController');
const axios = require('axios');
const puppeteer = require('puppeteer-extra');
const StealthPlugin = require('puppeteer-extra-plugin-stealth');
const { executablePath } = require('puppeteer');
const path = require('path');
const fs = require('fs');
const { DownloaderHelper } = require('node-downloader-helper');
const archiver = require('archiver');
const AWS = require('aws-sdk');

puppeteer.use(StealthPlugin());

const FreepikDownloader = require('./FreepikDownloader');

// AWS S3 Configuration
const spacesEndpoint = new AWS.Endpoint('r8w1.fra.idrivee2-36.com');
const S3_CONFIG = {
    endpoint: spacesEndpoint,
    accessKeyId: '7M6ATvoK22BBflnKg9K8',
    secretAccessKey: 'ffEJ2j5mbNbzdzaxbdqt2527226xm5Aj60SU4CX2',
};
const BUCKET_NAME = 'itemstok';
const SERVICE_PREFIX = 'fp/';
const MAX_FILE_SIZE = 300000000; // 300MB
const TEMP_DIR = path.join(__dirname, 'tempFiles');

const AwsS3 = new AWS.S3(S3_CONFIG);

// Content type mappings
const CONTENT_TYPES = {
    PHOTO: ['premium-ai-image', 'free-ai-image', 'fotos-premium', 'foto-gratis', 'premium-photo', 'free-photo', 'photos-premium', 'photos-gratuite'],
    VIDEO: ['free-video', 'premium-video', 'video-gratis', 'video-premium', 'video-gratuito', 'video-gratuite'],
    ICON: ['icon'],
    MODEL_3D: ['3d-model'],
    FONT: ['font'],
    VECTOR: ['vector'] // Default case
};

/**
 * Extracts slug information from Freepik URL
 * @param {string} url - The Freepik URL
 * @returns {Object} - Object containing slug match and ID
 */
function extractSlugInfo(url) {
    const slugMatch = url.match('\\.freepik\\..*\\/(.*?)\\/');
    const slugID = url.match(/_(\d+)/);

    if (!slugMatch || !slugID) {
        throw new Error('Invalid Freepik URL format');
    }

    return {
        type: slugMatch[1],
        id: slugID[1]
    };
}

/**
 * Determines content type based on slug type
 * @param {string} slugType - The slug type from URL
 * @returns {string} - Content type
 */
function getContentType(slugType) {
    for (const [type, patterns] of Object.entries(CONTENT_TYPES)) {
        if (patterns.includes(slugType)) {
            return type;
        }
    }
    return 'VECTOR'; // Default
}

/**
 * Builds API URL based on content type and slug ID
 * @param {string} contentType - Content type
 * @param {string} slugID - Slug ID
 * @param {string} sourceSlugId - Source slug ID for videos
 * @returns {string} - API URL
 */
function buildApiUrl(contentType, slugID, sourceSlugId = null) {
    const baseUrls = {
        PHOTO: `https://www.freepik.com/api/regular/download?resource=${slugID}&action=download&walletId=#walletId#&locale=en`,
        VIDEO: `https://www.freepik.com/api/video/${sourceSlugId}/download?walletId=#walletId#&optionId=${slugID}`,
        ICON: `https://www.freepik.com/api/icon/download?walletId=#walletId#&optionId=${slugID}&format=svg&type=original`,
        MODEL_3D: `https://www.freepik.com/api/model3d/${slugID}/download?walletId=#walletId#&fileType=blend`,
        FONT: `https://www.freepik.com/api/fonts/download?id=${slugID}&walletId=1304323c-15c9-4031-a3cb-24f8337498f3`,
        VECTOR: `https://www.freepik.com/api/regular/download?walletId=#walletId#&resource=${slugID}&action=download&locale=en`
    };

    return baseUrls[contentType] || baseUrls.VECTOR;
}

/**
 * Extracts filename from download URL
 * @param {string} url - Download URL
 * @returns {string} - Extracted filename
 */
function extractFilename(url) {
    const urlParts = url.split('/');
    const lastPart = urlParts[urlParts.length - 1];
    const match = lastPart.match(/(.*?)\?/);
    return match ? match[1] : lastPart;
}

/**
 * Creates a zip file from the downloaded file
 * @param {string} inputFilePath - Path to input file
 * @param {string} outputZipPath - Path to output zip file
 * @param {string} filename - Original filename
 * @returns {Promise} - Promise that resolves when zip is created
 */
function createZipFile(inputFilePath, outputZipPath, filename) {
    return new Promise((resolve, reject) => {
        const output = fs.createWriteStream(outputZipPath);
        const archive = archiver('zip', { zlib: { level: 0 } });

        output.on('close', resolve);
        archive.on('error', reject);

        archive.pipe(output);
        archive.append(fs.createReadStream(inputFilePath), { name: filename });
        archive.finalize();
    });
}

/**
 * Uploads file to S3
 * @param {string} filePath - Path to file to upload
 * @param {string} key - S3 key
 * @returns {Promise} - Promise that resolves when upload is complete
 */
async function uploadToS3(filePath, key) {
    const params = {
        Bucket: BUCKET_NAME,
        Key: key,
        Body: fs.createReadStream(filePath)
    };

    return AwsS3.upload(params).promise();
}

/**
 * Cleans up temporary files
 * @param {Array} filePaths - Array of file paths to delete
 */
function cleanupFiles(filePaths) {
    filePaths.forEach(filePath => {
        if (fs.existsSync(filePath)) {
            fs.unlinkSync(filePath);
        }
    });
}

/**
 * Downloads file and handles the complete process
 * @param {Object} downloadResult - Result from FreepikDownloader
 * @param {string} slugID - Slug ID
 * @param {string} slugx - Original URL
 * @param {string} contentType - Content type
 * @returns {Promise} - Promise that resolves when process is complete
 */
async function processDownload(downloadResult, slugID, slugx, contentType) {
    const filename = downloadResult.filename || extractFilename(downloadResult.url);
    const tempFilePath = path.join(TEMP_DIR, filename);
    const zipFilePath = path.join(TEMP_DIR, `${slugID}.zip`);

    console.log('## FREEPIK FILE DOWNLOAD START ##');

    // Save license information for photos and vectors
    if (['PHOTO', 'VECTOR'].includes(contentType)) {
        console.log('## FREEPIK LICENSE DB SAVING !! ###');
        await saveFreepikLD(slugID, slugx, 'VECTOR & PHOTO & PSD', downloadResult.cookie);
        console.log('## FREEPIK LICENSE DB SAVE SUCCESS ###');
    }

    return new Promise((resolve, reject) => {
        const downloader = new DownloaderHelper(downloadResult.url, TEMP_DIR, { fileName: filename });

        downloader.on('end', async () => {
            try {
                console.log('## FREEPIK FILE DOWNLOAD END S3 UPLOAD STARTING... ##');

                // Create zip file
                console.log('## FREEPIK ZIPPING START ##');
                await createZipFile(tempFilePath, zipFilePath, filename);

                // Upload to S3
                console.log('## FREEPIK S3 UPLOADING FILE ##');
                await uploadToS3(zipFilePath, `${SERVICE_PREFIX}${slugID}.zip`);
                console.log('## FREEPIK S3 UPLOAD FINISHED ##');

                // Cleanup
                cleanupFiles([tempFilePath, zipFilePath]);
                console.log('## FREEPIK S3 UPLOAD FINISHED DELETED TEMP FILES ##');

                resolve();
            } catch (error) {
                console.error('## FREEPIK PROCESS ERROR ##', error);
                cleanupFiles([tempFilePath, zipFilePath]);
                reject(error);
            }
        });

        downloader.on('download', (stats) => {
            if (stats.totalSize > MAX_FILE_SIZE) {
                console.log('### FREEPIK MAX FILE SIZE STOP #####');
                downloader.stop();
            }
        });

        downloader.on('renamed', () => {
            console.log('## FREEPIK FILE CLONE DETECTED - STOPPING DOWNLOAD ##');
            downloader.stop();
        });

        downloader.on('stop', () => {
            console.log('### FREEPIK DL STOP #####');
            resolve();
        });

        downloader.on('error', (error) => {
            console.error('## FREEPIK FILE DOWNLOAD FAILED ##', error);
            cleanupFiles([tempFilePath, zipFilePath]);
            reject(error);
        });

        downloader.start().catch(reject);
    });
}

/**
 * Main function to handle Freepik item download
 * @param {string} slugx - Freepik URL
 * @param {string} xUrl - Alternative URL (for videos)
 * @returns {Promise} - Promise that resolves with download result
 */
async function getItemFreepik(slugx, xUrl = false) {
    try {
        // Validate URL format
        if (!slugx.match('\\.freepik\\..*\\/(.*?)\\/')) {
            throw new Error('Not Supported URL !');
        }

        const { type: slugType, id: slugID } = extractSlugInfo(slugx);
        const contentType = getContentType(slugType);

        console.log(`## NEW FREEPIK MISSION (${slugType}) -> GOTO: ${slugx} ##`);

        // Special handling for videos
        let sourceSlugId = null;
        if (contentType === 'VIDEO' && xUrl) {
            sourceSlugId = extractSlugInfo(xUrl).id;
        }

        const apiUrl = buildApiUrl(contentType, slugID, sourceSlugId);

        // Initialize downloader and get download URL
        const downloader = new FreepikDownloader();
        await downloader.initialize();

        const downloadResult = await downloader.download(apiUrl);
        console.log('Download time:', downloadResult.time);

        // Return download URL immediately to customer
        console.log('## FREEPIK DOWNLOAD URL RETURNED FOR CUSTOMER ##');
        const response = {
            success: true,
            url: downloadResult.url
        };

        // Process download asynchronously (don't await)
        processDownload(downloadResult, slugID, slugx, contentType)
            .catch(error => console.error('Background processing error:', error));

        return response;

    } catch (error) {
        console.error('Freepik download error:', error);
        throw error;
    }
}

module.exports = getItemFreepik;