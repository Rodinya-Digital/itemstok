const {chromium} = require('playwright');
const axios = require('axios');
const path = require('path');
const fs = require('fs');
const {DownloaderHelper} = require('node-downloader-helper');
const archiver = require('archiver');
const {getTypeCookie} = require('../../controllers/MysqlController');

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
const servicePrefix = 'ee/';

// Cookie kaynaklari - oncelik sirasi: 1) Lokal DB, 2) Harici API (fallback)
const EXTERNAL_API_URL = 'https://rose.voltyazilim.com.tr/VoltApiV2/envatoelements?access=Jd7LpXw9CnMqRbVt6YzKEuTf4HgW1aQs8BdNcxAz';

/**
 * Cookie'leri Playwright formatina normalize et
 * Chrome export formatindan Playwright formatina donusturur
 */
function normalizeCookiesForPlaywright(cookies) {
    if (!Array.isArray(cookies)) return [];
    
    return cookies.map(cookie => {
        // sameSite degerini Playwright formatina donustur
        let sameSite = 'Lax'; // default
        const ss = String(cookie.sameSite || '').toLowerCase();
        if (ss === 'strict') sameSite = 'Strict';
        else if (ss === 'none' || ss === 'no_restriction') sameSite = 'None';
        else if (ss === 'lax') sameSite = 'Lax';
        // 'unspecified' icin default 'Lax' kullanilir
        
        return {
            name: cookie.name,
            value: cookie.value,
            domain: cookie.domain,
            path: cookie.path || '/',
            expires: cookie.expirationDate || cookie.expires || -1,
            httpOnly: !!cookie.httpOnly,
            secure: !!cookie.secure,
            sameSite: sameSite
        };
    });
}

/**
 * Cookie'leri al - Once lokal DB'yi dene, basarisiz olursa harici API'ye fallback yap
 */
async function getEnvatoCookies() {
    // 1. Oncelikle lokal veritabanindan cookie'yi dene
    try {
        console.log('[ENVATO] Lokal DB\'den cookie kontrol ediliyor...');
        const localCookieData = await getTypeCookie('envatoelements');
        
        if (localCookieData && localCookieData.cookie) {
            const parsedCookies = JSON.parse(localCookieData.cookie);
            
            // Cookie gecerli mi kontrol et (bos array degilse ve en az 3 cookie varsa)
            if (Array.isArray(parsedCookies) && parsedCookies.length >= 3) {
                console.log('[ENVATO] Lokal DB\'den cookie alindi! (' + localCookieData.name + ', ' + parsedCookies.length + ' cookie)');
                // Cookie'leri Playwright formatina normalize et
                const normalizedCookies = normalizeCookiesForPlaywright(parsedCookies);
                return {
                    source: 'local_db',
                    cookies: normalizedCookies
                };
            }
        }
        console.log('[ENVATO] Lokal DB\'de gecerli cookie bulunamadi.');
    } catch (localError) {
        console.log('[ENVATO] Lokal DB hatasi:', localError.message);
    }

    // 2. Fallback: Harici API'den cookie al
    try {
        console.log('[ENVATO] Harici API\'den cookie aliniyor (fallback)...');
        const response = await axios.get(EXTERNAL_API_URL, { timeout: 10000 });
        const {status, cookie} = response.data;
        
        if (status === true && cookie && Array.isArray(cookie) && cookie.length > 0) {
            console.log('[ENVATO] Harici API\'den cookie alindi! (' + cookie.length + ' cookie)');
            // Harici API'den gelen cookie'ler de normalize edilmeli
            const normalizedCookies = normalizeCookiesForPlaywright(cookie);
            return {
                source: 'external_api',
                cookies: normalizedCookies
            };
        }
        throw new Error('Harici API gecersiz yanit dondu');
    } catch (apiError) {
        console.error('[ENVATO] Harici API hatasi:', apiError.message);
        throw new Error('Cookie alinamadi - ne lokal DB ne de harici API calisiyor!');
    }
}


