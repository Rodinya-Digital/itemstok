const {
    getTypeCookie,
    updateTypeCookie,
    saveDownloadedLog,
    saveDownloadedGoFiles
} = require('../../controllers/MysqlController');
const path = require('path');
const fs = require('fs');
const {DownloaderHelper} = require('node-downloader-helper');
const axios = require('axios');

const puppeteer = require('puppeteer-extra');
const StealthPlugin = require('puppeteer-extra-plugin-stealth')
puppeteer.use(StealthPlugin())
const {executablePath} = require('puppeteer')

const archiver = require('archiver');
const AWS = require('aws-sdk');
const spacesEndpoint = new AWS.Endpoint('r8w1.fra.idrivee2-36.com');
const ID = '7M6ATvoK22BBflnKg9K8';
const SECRET = 'ffEJ2j5mbNbzdzaxbdqt2527226xm5Aj60SU4CX2';
const BUCKET_NAME = 'itemstok';
const AwsS3 = new AWS.S3({
    endpoint: spacesEndpoint,
    accessKeyId: ID,
    secretAccessKey: SECRET
});
const servicePrefix = 'ma/';
const servicePrefixl = 'ma_l/';

const getItemMotionArray = async (getTheUrl) => {
    let browser; // browser'ı dışarıda tanımlıyoruz
    return new Promise(async (resolve, reject) => {
        try {
            const slugID = (getTheUrl.match(/-(\d+)/gm)[getTheUrl.match(/-(\d+)/gm).length - 1]).replace('-', '');
            console.log('Perceived SLUG : ' + slugID + '  Perceived id : ' + getTheUrl.match(/-(\d+)/gm).length);

            const cookies = await getTypeCookie('motionarray');
            const deserializedCookies = JSON.parse(cookies.cookie);

            browser = await puppeteer.launch({
                headless: true,
                args: ['--window-size=1920,1080', '--no-sandbox',
                    '--disable-setuid-sandbox',
                    '--disable-gpu',
                    '--enable-features=NetworkService',
                    '--no-first-run',
                    '--no-zygote',
                    '--single-process',
                    '--disable-dev-shm-usage'],
                executablePath: executablePath()
            });
            const page = await browser.newPage();
            await page.setCookie(...deserializedCookies);
            await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36');

            const downloadUrl = `https://motionarray.com/account/download/${slugID}/?resolutionFormat=uhd`;

            await page.goto(downloadUrl);
            const signedUrl = await page.evaluate(() => {
                const response = JSON.parse(document.body.innerText);
                return response.signed_url || '';
            });

            if (!signedUrl) {
                throw new Error("Failed to retrieve download URL");
            }

            console.log('Signed URL: ', signedUrl);

            resolve({
                "success": true,
                "url": signedUrl
            });

            await uploadS3MotionArray(signedUrl, slugID);
            await downloadAndUploadS3License(deserializedCookies, slugID, browser);

            const newCookies = await getNowCookie(browser);
            return true
        } catch (e) {
            console.log('try error ! ', e);
            reject(e);
        }
    });
};

const downloadAndUploadS3License = async (cookies, slugID, browser) => {
    try {
        const page = await browser.newPage();


        // Lisans dosyasını indirecek URL
        const licenseUrl = `https://motionarray.com/account/download-license/${slugID}/`;

        // URL'ye gitmeye çalışıyoruz
        const response = await page.goto(licenseUrl);
    }catch (e) {
        console.log('INDIRME BAŞARILI OLDUMU BİLMİYORUZ AMA DOSYAYI AŞAĞIDA ARIYACAĞIZ LİSANS DOSYASI')
        setTimeout(async ()=>{
            const directoryPath = 'C:/Users/Administrator/Downloads';
            const searchPattern = slugID;

            fs.readdir(directoryPath, (err, files) => {
                if (err) {
                    return console.log('Unable to scan directory: ' + err);
                }

                // Her dosya için arama
                files.forEach(async (file) => {
                    if (file.includes(searchPattern) && path.extname(file) === '.pdf') {
                        console.log('Matching file found: ' + file);
                        const fullFilePath = path.join(directoryPath, file);
                        console.log('Full path: ' + fullFilePath);


                        console.log('MOTION ARRAY LICENSE FILE DOWNLOADED, START S3 UPLOAD');

                        // Dosyayı S3'e yüklüyoruz
                        const ahhee = await AwsS3.upload({
                            Bucket: BUCKET_NAME,
                            Key: servicePrefixl + slugID + '.pdf',
                            Body: fs.createReadStream(fullFilePath)
                        }).promise();

                        console.log('## MOTION ARRAY LICENCE FILE S3 UPLOAD FINISHED',ahhee );

                        // Geçici dosyayı siliyoruz
                        if (fs.existsSync(fullFilePath)) {
                            fs.unlinkSync(fullFilePath);
                        }

                    }
                });
            });
        }, 5000)
    }


};


