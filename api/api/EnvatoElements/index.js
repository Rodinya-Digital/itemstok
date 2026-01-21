/**
 * Envato Elements Downloader - v3.0 (Direct Login per Request)
 * 
 * Her indirme isteğinde:
 * 1. Envato'ya giriş yap
 * 2. CSRF token al
 * 3. İçeriği indir
 * 4. Tarayıcıyı kapat
 * 
 * Cookie yönetimi YOK - her seferinde taze session
 */

const { chromium } = require('playwright');
const axios = require('axios');
const path = require('path');
const fs = require('fs');
const { DownloaderHelper } = require('node-downloader-helper');
const archiver = require('archiver');

// Merkezi config
const { S3_CONFIG, ENVATO_CREDENTIALS } = require('../../config/credentials');

// 2Captcha API Key
const CAPTCHA_API_KEY = process.env.CAPTCHA_API_KEY || 'f11f25a7e32dfb9ddf74eec3181a19f4';

const AWS = require('aws-sdk');
const spacesEndpoint = new AWS.Endpoint(S3_CONFIG.endpoint);
const BUCKET_NAME = S3_CONFIG.bucketName;
const AwsS3 = new AWS.S3({
    endpoint: spacesEndpoint,
    accessKeyId: S3_CONFIG.accessKeyId,
    secretAccessKey: S3_CONFIG.secretAccessKey
});

const servicePrefix = 'ee/';
const licensePrefx = 'ee_l/';

// Config
const CONFIG = {
    loginUrl: 'https://account.envato.com/sign_in?to=elements',
    baseUrl: 'https://elements.envato.com',
    navigationTimeout: 120000,
    logPrefix: '[ENVATO-DL]'
};

/**
 * Rastgele bekleme (bot detection bypass)
 */
function randomDelay(min = 500, max = 1500) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

/**
 * İnsan benzeri yazma
 */
async function humanType(page, selector, text) {
    await page.click(selector);
    await page.waitForTimeout(randomDelay(200, 400));
    for (const char of text) {
        await page.type(selector, char, { delay: randomDelay(30, 80) });
    }
}

/**
 * 2Captcha ile reCAPTCHA çöz
 */
async function solveCaptchaWith2Captcha(siteKey, pageUrl) {
    console.log(`${CONFIG.logPrefix} 2Captcha ile captcha çözülüyor...`);
    console.log(`${CONFIG.logPrefix} Site Key: ${siteKey}`);
    
    try {
        // 1. Captcha çözüm isteği gönder
        const requestUrl = `http://2captcha.com/in.php?key=${CAPTCHA_API_KEY}&method=userrecaptcha&googlekey=${siteKey}&pageurl=${encodeURIComponent(pageUrl)}&json=1`;
        
        const requestResponse = await axios.get(requestUrl, { timeout: 30000 });
        console.log(`${CONFIG.logPrefix} 2Captcha istek yanıtı:`, requestResponse.data);
        
        if (requestResponse.data.status !== 1) {
            throw new Error(`2Captcha istek hatası: ${requestResponse.data.request}`);
        }
        
        const captchaId = requestResponse.data.request;
        console.log(`${CONFIG.logPrefix} Captcha ID: ${captchaId}`);
        
        // 2. Çözümü bekle (ortalama 20-60 saniye)
        let solution = null;
        const maxAttempts = 30; // 30 deneme x 5 saniye = max 150 saniye
        
        for (let i = 0; i < maxAttempts; i++) {
            await new Promise(resolve => setTimeout(resolve, 5000)); // 5 saniye bekle
            
            const resultUrl = `http://2captcha.com/res.php?key=${CAPTCHA_API_KEY}&action=get&id=${captchaId}&json=1`;
            const resultResponse = await axios.get(resultUrl, { timeout: 30000 });
            
            console.log(`${CONFIG.logPrefix} 2Captcha sonuç (${i + 1}/${maxAttempts}):`, resultResponse.data.status);
            
            if (resultResponse.data.status === 1) {
                solution = resultResponse.data.request;
                break;
            } else if (resultResponse.data.request !== 'CAPCHA_NOT_READY') {
                throw new Error(`2Captcha çözüm hatası: ${resultResponse.data.request}`);
            }
        }
        
        if (!solution) {
            throw new Error('2Captcha zaman aşımı - captcha çözülemedi');
        }
        
        console.log(`${CONFIG.logPrefix} Captcha ÇÖZÜLDÜ! Token: ${solution.substring(0, 50)}...`);
        return solution;
        
    } catch (error) {
        console.error(`${CONFIG.logPrefix} 2Captcha hatası:`, error.message);
        throw error;
    }
}

