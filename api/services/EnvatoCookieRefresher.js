/**
 * Envato Elements Cookie Refresher - v2.0 (Auto Login)
 * 
 * Bu modul Envato'ya otomatik giris yaparak tum cookie'leri
 * (HttpOnly dahil) alir ve veritabanina kaydeder.
 * 
 * Calisma mantigi:
 * 1. Her 6 saatte bir calisir (veya session expire oldugunda)
 * 2. Login sayfasina gider
 * 3. Email/sifre ile giris yapar
 * 4. Tum cookie'leri alir (HttpOnly dahil)
 * 5. DB'ye kaydeder
 */

const { chromium } = require('playwright');
const cron = require('node-cron');
const { getTypeCookie, updateTypeCookie } = require('../controllers/MysqlController');

// Envato Hesap Bilgileri
const ENVATO_CREDENTIALS = {
    email: process.env.ENVATO_EMAIL || 'rodinyatools@rodinyadijital.com',
    password: process.env.ENVATO_PASSWORD || 'Oguzhan99.'
};

// Konfigürasyon
const CONFIG = {
    // Her 6 saatte bir calistir (session sure asimi oncesi)
    cronSchedule: '0 */6 * * *',
    
    // Envato Elements URL'leri
    loginUrl: 'https://account.envato.com/sign_in?to=elements',
    targetUrl: 'https://elements.envato.com/account',
    baseUrl: 'https://elements.envato.com',
    
    // Playwright ayarlari
    browserOptions: {
        headless: true,
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--disable-accelerated-2d-canvas',
            '--no-first-run',
            '--no-zygote',
            '--disable-gpu',
            '--disable-blink-features=AutomationControlled'
        ]
    },
    
    // Timeout ayarlari (ms)
    navigationTimeout: 90000,
    waitTimeout: 15000,
    loginTimeout: 60000,
    
    // Cookie refresh islemi aktif mi?
    enabled: true,
    
    // Log prefix
    logPrefix: '[ENVATO-LOGIN]'
};

/**
 * Rastgele bekleme suresi olustur (insan davranisi simulasyonu)
 */
function randomDelay(min = 1000, max = 3000) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

/**
 * Insan benzeri yazmak icin karakter karakter yaz
 */
async function humanType(page, selector, text) {
    await page.click(selector);
    await page.waitForTimeout(randomDelay(300, 600));
    
    for (const char of text) {
        await page.type(selector, char, { delay: randomDelay(50, 150) });
    }
}

/**
 * Envato'ya giris yap ve tum cookie'leri al (HttpOnly dahil)
 */