const uploadS3MotionArray = async (SourceFileUrl, slugID) => {
    let downloaderFileNameRegex = ((SourceFileUrl).split('/')[(SourceFileUrl).split('/').length - 1]).match(/(.*?)\?/)[1]
    const dl = new DownloaderHelper(SourceFileUrl, __dirname + '/tempFiles', {fileName: downloaderFileNameRegex});
    dl.on('end', async () => {
        console.log('## MOTION ARRAY FILE DOWNLOAD END S3 UPLOAD STARTING... ##')

        const output = fs.createWriteStream(__dirname + '/tempFiles/' + slugID + '.zip');
        const archive = archiver('zip', {
            zlib: {level: 0} // Sets the compression level.
        });
        console.log('## MOTION ARRAY ZIPPING START')

        output.on('close', async function () {
            console.log('## MOTION ARRAY S3 UPLOADING FILE')
            await AwsS3.upload({
                Bucket: BUCKET_NAME,
                Key: servicePrefix + slugID + '.zip',
                Body: fs.createReadStream(__dirname + '/tempFiles/' + slugID + '.zip')
            }).promise().then(async () => {
                console.log('## MOTION ARRAY S3 UPLOAD FINISHED')
                if (await fs.existsSync(__dirname + '/tempFiles/' + slugID + '.zip'))
                    fs.unlinkSync(__dirname + '/tempFiles/' + slugID + '.zip');
                if (await fs.existsSync(__dirname + '/tempFiles/' + downloaderFileNameRegex))
                    fs.unlinkSync(__dirname + '/tempFiles/' + downloaderFileNameRegex);
                console.log('## MOTION ARRAY S3 UPLOAD FINISHED DELETED TEMP FILES')
                return true;
            })
        })

        archive.on('error', function (err) {
            console.log('## MOTION ARRAY ZIP ERROR ', err)
            return reject(err)
        });
        archive.pipe(output);
        archive
            .append(fs.createReadStream(__dirname + '/tempFiles/' + downloaderFileNameRegex), {name: downloaderFileNameRegex})
            .finalize();

    });
    dl.on('download', async (r) => {
        if (r.totalSize > 300000000) { //100MB LIMITOR!
            console.log('### MOTION ARRAY MAX FILE SIZE STOP #####')
            dl.stop()
        }
    })
    dl.on('renamed', async (r) => {
        console.log('### MOTION ARRAY RENAME EXITS STOP #####')
        dl.stop()
    })
    dl.on('stop', async (err) => {
        console.log('### MOTION ARRAY DL STOP #####')
        return true;
    });
    dl.on('error', (err) => console.log('## MOTION ARRAY FILE DOWNLOAD FAILED CODE: DL.ONL66 ##', err));
    dl.start().catch(err => console.error(err));
}
const getNowCookie = async (browser) => {
    console.log('get New Cookie')
    const page = await browser.newPage();
    await page.goto('https://motionarray.com/');
    await page.screenshot({path: __dirname + '/ss/2.png'})
    await page.goto('https://motionarray.com/browse/stock-video/');
    await page.waitForTimeout(8000)
    await page.screenshot({path: __dirname + '/ss/3.png'})

    const cookiesNew = await page.cookies()
    await browser.close()
    if (browser && browser.process() != null) browser.process().kill('SIGINT');
    console.log('Geted new cookie')
    await updateTypeCookie('motionarray', JSON.stringify(cookiesNew));
    return cookiesNew;
}

module.exports = getItemMotionArray;