/**
 * Sayfada Captcha var mı kontrol et ve varsa çöz
 */
async function handleCaptchaIfPresent(page) {
    console.log(`${CONFIG.logPrefix} Captcha kontrolü yapılıyor...`);
    
    try {
        // reCAPTCHA iframe veya div var mı kontrol et
        const recaptchaFrame = await page.$('iframe[src*="recaptcha"]');
        const recaptchaDiv = await page.$('.g-recaptcha, [data-sitekey]');
        const hcaptchaDiv = await page.$('.h-captcha, [data-hcaptcha-sitekey]');
        
        if (!recaptchaFrame && !recaptchaDiv && !hcaptchaDiv) {
            console.log(`${CONFIG.logPrefix} Captcha YOK, devam ediliyor...`);
            return false;
        }
        
        console.log(`${CONFIG.logPrefix} CAPTCHA TESPİT EDİLDİ!`);
        
        // Site key'i bul
        let siteKey = null;
        
        if (recaptchaDiv) {
            siteKey = await page.evaluate(() => {
                const el = document.querySelector('.g-recaptcha, [data-sitekey]');
                return el ? el.getAttribute('data-sitekey') : null;
            });
        }
        
        if (!siteKey) {
            // Sayfa kaynağından site key ara
            const pageContent = await page.content();
            const siteKeyMatch = pageContent.match(/data-sitekey=["']([^"']+)["']/);
            if (siteKeyMatch) {
                siteKey = siteKeyMatch[1];
            }
        }
        
        if (!siteKey) {
            // Envato'nun bilinen site key'i
            siteKey = '6LcjX04UAAAAANHJ3jT8TPbv1BlGmymOxfFwj-wt';
            console.log(`${CONFIG.logPrefix} Site key bulunamadı, varsayılan kullanılıyor: ${siteKey}`);
        }
        
        console.log(`${CONFIG.logPrefix} Site Key: ${siteKey}`);
        
        // 2Captcha ile çöz
        const pageUrl = page.url();
        const captchaToken = await solveCaptchaWith2Captcha(siteKey, pageUrl);
        
        // Token'ı sayfaya inject et
        await page.evaluate((token) => {
            // g-recaptcha-response textarea'sına token'ı yaz
            const responseTextarea = document.querySelector('#g-recaptcha-response, [name="g-recaptcha-response"], textarea[name="g-recaptcha-response"]');
            if (responseTextarea) {
                responseTextarea.style.display = 'block';
                responseTextarea.value = token;
            }
            
            // Callback fonksiyonunu çağır (varsa)
            if (typeof window.grecaptcha !== 'undefined' && window.grecaptcha.getResponse) {
                // Bazen callback fonksiyonu otomatik çağrılır
            }
            
            // Hidden input olarak da ekle
            const form = document.querySelector('form');
            if (form) {
                let input = form.querySelector('input[name="g-recaptcha-response"]');
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'g-recaptcha-response';
                    form.appendChild(input);
                }
                input.value = token;
            }
        }, captchaToken);
        
        console.log(`${CONFIG.logPrefix} Captcha token sayfaya enjekte edildi!`);
        await page.waitForTimeout(1000);
        
        return true;
        
    } catch (error) {
        console.error(`${CONFIG.logPrefix} Captcha işleme hatası:`, error.message);
        throw error;
    }
}

/**
 * Envato'ya giriş yap ve session bilgilerini döndür
 */