async function loginAndGetCookies(accountName) {
    let browser = null;
    
    try {
        console.log(`${CONFIG.logPrefix} ${accountName} icin LOGIN basladi...`);
        
        // 1. Playwright browser baslat (stealth mode)
        browser = await chromium.launch(CONFIG.browserOptions);
        const context = await browser.newContext({
            userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            viewport: { width: 1920, height: 1080 },
            locale: 'en-US',
            timezoneId: 'Europe/Istanbul',
            // Automation detection'i bypass et
            extraHTTPHeaders: {
                'Accept-Language': 'en-US,en;q=0.9,tr;q=0.8'
            }
        });
        
        // Automation flag'lerini gizle
        await context.addInitScript(() => {
            Object.defineProperty(navigator, 'webdriver', { get: () => false });
            Object.defineProperty(navigator, 'plugins', { get: () => [1, 2, 3, 4, 5] });
            Object.defineProperty(navigator, 'languages', { get: () => ['en-US', 'en', 'tr'] });
            window.chrome = { runtime: {} };
        });
        
        const page = await context.newPage();
        page.setDefaultTimeout(CONFIG.navigationTimeout);
        
        // 2. Login sayfasina git
        console.log(`${CONFIG.logPrefix} Login sayfasina gidiliyor...`);
        await page.goto(CONFIG.loginUrl, {
            waitUntil: 'networkidle',
            timeout: CONFIG.navigationTimeout
        });
        
        await page.waitForTimeout(randomDelay(2000, 4000));
        
        // 3. Zaten giris yapilmis mi kontrol et
        const currentUrl = page.url();
        if (currentUrl.includes('elements.envato.com') && !currentUrl.includes('sign_in')) {
            console.log(`${CONFIG.logPrefix} Zaten giris yapilmis!`);
        } else {
            // 4. Email gir
            console.log(`${CONFIG.logPrefix} Email giriliyor...`);
            const emailSelector = 'input[name="user[login]"], input[type="email"], #user_login';
            await page.waitForSelector(emailSelector, { timeout: CONFIG.loginTimeout });
            await humanType(page, emailSelector, ENVATO_CREDENTIALS.email);
            
            await page.waitForTimeout(randomDelay(500, 1000));
            
            // 5. Sifre gir
            console.log(`${CONFIG.logPrefix} Sifre giriliyor...`);
            const passwordSelector = 'input[name="user[password]"], input[type="password"], #user_password';
            await page.waitForSelector(passwordSelector, { timeout: CONFIG.loginTimeout });
            await humanType(page, passwordSelector, ENVATO_CREDENTIALS.password);
            
            await page.waitForTimeout(randomDelay(500, 1500));
            
            // 6. Giris butonuna tikla
            console.log(`${CONFIG.logPrefix} Giris butonuna tiklaniyor...`);
            const submitSelector = 'button[type="submit"], input[type="submit"], .btn-submit, [data-testid="sign-in-button"]';
            await page.click(submitSelector);
            
            // 7. Giris sonrasi bekle
            console.log(`${CONFIG.logPrefix} Giris sonrasi bekleniyor...`);
            await page.waitForNavigation({ 
                waitUntil: 'networkidle',
                timeout: CONFIG.navigationTimeout 
            }).catch(() => {});
            
            await page.waitForTimeout(randomDelay(3000, 5000));
        }
        
        // 8. Elements sayfasina git (cookie'lerin tam olusması icin)
        console.log(`${CONFIG.logPrefix} Elements sayfasina gidiliyor...`);
        await page.goto(CONFIG.baseUrl, {
            waitUntil: 'networkidle',
            timeout: CONFIG.navigationTimeout
        });
        
        await page.waitForTimeout(randomDelay(2000, 4000));
        
        // 9. Account sayfasina git
        await page.goto(CONFIG.targetUrl, {
            waitUntil: 'networkidle',
            timeout: CONFIG.navigationTimeout
        });
        
        await page.waitForTimeout(randomDelay(2000, 3000));
        
        // 10. Giris basarili mi kontrol et
        const finalUrl = page.url();
        if (finalUrl.includes('sign_in') || finalUrl.includes('login')) {
            console.error(`${CONFIG.logPrefix} GIRIS BASARISIZ! Hala login sayfasinda.`);
            
            // Screenshot al (debug icin)
            await page.screenshot({ path: '/app/api/services/login_failed.png' });
            
            await browser.close();
            return { success: false, reason: 'login_failed', message: 'Giris yapilamadi, sifre veya email yanlis olabilir.' };
        }
        
        // 11. TUM cookie'leri al (HttpOnly dahil!)
        console.log(`${CONFIG.logPrefix} Cookie'ler aliniyor...`);
        const allCookies = await context.cookies();
        
        // 12. Cookie'leri filtrele (sadece envato domain'leri)
        const envatoCookies = allCookies.filter(c => 
            c.domain.includes('envato.com') || 
            c.domain.includes('.envato.com')
        );
        
        console.log(`${CONFIG.logPrefix} Toplam ${envatoCookies.length} cookie alindi.`);
        
        // Kritik cookie'lerin varligini kontrol et
        const hasEnvatoId = envatoCookies.some(c => c.name === 'envatoid');
        const hasSession = envatoCookies.some(c => c.name.includes('session'));
        
        console.log(`${CONFIG.logPrefix} Kritik cookie'ler: envatoid=${hasEnvatoId}, session=${hasSession}`);
        
        if (!hasEnvatoId) {
            console.warn(`${CONFIG.logPrefix} UYARI: envatoid cookie'si bulunamadi!`);
        }
        
        // 13. DB'ye kaydet
        const cookieJson = JSON.stringify(envatoCookies);
        await updateTypeCookie(accountName, cookieJson);
        
        console.log(`${CONFIG.logPrefix} ${accountName}: Cookie'ler basariyla kaydedildi! (${envatoCookies.length} cookie)`);
        
        // Basari screenshot'i (debug icin)
        await page.screenshot({ path: '/app/api/services/login_success.png' });
        
        await browser.close();
        return { 
            success: true, 
            message: 'Login basarili, cookie\'ler kaydedildi', 
            cookieCount: envatoCookies.length,
            hasEnvatoId,
            hasSession
        };
        
    } catch (error) {
        console.error(`${CONFIG.logPrefix} ${accountName}: LOGIN HATASI - ${error.message}`);
        if (browser) {
            try { await browser.close(); } catch (e) {}
        }
        return { success: false, reason: 'error', error: error.message };
    }
}

