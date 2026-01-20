/**
 * Envato Elements Cookie Refresher
 * 
 * Bu modul mevcut cookie'leri kullanarak Envato'ya periyodik olarak
 * baglanir ve session'i canli tutar. Cookie'ler expire olmadan once
 * yenilenir ve veritabanina kaydedilir.
 * 
 * Calisma mantigi:
 * 1. Her 15 dakikada bir calisir
 * 2. DB'den mevcut cookie'leri alir
 * 3. Playwright ile Envato'ya gider
 * 4. Sayfa yuklenince yeni cookie'leri alir
 * 5. DB'ye kaydeder
 */

const { chromium } = require('playwright');
const cron = require('node-cron');
const { getTypeCookie, updateTypeCookie } = require('../controllers/MysqlController');

// Konfigürasyon
const CONFIG = {
    // Her 15 dakikada bir calistir (*/15 * * * *)
    cronSchedule: '*/15 * * * *',
    
    // Envato Elements URL'leri
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
            '--disable-gpu'
        ]
    },
    
    // Timeout ayarlari (ms)
    navigationTimeout: 60000,
    waitTimeout: 10000,
    
    // Cookie refresh islemi aktif mi?
    enabled: true,
    
    // Log prefix
    logPrefix: '[ENVATO-REFRESH]'
};

/**
 * sameSite degerini Playwright formatina normalize et
 */
function normalizeSameSite(sameSite) {
    const ss = String(sameSite || '').toLowerCase();
    if (ss === 'strict') return 'Strict';
    if (ss === 'lax') return 'Lax';
    if (ss === 'none' || ss === 'no_restriction') return 'None';
    return 'Lax'; // Varsayilan
}

/**
 * Cookie'leri Playwright formatina donustur
 */
function formatCookiesForPlaywright(cookies) {
    return cookies.map(cookie => ({
        name: cookie.name,
        value: cookie.value,
        domain: cookie.domain || '.envato.com',
        path: cookie.path || '/',
        expires: cookie.expires ? Math.floor(new Date(cookie.expires).getTime() / 1000) : -1,
        httpOnly: cookie.httpOnly || false,
        secure: cookie.secure || false,
        sameSite: normalizeSameSite(cookie.sameSite)
    }));
}

/**
 * Tek bir hesabin cookie'lerini yenile
 */