async function loginToEnvato(browser) {
    console.log(`${CONFIG.logPrefix} Envato'ya giriş yapılıyor...`);
    
    const context = await browser.newContext({
        userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        viewport: { width: 1920, height: 1080 },
        locale: 'en-US',
        timezoneId: 'Europe/Istanbul'
    });
    
    // Bot detection bypass
    await context.addInitScript(() => {
        Object.defineProperty(navigator, 'webdriver', { get: () => false });
        Object.defineProperty(navigator, 'plugins', { get: () => [1, 2, 3, 4, 5] });
        window.chrome = { runtime: {} };
    });
    
    const page = await context.newPage();
    page.setDefaultTimeout(CONFIG.navigationTimeout);
    
    // Login sayfasına git
    await page.goto(CONFIG.loginUrl, { waitUntil: 'networkidle' });
    await page.waitForTimeout(randomDelay(1500, 3000));
    
    // Zaten giriş yapılmış mı kontrol et
    const currentUrl = page.url();
    if (!currentUrl.includes('sign_in')) {
        console.log(`${CONFIG.logPrefix} Zaten giriş yapılmış!`);
        return { context, page, success: true };
    }
    
    // Email gir
    console.log(`${CONFIG.logPrefix} Email giriliyor...`);
    const emailSelector = 'input[name="user[login]"], input[type="email"], #user_login';
    await page.waitForSelector(emailSelector, { timeout: 30000 });
    await humanType(page, emailSelector, ENVATO_CREDENTIALS.email);
    await page.waitForTimeout(randomDelay(300, 600));
    
    // Şifre gir
    console.log(`${CONFIG.logPrefix} Şifre giriliyor...`);
    const passwordSelector = 'input[name="user[password]"], input[type="password"], #user_password';
    await page.waitForSelector(passwordSelector, { timeout: 30000 });
    await humanType(page, passwordSelector, ENVATO_CREDENTIALS.password);
    await page.waitForTimeout(randomDelay(300, 800));
    
    // Giriş butonuna tıkla
    console.log(`${CONFIG.logPrefix} Giriş yapılıyor...`);
    const submitSelector = 'button[type="submit"], input[type="submit"]';
    await page.click(submitSelector);
    
    // Giriş sonrası bekle
    await page.waitForNavigation({ waitUntil: 'networkidle', timeout: CONFIG.navigationTimeout }).catch(() => {});
    await page.waitForTimeout(randomDelay(2000, 4000));
    
    // Giriş başarılı mı kontrol et
    const finalUrl = page.url();
    if (finalUrl.includes('sign_in') || finalUrl.includes('login')) {
        console.error(`${CONFIG.logPrefix} GİRİŞ BAŞARISIZ!`);
        await page.screenshot({ path: path.join(__dirname, 'login_failed.png') });
        return { context, page, success: false, error: 'Login failed' };
    }
    
    console.log(`${CONFIG.logPrefix} Giriş BAŞARILI!`);
    return { context, page, success: true };
}

/**
 * CSRF Token al
 */