const getItemEnvatoElements = async (slugx) => {
    return new Promise(async (resolve, reject) => {
        let fileNameExp;
        const headersconfig = {
            'content-type': 'application/json',
            'x-csrf-token': false,
            'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36',
            'cookie': false
        };
        console.log('içerik talep edildi : ' + slugx);

        const getCsrfToken = () => {
            return new Promise(async (resolve, reject) => {
                let browser, context, page;
                try {
                    // Launch browser
                    browser = await chromium.launch({
                        headless: true,
                        args: [
                            '--disable-web-security',
                            '--disable-features=TranslateUI',
                            '--disable-ipc-flooding-protection',
                            '--disable-background-timer-throttling',
                            '--disable-backgrounding-occluded-windows',
                            '--disable-renderer-backgrounding',
                            '--disable-field-trial-config',
                            '--disable-back-forward-cache',
                            '--disable-extensions',
                            '--no-first-run',
                            '--no-default-browser-check',
                            '--disk-cache-size=0',
                            '--media-cache-size=0'
                        ]
                    });

                    // Create a new context and page
                    context = await browser.newContext({
                        userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36',
                        viewport: {width: 1920, height: 1080},
                        // Cache'i tamamen devre dışı bırak
                        // Extra HTTP headers ile cache kontrolü
                        extraHTTPHeaders: {
                            'Cache-Control': 'no-cache, no-store, must-revalidate',
                            'Pragma': 'no-cache',
                            'Expires': '0'
                        }
                    });

                    page = await context.newPage();
                    // Tüm cache türlerini devre dışı bırak

// Network interceptor ile cache headers'ı kontrol et
                    await page.route('**/*', async route => {
                        const request = route.request();

                        // Cache-Control header'larını ekle/değiştir
                        const headers = {
                            ...request.headers(),
                            'Cache-Control': 'no-cache, no-store, must-revalidate',
                            'Pragma': 'no-cache',
                            'Expires': '0'
                        };

                        await route.continue({headers});
                    });


                    // Intercept network requests
                    await page.route('https://account.envato.com/api/sign_out', route => route.abort());
                    await page.route('https://account.envato.com/api/public/refresh_id_token', route => route.abort());
                    await page.route('https://account.envato.com/api/auto_sign_in', route => route.abort());
                    await page.route('https://consent.cookiebot.com/uc.js', route => route.abort());


                    // Cookie'leri al (lokal DB veya harici API)
                    const cookieResult = await getEnvatoCookies();
                    let deserializedCookies = cookieResult.cookies;
                    console.log('[ENVATO] Cookie kaynagi: ' + cookieResult.source);
                    
                    // Set cookies
                    await context.addCookies(deserializedCookies);


                    // Navigate to Envato Elements
                    await page.goto('https://elements.envato.com/', {
                        waitUntil: 'domcontentloaded'
                    });

                    // Sayfa yüklendikten sonra JavaScript ile cache'i temizle
                    await page.evaluate(() => {
                        // LocalStorage'ı temizle
                        if (typeof (Storage) !== "undefined") {
                            localStorage.clear();
                            sessionStorage.clear();
                        }

                        // Service Worker cache'ini temizle
                        if ('serviceWorker' in navigator) {
                            navigator.serviceWorker.getRegistrations().then(registrations => {
                                registrations.forEach(registration => {
                                    registration.unregister();
                                });
                            });
                        }

                        // Cache API'sini temizle
                        if ('caches' in window) {
                            caches.keys().then(names => {
                                names.forEach(name => {
                                    caches.delete(name);
                                });
                            });
                        }
                    });

                    // Wait for page to load and extract CSRF token
                    const pageContent = await page.content();
                    const csrfTokenMatch = pageContent.match(/window.CSRF_TOKENS={(.*?)}/);

                    if (!csrfTokenMatch) {
                        throw new Error('CSRF Token not found');
                    }

                    const axxAFirst = csrfTokenMatch[1];
                    const axxA = axxAFirst.match(/"(.*?)"/g)[1];
                    const CSRFTOKEN = axxA.replaceAll('"', '');

                    // Prepare headers
                    headersconfig.cookie = deserializedCookies.map((cookiessss) => {
                        return `${cookiessss.name}=${cookiessss.value}`;
                    }).join('; ');

                    // Close browser
                    await browser.close();

                    resolve(CSRFTOKEN.trim());
                } catch (e) {
                    console.error('Error in getCsrfToken:', e);
                    if (browser) await browser.close();
                    reject(e);
                }
            });
        };

        const download = (id) => {
            return new Promise((resolve, reject) => {
                // Log the request details for debugging
                console.log('Making download request for ID:', id);
                console.log('Headers being sent:', JSON.stringify(headersconfig, null, 2));

                // Make the request with detailed error handling
                axios.post('https://elements.envato.com/elements-api/items/' + id + '/download_and_license.json', {
                        licenseType: 'project',
                        projectName: "MYLICENSE",
                        pixelsquidFormat: "psd"
                    },
                    {
                        withCredentials: false,
                        headers: headersconfig,
                    })
                    .then(function (response) {
                        console.log('Download request successful, status:', response.status);
                        return resolve(response.data.data.attributes.downloadUrl)
                    })
                    .catch(function (error) {
                        console.log('ENVATO ELEMENTS DOWNLOAD FUNC ERROR:');

                        // Log detailed error information
                        if (error.response) {
                            // The server responded with a status code outside the 2xx range
                            console.log('Error status:', error.response.status);
                            console.log('Error data:', JSON.stringify(error.response.data, null, 2));
                        } else if (error.request) {
                            // The request was made but no response was received
                            console.log('No response received:', error.request);
                        } else {
                            // Something happened in setting up the request
                            console.log('Request setup error:', error.message);
                        }

                        return reject(error)
                    });
            })
        }

        const license = (id) => {
            return new Promise((resolve, reject) => {
                axios.post('https://elements.envato.com/api/v1/items/' + id + '/license.json', {
                        "itemId": id,
                        "licenseType": "project",
                        "pixelsquidFormat": "psd",
                        "projectName": "MYLICENSE"
                    },
                    {
                        withCredentials: false,
                        headers: headersconfig,
                    })
                    .then(function (response) {
                        axios.get('https://elements.envato.com' + response.data.data.attributes.textDownloadUrl,
                            {
                                withCredentials: false,
                                headers: {cookie: headersconfig.cookie},
                            })
                            .then(function (response) {
                                return resolve(response.data)
                            })
                            .catch(function (error) {
                                console.log("### ENVATO ELEMENTS DOWNLOAD URL GET FAILED!1 #####")
                                return reject(error)
                            });
                    })
                    .catch(function (error) {
                        console.log("### ENVATO ELEMENTS LICENSE GET FAILED!2 #####")
                        return reject(error)
                    });
            })
        }

        let slugID = slugx.match(/-([A-Z0-9]{6,})/)
        fileNameExp = slugID[1]
        console.log('SlugID geted => "' + fileNameExp + '"')

        let datas = {
            license: {
                result: false,
                error: false
            },
            download: {
                result: false,
                error: false
            }
        }

        try {
            // Get CSRF Token
            const csrfToken = await getCsrfToken();
            headersconfig['x-csrf-token'] = csrfToken;
            console.log('cookie csrf : ' + csrfToken);

            // Download the item
            const downloadUrl = await download(fileNameExp);
            datas.download.result = downloadUrl;

            // Get license
            const licenseResult = await license(fileNameExp);
            datas.license.result = licenseResult;

            // Resolve with download URL
            resolve({
                'success': true,
                'url': datas.download.result
            });
            console.log('ENVATO ELEMENTS DOWNLOAD URL RETURNED FOR COSTUMER');

            // Additional processing if download is successful
            if (datas.download.result) {
                console.log('## ENVATO ELEMENTS DOWNLOAD URL HAVE TRY RUN... ##');

                // Upload license to S3 if available
                if (datas.license.result) {
                    console.log('ENVATO ELEMENTS S3 UPLOADING LICENSE FILE');
                    await AwsS3.upload({
                        Bucket: BUCKET_NAME,
                        Key: 'ee_l/' + fileNameExp + '.txt',
                        Body: Buffer.from(datas.license.result, 'utf8')
                    }).promise();
                    console.log('ENVATO ELEMENTS S3 UPLOADED! LICENSE FILE');
                }

                // Determine filename
                let downloaderFileNameRegex;
                if ((datas.download.result).match(/%27%27(.*?)&Expires/)) {
                    downloaderFileNameRegex = fileNameExp + (datas.download.result).match(/%27%27(.*?)&Expires/)[1];
                } else {
                    downloaderFileNameRegex = fileNameExp + (datas.download.result).match(/.+\/(.*?)\?/)[1];
                }

                console.log('## ENVATO ELEMENTS FILE DOWNLOAD STARTING... ##');
                const dl = new DownloaderHelper(datas.download.result, __dirname + '/tempFiles', {fileName: downloaderFileNameRegex});

                dl.on('end', async () => {
                    console.log('## ENVATO ELEMENTS FILE DOWNLOAD END S3 UPLOAD STARTING... ##');

                    const output = fs.createWriteStream(__dirname + '/tempFiles/' + fileNameExp + '.zip');
                    const archive = archiver('zip', {
                        zlib: {level: 0} // Sets the compression level.
                    });

                    console.log('## ENVATO ELEMENTS ZIPPING START');
                    output.on('close', async function () {
                        console.log('ENVATO ELEMENTS S3 UPLOADING FILE');
                        await AwsS3.upload({
                            Bucket: BUCKET_NAME,
                            Key: servicePrefix + fileNameExp + '.zip',
                            Body: fs.createReadStream(__dirname + '/tempFiles/' + fileNameExp + '.zip')
                        }).promise().then(async () => {
                            console.log('## ENVATO ELEMENTS S3 UPLOAD FINISHED');

                            // Clean up temp files
                            if (fs.existsSync(__dirname + '/tempFiles/' + downloaderFileNameRegex))
                                fs.unlinkSync(__dirname + '/tempFiles/' + downloaderFileNameRegex);
                            if (fs.existsSync(__dirname + '/tempFiles/' + fileNameExp + '.zip'))
                                fs.unlinkSync(__dirname + '/tempFiles/' + fileNameExp + '.zip');

                            console.log('## ENVATO ELEMENTS S3 UPLOAD FINISHED DELETED TEMP FILES');
                        });
                    });

                    archive.on('error', function (err) {
                        console.log('## ENVATO ELEMENTS ZIP ERROR ', err);
                        return reject(err);
                    });

                    archive.pipe(output);
                    archive
                        .append(fs.createReadStream(__dirname + '/tempFiles/' + downloaderFileNameRegex), {name: downloaderFileNameRegex})
                        .finalize();
                });

                dl.on('download', (r) => {
                    if (r.totalSize > 1000) { //100MB LIMITOR
                        console.log('### ENVATO ELEMENTS MAX FILE SIZE STOP #####', r.totalSize);
                        dl.stop();
                        return true;
                    }
                });

                dl.on('renamed', (r) => {
                    dl.stop();
                    console.log('## ENVATO ELEMENTS FILE CLONE STOP DOWNLOAD UPLOAD PROCESS', r);
                    return true;
                });

                dl.on('stop', async () => {
                    console.log('## ENVATO ELEMENTS STOP CALLED !!');
                });

                dl.on('error', (err) => {
                    console.log(err.message);
                    console.log('## ENVATO ELEMENTS FILE DOWNLOAD FAILED CODE: DL.ONL66 ##');
                    return reject(err);
                });

                await dl.start();
            }
        } catch (error) {
            console.error('Error in Envato Elements download process:', error);
            return reject(error);
        }
    });
}

module.exports = getItemEnvatoElements;