/**
 * Mevcut cookie'lerle session'i kontrol et, gerekirse login yap
 */
async function refreshCookiesForAccount(accountName) {
    let browser = null;
    
    try {
        console.log(`${CONFIG.logPrefix} ${accountName} icin cookie kontrolu basladi...`);
        
        // 1. Oncelikle mevcut cookie'lerle dene
        const accountData = await getTypeCookie(accountName);
        
        // Cookie yoksa veya cok azsa direkt login yap
        if (!accountData || !accountData.cookie) {
            console.log(`${CONFIG.logPrefix} ${accountName}: Cookie bulunamadi, LOGIN yapiliyor...`);
            return await loginAndGetCookies(accountName);
        }
        
        let cookies;
        try {
            cookies = JSON.parse(accountData.cookie);
        } catch (e) {
            console.log(`${CONFIG.logPrefix} ${accountName}: Cookie parse hatasi, LOGIN yapiliyor...`);
            return await loginAndGetCookies(accountName);
        }
        
        if (!Array.isArray(cookies) || cookies.length < 3) {
            console.log(`${CONFIG.logPrefix} ${accountName}: Yetersiz cookie, LOGIN yapiliyor...`);
            return await loginAndGetCookies(accountName);
        }
        
        // 2. Mevcut cookie'lerle session test et
        browser = await chromium.launch(CONFIG.browserOptions);
        const context = await browser.newContext({
            userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            viewport: { width: 1920, height: 1080 }
        });
        
        // Cookie'leri formatla ve ekle
        const formattedCookies = cookies.map(cookie => ({
            name: cookie.name,
            value: cookie.value,
            domain: cookie.domain || '.envato.com',
            path: cookie.path || '/',
            expires: cookie.expires ? Math.floor(new Date(cookie.expires).getTime() / 1000) : -1,
            httpOnly: cookie.httpOnly || false,
            secure: cookie.secure || false,
            sameSite: 'Lax'
        }));
        
        await context.addCookies(formattedCookies);
        
        const page = await context.newPage();
        page.setDefaultTimeout(CONFIG.navigationTimeout);
        
        console.log(`${CONFIG.logPrefix} ${accountName}: Session test ediliyor...`);
        
        await page.goto(CONFIG.targetUrl, {
            waitUntil: 'domcontentloaded',
            timeout: CONFIG.navigationTimeout
        });
        
        await page.waitForTimeout(5000);
        
        // 3. Session gecerli mi kontrol et
        const currentUrl = page.url();
        await browser.close();
        
        if (currentUrl.includes('sign_in') || currentUrl.includes('login')) {
            console.log(`${CONFIG.logPrefix} ${accountName}: Session EXPIRE olmus, yeniden LOGIN yapiliyor...`);
            return await loginAndGetCookies(accountName);
        }
        
        console.log(`${CONFIG.logPrefix} ${accountName}: Session GECERLI, cookie yenileme gerekmiyor.`);
        return { success: true, message: 'Session hala gecerli', needsLogin: false };
        
    } catch (error) {
        console.error(`${CONFIG.logPrefix} ${accountName}: Hata - ${error.message}`);
        if (browser) {
            try { await browser.close(); } catch (e) {}
        }
        // Hata durumunda login dene
        console.log(`${CONFIG.logPrefix} ${accountName}: Hata nedeniyle LOGIN deneniyor...`);
        return await loginAndGetCookies(accountName);
    }
}

