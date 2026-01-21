const {
    getTypeCookie,
    updateTypeCookie
} = require('../../controllers/MysqlController');
const puppeteer = require('puppeteer');
const axios = require('axios');
const path = require('path');
const fs = require('fs');
const { DownloaderHelper } = require('node-downloader-helper');
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

const servicePrefix = 'fi/';

const exChanger = {
    "png16": {
        "selector": "#select-size > div > ul > li > a[data-size=\"16\"]",
        "type": "png"
    },
    "png24": {
        "selector": "#select-size > div > ul > li > a[data-size=\"24\"]",
        "type": "png"
    },
    "png64": {
        "selector": "#select-size > div > ul > li > a[data-size=\"64\"]",
        "type": "png"
    },
    "png128": {
        "selector": "#select-size > div > ul > li > a[data-size=\"128\"]",
        "type": "png"
    },
    "png256": {
        "selector": "#select-size > div > ul > li > a[data-size=\"256\"]",
        "type": "png"
    },
    "png512": {
        "selector": "#select-size > div > ul > li > a[data-size=\"512\"]",
        "type": "png"
    },
    "svg": {
        "selector": "#download [data-format=\"svg\"]",
        "type": "svg"
    },
    "android": {
        "selector": "#download [data-format=\"android\"]",
        "type": "zip"
    },
    "ios": {
        "selector": "#download [data-format=\"ios\"]",
        "type": "zip"
    },
    "aep": {
        "selector": "#download [data-format=\"aep\"]",
        "type": "aep"
    },
    "lottie": {
        "selector": "#download [data-format=\"lottie\"]",
        "type": "json"
    },
    "gif": {
        "selector": "#download [data-format=\"gif\"]",
        "type": "gif"
    },
    "mp4": {
        "selector": "#download [data-format=\"mp4\"]",
        "type": "mp4"
    },
    "eps": {
        "selector": "#download [data-format=\"eps\"]",
        "type": "eps"
    },
    "psd": {
        "selector": "#download [data-format=\"psd\"]",
        "type": "psd"
    },
    "apng": {
        "selector": "#download [data-format=\"png\"]",
        "type": "png"
    },
};

const getItemFlatIcon = async (getTheUrl, downloadButtonSelectorKey) => {
    return new Promise(async (resolve, reject) => {
        try {
            const cookies = await getTypeCookie('flaticon');
            const UsingCookieNameForUpdate = cookies.name;
            const deserializedCookies = JSON.parse(cookies.cookie);

            const downloadButtonSelector = exChanger[downloadButtonSelectorKey];
            if (!downloadButtonSelector) {
                return reject(`Invalid downloadButtonSelectorKey: ${downloadButtonSelectorKey}`);
            }

            console.log(getTheUrl + ' için istek alındı.');
            let slugId = getTheUrl.match(/(\d+)/)[1];
            console.log('#Flaticon ## Slug Alındı : ' + slugId);

            const downloadPath = path.join(__dirname, 'downloads');
            if (!fs.existsSync(downloadPath)) {
                fs.mkdirSync(downloadPath);
            }

            const browser = await puppeteer.launch({
                headless: 'new',
                args: [
                    '--disable-cache',
                    '--disk-cache-size=0',
                    '--media-cache-size=0',
                    '--disable-application-cache',
                    '--disable-offline-load-stale-cache',
                    '--disable-gpu-shader-disk-cache',
                    '--disable-dev-shm-usage',
                    '--no-sandbox'
                ]
            });

            const page = await browser.newPage();

            const client = await page.target().createCDPSession();
            await client.send('Page.setDownloadBehavior', {
                behavior: 'allow',
                downloadPath: downloadPath
            });
            await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
            await page.setCacheEnabled(false);

            // Çerezleri ayarla
            for (let cookie of deserializedCookies) {
                await page.setCookie({
                    ...cookie,
                    sameSite: 'None'
                });
            }

            console.log('#Flaticon ## Browser Açıldı.');

            // İndirilen dosyayı bekle ve S3'e yükle
            const waitForDownload = async () => {
                await page.waitForTimeout(5000); // İndirmenin başlaması için bekle
                const files = fs.readdirSync(downloadPath);
                if (files.length === 0) {
                    throw new Error('Dosya indirilemedi');
                }
                const downloadedFile = path.join(downloadPath, files[0]);
                const fileContent = fs.readFileSync(downloadedFile);

                // S3'e yükle
                await AwsS3.upload({
                    Bucket: BUCKET_NAME,
                    Key: servicePrefix + slugId + '.' + downloadButtonSelector.type,
                    Body: fileContent,
                    ContentType: 'application/' + downloadButtonSelector.type
                }).promise();

                // İndirme bağlantısını oluştur
                const url = await new Promise((resolve, reject) => {
                    AwsS3.getSignedUrl('getObject', {
                        Bucket: BUCKET_NAME,
                        Key: servicePrefix + slugId + '.' + downloadButtonSelector.type,
                        Expires: 3600
                    }, (err, url) => {
                        if (err) reject(err);
                        resolve(url);
                    });
                });

                // Geçici dosyayı sil
                fs.unlinkSync(downloadedFile);
                return url;
            };

            await page.goto(getTheUrl, { waitUntil: 'networkidle0' });
            console.log('#Flaticon ## Sayfa Yüklendi.');

            const cookiesNew = await page.cookies();
            await updateTypeCookie(UsingCookieNameForUpdate, JSON.stringify(cookiesNew));

            if (await page.$('#select-size > button > i') !== null)
                await page.click('#select-size > button > i');

            if (await page.$('#download > button > i') !== null)
                await page.click('#download > button > i');

            if (downloadButtonSelector.selector.includes('svg')) {
                try {
                    await page.click(downloadButtonSelector.selector);
                } catch (e) {
                    await page.click('#download > div.btn-svg > div > a');
                }
            } else {
                await page.click(downloadButtonSelector.selector);
            }

            console.log('#Flaticon ## İndirme Butonuna Tıklandı Gelen Selector : ' + downloadButtonSelector.selector);

            const downloadUrl = await waitForDownload();
            await browser.close();
            return resolve({ success: true, url: downloadUrl });
        } catch (e) {
            await browser.close();
            return reject(e);
        }
    });
};

const sleep = (milliseconds) => {
    return new Promise(resolve => setTimeout(resolve, milliseconds));
};

const downloadFile = async (fileUrl, outputLocationPath, page) => {
    try {
        const response = await page.goto(fileUrl);
        const buffer = await response.buffer();
        fs.writeFileSync(outputLocationPath, buffer);
        return Promise.resolve();
    } catch (error) {
        await page.browser().close();
        return Promise.reject(error);
    }
};

module.exports = getItemFlatIcon;