async function refreshCookiesForAccount(accountName) {
    let browser = null;
    
    try {
        console.log(`${CONFIG.logPrefix} ${accountName} icin cookie yenileme basladi...`);
        
        // 1. DB'den mevcut cookie'leri al (dogrudan hesap adi ile)
        const accountData = await getTypeCookie(accountName);
        
        if (!accountData || !accountData.cookie) {
            console.log(`${CONFIG.logPrefix} ${accountName}: Cookie bulunamadi, atlaniyor.`);
            return { success: false, reason: 'no_cookie' };
        }
        
        let cookies;
        try {
            cookies = JSON.parse(accountData.cookie);
        } catch (e) {
            console.log(`${CONFIG.logPrefix} ${accountName}: Cookie parse hatasi, atlaniyor.`);
            return { success: false, reason: 'parse_error' };
        }
        
        if (!Array.isArray(cookies) || cookies.length < 3) {
            console.log(`${CONFIG.logPrefix} ${accountName}: Yetersiz cookie sayisi (${cookies?.length || 0}), atlaniyor.`);
            return { success: false, reason: 'insufficient_cookies' };
        }
        
        // 2. Playwright browser baslat
        browser = await chromium.launch(CONFIG.browserOptions);
        const context = await browser.newContext({
            userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            viewport: { width: 1920, height: 1080 }
        });
        
        // 3. Mevcut cookie'leri ekle
        const formattedCookies = formatCookiesForPlaywright(cookies);
        await context.addCookies(formattedCookies);
        
        // 4. Sayfaya git
        const page = await context.newPage();
        page.setDefaultTimeout(CONFIG.navigationTimeout);
        
        console.log(`${CONFIG.logPrefix} ${accountName}: Envato'ya baglaniliyor...`);
        
        await page.goto(CONFIG.targetUrl, {
            waitUntil: 'domcontentloaded',
            timeout: CONFIG.navigationTimeout
        });
        
        // 5. Sayfanin yuklenmesini bekle
        await page.waitForTimeout(CONFIG.waitTimeout);
        
        // 6. Login durumunu kontrol et
        const currentUrl = page.url();
        if (currentUrl.includes('sign_in') || currentUrl.includes('login')) {
            console.log(`${CONFIG.logPrefix} ${accountName}: Session expire olmus, login sayfasina yonlendirildi.`);
            await browser.close();
            return { success: false, reason: 'session_expired' };
        }
        
        // 7. Yeni cookie'leri al
        const newCookies = await context.cookies();
        
        // 8. KRITIK COOKIE'LERI KORU, sadece Cloudflare ve session cookie'lerini guncelle
        // HttpOnly olan envatoid, elements.session.5 gibi cookie'ler Playwright ile alinamaz
        const criticalCookieNames = ['envatoid', 'envato_client_id'];
        
        // Orijinal kritik cookie'leri koru
        const originalCritical = cookies.filter(c => criticalCookieNames.includes(c.name));
        
        // Yeni cookie'lerden kritik olmayanlari al
        const newNonCritical = newCookies.filter(c => !criticalCookieNames.includes(c.name));
        
        // Birlesik cookie listesi: orijinal kritikler + yeni diger cookie'ler
        const mergedCookies = [...originalCritical, ...newNonCritical];
        
        // DB'ye kaydet
        const cookieJson = JSON.stringify(mergedCookies);
        await updateTypeCookie(accountName, cookieJson);
        
        console.log(`${CONFIG.logPrefix} ${accountName}: Cookie'ler guncellendi! (${originalCritical.length} kritik korundu, ${newNonCritical.length} yenilendi)`);
        
        await browser.close();
        return { success: true, message: 'Cookies refreshed', criticalPreserved: originalCritical.length, refreshed: newNonCritical.length };
        
    } catch (error) {
        console.error(`${CONFIG.logPrefix} ${accountName}: Hata - ${error.message}`);
        if (browser) {
            try { await browser.close(); } catch (e) {}
        }
        return { success: false, reason: 'error', error: error.message };
    }
}

/**
 * Tum Envato Elements hesaplarinin cookie'lerini yenile
 */
async function refreshAllEnvatoCookies() {
    if (!CONFIG.enabled) {
        console.log(`${CONFIG.logPrefix} Cookie refresh devre disi.`);
        return;
    }
    
    console.log(`${CONFIG.logPrefix} ========== Cookie Refresh Basladi ==========`);
    const startTime = Date.now();
    
    const accounts = ['envatoelements1', 'envatoelements2'];
    const results = {};
    
    for (const account of accounts) {
        results[account] = await refreshCookiesForAccount(account);
        // Hesaplar arasi kisa bekleme (rate limiting onlemi)
        await new Promise(resolve => setTimeout(resolve, 5000));
    }
    
    const duration = ((Date.now() - startTime) / 1000).toFixed(2);
    console.log(`${CONFIG.logPrefix} ========== Cookie Refresh Tamamlandi (${duration}s) ==========`);
    console.log(`${CONFIG.logPrefix} Sonuclar:`, JSON.stringify(results));
    
    return results;
}

/**
 * Cron job'i baslat
 */
function startCronJob() {
    console.log(`${CONFIG.logPrefix} Cron job baslatiliyor... (Schedule: ${CONFIG.cronSchedule})`);
    
    // Cron job'i olustur
    const job = cron.schedule(CONFIG.cronSchedule, async () => {
        console.log(`${CONFIG.logPrefix} Zamanlanmis cookie refresh tetiklendi.`);
        await refreshAllEnvatoCookies();
    }, {
        scheduled: true,
        timezone: 'Europe/Istanbul'
    });
    
    console.log(`${CONFIG.logPrefix} Cron job aktif! Her 15 dakikada bir calisacak.`);
    
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
        targetUrl: CONFIG.targetUrl
    };
}

module.exports = {
    startCronJob,
    manualRefresh,
    refreshAllEnvatoCookies,
    refreshCookiesForAccount,
    disable,
    enable,
    getStatus
};