/**
 * Tum Envato Elements hesaplarinin cookie'lerini yenile/login yap
 */
async function refreshAllEnvatoCookies() {
    if (!CONFIG.enabled) {
        console.log(`${CONFIG.logPrefix} Cookie refresh devre disi.`);
        return;
    }
    
    console.log(`${CONFIG.logPrefix} ========== Cookie Refresh/Login Basladi ==========`);
    const startTime = Date.now();
    
    // Not: Tek hesap kullaniliyor, iki hesap icin duplicate yapilabilir
    const accounts = ['envatoelements1', 'envatoelements2'];
    const results = {};
    
    for (const account of accounts) {
        results[account] = await refreshCookiesForAccount(account);
        // Hesaplar arasi bekleme (rate limiting onlemi)
        await new Promise(resolve => setTimeout(resolve, 10000));
    }
    
    const duration = ((Date.now() - startTime) / 1000).toFixed(2);
    console.log(`${CONFIG.logPrefix} ========== Cookie Refresh/Login Tamamlandi (${duration}s) ==========`);
    console.log(`${CONFIG.logPrefix} Sonuclar:`, JSON.stringify(results, null, 2));
    
    return results;
}

/**
 * Sadece login yap (manuel tetikleme icin)
 */
async function forceLogin(accountName = 'envatoelements1') {
    console.log(`${CONFIG.logPrefix} ZORLA LOGIN tetiklendi: ${accountName}`);
    return await loginAndGetCookies(accountName);
}

/**
 * Cron job'i baslat
 */
function startCronJob() {
    console.log(`${CONFIG.logPrefix} Cron job baslatiliyor... (Schedule: ${CONFIG.cronSchedule})`);
    
    // Cron job'i olustur
    const job = cron.schedule(CONFIG.cronSchedule, async () => {
        console.log(`${CONFIG.logPrefix} Zamanlanmis cookie refresh/login tetiklendi.`);
        await refreshAllEnvatoCookies();
    }, {
        scheduled: true,
        timezone: 'Europe/Istanbul'
    });
    
    console.log(`${CONFIG.logPrefix} Cron job aktif! Her 6 saatte bir calisacak.`);
    
    // Baslangicta bir kez calistir (5 saniye sonra)
    setTimeout(async () => {
        console.log(`${CONFIG.logPrefix} Baslangic kontrolu yapiliyor...`);
        await refreshAllEnvatoCookies();
    }, 5000);
    
    return job;
}

/**
 * Manuel refresh tetikle (test icin)
 */
async function manualRefresh() {
    console.log(`${CONFIG.logPrefix} Manuel refresh tetiklendi.`);
    return await refreshAllEnvatoCookies();
}

/**
 * Cookie refresh'i devre disi birak
 */
function disable() {
    CONFIG.enabled = false;
    console.log(`${CONFIG.logPrefix} Cookie refresh devre disi birakildi.`);
}

/**
 * Cookie refresh'i etkinlestir
 */
function enable() {
    CONFIG.enabled = true;
    console.log(`${CONFIG.logPrefix} Cookie refresh etkinlestirildi.`);
}

/**
 * Durum bilgisi al
 */
function getStatus() {
    return {
        enabled: CONFIG.enabled,
        schedule: CONFIG.cronSchedule,
        loginUrl: CONFIG.loginUrl,
        targetUrl: CONFIG.targetUrl,
        credentials: {
            email: ENVATO_CREDENTIALS.email,
            passwordSet: !!ENVATO_CREDENTIALS.password
        }
    };
}

module.exports = {
    startCronJob,
    manualRefresh,
    refreshAllEnvatoCookies,
    refreshCookiesForAccount,
    loginAndGetCookies,
    forceLogin,
    disable,
    enable,
    getStatus
};