async function getCsrfToken(page) {
    console.log(`${CONFIG.logPrefix} CSRF token alınıyor...`);
    
    await page.goto(CONFIG.baseUrl, { waitUntil: 'networkidle' });
    await page.waitForTimeout(randomDelay(1000, 2000));
    
    const pageContent = await page.content();
    const csrfMatch = pageContent.match(/window\.CSRF_TOKENS=\{(.*?)\}/);
    
    if (!csrfMatch) {
        throw new Error('CSRF Token bulunamadı!');
    }
    
    const tokenMatch = csrfMatch[1].match(/"(.*?)"/g);
    if (!tokenMatch || tokenMatch.length < 2) {
        throw new Error('CSRF Token parse edilemedi!');
    }
    
    const csrfToken = tokenMatch[1].replace(/"/g, '');
    console.log(`${CONFIG.logPrefix} CSRF Token alındı: ${csrfToken.substring(0, 20)}...`);
    
    return csrfToken;
}

/**
 * Cookie string oluştur
 */
async function getCookieString(context) {
    const cookies = await context.cookies();
    return cookies.map(c => `${c.name}=${c.value}`).join('; ');
}

/**
 * İçerik indir
 */
async function downloadItem(itemId, csrfToken, cookieString) {
    console.log(`${CONFIG.logPrefix} İçerik indiriliyor: ${itemId}`);
    
    const headers = {
        'content-type': 'application/json',
        'x-csrf-token': csrfToken,
        'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'cookie': cookieString
    };
    
    const response = await axios.post(
        `https://elements.envato.com/elements-api/items/${itemId}/download_and_license.json`,
        {
            licenseType: 'project',
            projectName: 'MYLICENSE',
            pixelsquidFormat: 'psd'
        },
        { headers, timeout: 60000 }
    );
    
    console.log(`${CONFIG.logPrefix} İndirme URL'si alındı!`);
    return response.data.data.attributes.downloadUrl;
}

/**
 * Lisans al
 */
async function getLicense(itemId, csrfToken, cookieString) {
    console.log(`${CONFIG.logPrefix} Lisans alınıyor: ${itemId}`);
    
    const headers = {
        'content-type': 'application/json',
        'x-csrf-token': csrfToken,
        'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'cookie': cookieString
    };
    
    try {
        const licenseResponse = await axios.post(
            `https://elements.envato.com/api/v1/items/${itemId}/license.json`,
            {
                itemId: itemId,
                licenseType: 'project',
                pixelsquidFormat: 'psd',
                projectName: 'MYLICENSE'
            },
            { headers, timeout: 30000 }
        );
        
        const licenseUrl = licenseResponse.data.data.attributes.textDownloadUrl;
        const licenseContent = await axios.get(`https://elements.envato.com${licenseUrl}`, {
            headers: { cookie: cookieString },
            timeout: 30000
        });
        
        console.log(`${CONFIG.logPrefix} Lisans alındı!`);
        return licenseContent.data;
    } catch (e) {
        console.log(`${CONFIG.logPrefix} Lisans alınamadı: ${e.message}`);
        return null;
    }
}

/**
 * S3'e yükle (arka planda)
 */
async function uploadToS3(downloadUrl, itemId, licenseContent) {
    try {
        // Dosya adını belirle
        let fileName;
        if (downloadUrl.match(/%27%27(.*?)&Expires/)) {
            fileName = itemId + downloadUrl.match(/%27%27(.*?)&Expires/)[1];
        } else {
            fileName = itemId + downloadUrl.match(/.+\/(.*?)\?/)[1];
        }
        
        console.log(`${CONFIG.logPrefix} S3 yükleme başlıyor: ${fileName}`);
        
        // Lisansı S3'e yükle
        if (licenseContent) {
            await AwsS3.upload({
                Bucket: BUCKET_NAME,
                Key: licensePrefx + itemId + '.txt',
                Body: Buffer.from(licenseContent, 'utf8')
            }).promise();
            console.log(`${CONFIG.logPrefix} Lisans S3'e yüklendi!`);
        }
        
        // Dosyayı indir
        const tempDir = path.join(__dirname, 'tempFiles');
        if (!fs.existsSync(tempDir)) {
            fs.mkdirSync(tempDir, { recursive: true });
        }
        
        const dl = new DownloaderHelper(downloadUrl, tempDir, { fileName: fileName });
        
        dl.on('end', async () => {
            console.log(`${CONFIG.logPrefix} Dosya indirildi, zipleniyor...`);
            
            const zipPath = path.join(tempDir, itemId + '.zip');
            const output = fs.createWriteStream(zipPath);
            const archive = archiver('zip', { zlib: { level: 0 } });
            
            output.on('close', async () => {
                console.log(`${CONFIG.logPrefix} S3'e yükleniyor...`);
                
                await AwsS3.upload({
                    Bucket: BUCKET_NAME,
                    Key: servicePrefix + itemId + '.zip',
                    Body: fs.createReadStream(zipPath)
                }).promise();
                
                console.log(`${CONFIG.logPrefix} S3 yükleme tamamlandı!`);
                
                // Temizlik
                if (fs.existsSync(path.join(tempDir, fileName))) fs.unlinkSync(path.join(tempDir, fileName));
                if (fs.existsSync(zipPath)) fs.unlinkSync(zipPath);
            });
            
            archive.on('error', (err) => console.error(`${CONFIG.logPrefix} Zip hatası:`, err));
            archive.pipe(output);
            archive.append(fs.createReadStream(path.join(tempDir, fileName)), { name: fileName });
            archive.finalize();
        });
        
        dl.on('download', (stats) => {
            // 500MB limit
            if (stats.totalSize > 500000000) {
                console.log(`${CONFIG.logPrefix} Dosya çok büyük, S3 yükleme iptal!`);
                dl.stop();
            }
        });
        
        dl.on('error', (err) => console.error(`${CONFIG.logPrefix} İndirme hatası:`, err));
        
        await dl.start();
        
    } catch (e) {
        console.error(`${CONFIG.logPrefix} S3 yükleme hatası:`, e.message);
    }
}

/**
 * Ana fonksiyon - Her istekte login yap ve indir
 */
const getItemEnvatoElements = async (slugUrl) => {
    let browser = null;
    
    try {
        // URL'den item ID çıkar
        const slugMatch = slugUrl.match(/-([A-Z0-9]{6,})/);
        if (!slugMatch) {
            throw new Error('Geçersiz Envato Elements URL!');
        }
        const itemId = slugMatch[1];
        
        console.log(`${CONFIG.logPrefix} ========== YENİ İSTEK ==========`);
        console.log(`${CONFIG.logPrefix} URL: ${slugUrl}`);
        console.log(`${CONFIG.logPrefix} Item ID: ${itemId}`);
        
        // Önce S3'de var mı kontrol et
        try {
            await AwsS3.headObject({
                Bucket: BUCKET_NAME,
                Key: servicePrefix + itemId + '.zip'
            }).promise();
            
            // S3'de var, direkt URL döndür
            console.log(`${CONFIG.logPrefix} S3'de mevcut, cache'den döndürülüyor...`);
            const signedUrl = await new Promise((resolve, reject) => {
                AwsS3.getSignedUrl('getObject', {
                    Bucket: BUCKET_NAME,
                    Key: servicePrefix + itemId + '.zip',
                    Expires: 3600
                }, (err, url) => {
                    if (err) reject(err);
                    else resolve(url);
                });
            });
            
            return { success: true, url: signedUrl, cached: true };
            
        } catch (s3Err) {
            // S3'de yok, devam et
            console.log(`${CONFIG.logPrefix} S3'de yok, Envato'dan indirilecek...`);
        }
        
        // Browser başlat
        browser = await chromium.launch({
            headless: true,
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-gpu',
                '--disable-blink-features=AutomationControlled'
            ]
        });
        
        // 1. Login yap
        const loginResult = await loginToEnvato(browser);
        if (!loginResult.success) {
            throw new Error('Envato girişi başarısız!');
        }
        
        const { context, page } = loginResult;
        
        // 2. CSRF Token al
        const csrfToken = await getCsrfToken(page);
        
        // 3. Cookie string al
        const cookieString = await getCookieString(context);
        
        // 4. İçeriği indir
        const downloadUrl = await downloadItem(itemId, csrfToken, cookieString);
        
        // 5. Lisans al
        const licenseContent = await getLicense(itemId, csrfToken, cookieString);
        
        // 6. Browser'ı kapat
        await browser.close();
        browser = null;
        
        console.log(`${CONFIG.logPrefix} İndirme URL'si müşteriye döndürülüyor...`);
        
        // 7. S3'e yükle (arka planda)
        uploadToS3(downloadUrl, itemId, licenseContent).catch(e => {
            console.error(`${CONFIG.logPrefix} Arka plan S3 yükleme hatası:`, e.message);
        });
        
        return { success: true, url: downloadUrl };
        
    } catch (error) {
        console.error(`${CONFIG.logPrefix} HATA:`, error.message);
        
        if (browser) {
            try { await browser.close(); } catch (e) {}
        }
        
        throw error;
    }
};

module.exports = getItemEnvatoElements;
