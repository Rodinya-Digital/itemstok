const {chromium} = require('playwright');
const {updateTypeCookie, getTypeCookie} = require('../../controllers/MysqlController');
const fs   = require('fs');
const path = require('path');

/**
 * Freepik Download Manager
 * Modüler yapıda Freepik içeriklerini indirmek için kullanılır
 */
class FreepikDownloader {
    constructor(options = {}) {
        this.options = {
            headless: options.headless !== false, // default true
            viewport: options.viewport || {width: 1366, height: 768},
            userAgent: options.userAgent || 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
            locale: options.locale || 'tr-TR',
            timezoneId: options.timezoneId || 'Europe/Istanbul',
        };

        this.browser = null;
        this.context = null;
        this.usingCookieDB = null;
    }

    /**
     * Tarayıcıyı başlatır ve context'i hazırlar
     */
    async initialize() {
        this.browser = await chromium.launch({headless: this.options.headless});

        this.context = await this.browser.newContext({
            viewport: this.options.viewport,
            userAgent: this.options.userAgent,
            locale: this.options.locale,
            timezoneId: this.options.timezoneId
        });

        // ÖNCELİKLE cookie bilgisini al
        const cookies = await getTypeCookie('freepik');
        this.usingCookieDB = cookies;

        // SONRA çerezleri ekle
        await this.addCookies();
    }

    /**
     * Freepik çerezlerini context'e ekler
     */
    async addCookies() {
        // Null kontrolü ekle
        if (!this.usingCookieDB) {
            console.warn('Cookie bilgisi bulunamadı, çerezler eklenmedi.');
            return;
        }

        let cookies;
        try {
            cookies = JSON.parse(this.usingCookieDB.cookie);
        } catch (error) {
            console.error('Cookie parse hatası:', error);
            return;
        }

        // Array kontrolü ekle
        if (!Array.isArray(cookies)) {
            console.error('Cookies bir array değil:', cookies);
            return;
        }

        const normalizedCookies = cookies.map(cookie => {
            // Playwright, sameSite değerini 'Lax' | 'Strict' | 'None' olarak bekler
            let sameSite = 'Lax';
            const ss = String(cookie.sameSite || '').toLowerCase();
            if (ss === 'strict') sameSite = 'Strict';
            else if (ss === 'none') sameSite = 'None';

            return {
                name: cookie.name,
                value: cookie.value,
                domain: cookie.domain,
                path: cookie.path || '/',
                expires: cookie.expirationDate || -1,   // veya cookie.expires
                httpOnly: !!cookie.httpOnly,
                secure: !!cookie.secure,
                sameSite,                            // düzgün kapitalizasyonla
            };
        });

        await this.context.addCookies(normalizedCookies);
    }

    /**
     * Cookie string'ini oluşturur
     * @returns {Promise<string>} Cookie string
     */
    async getCookieString() {
        const cookies = await this.context.cookies();
        return cookies.map(c => `${c.name}=${c.value}`).join('; ');
    }

    async getCookieJson() {
        const cookies = await this.context.cookies();
        return cookies;
    }

    /**
     * Freepik içeriğini indirir
     * @param {string} url - Freepik URL'i
     * @param {Object} options - İndirme seçenekleri
     * @returns {Promise<Object>} İndirme sonucu
     */
    async download(url, options = {}) {
        let start = new Date();
        if (!this.context) {
            throw new Error('Downloader başlatılmamış. Önce initialize() metodunu çağırın.');
        }

        const cookieString = await this.getCookieString();

        const params = {};

        const headers = {
            'accept': '*/*',
            'accept-language': 'tr,en;q=0.9,ru;q=0.8,de;q=0.7,es;q=0.6',
            'cookie': cookieString,
            'priority': 'u=1, i',
            'referer': url,
            'sec-ch-ua': '"Google Chrome";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
            'sec-ch-ua-mobile': '?0',
            'sec-ch-ua-platform': '"Windows"',
            'sec-fetch-dest': 'empty',
            'sec-fetch-mode': 'cors',
            'sec-fetch-site': 'same-origin',
            'user-agent': this.options.userAgent
        };

        try {
            console.log('kullanılan db : '+this.usingCookieDB.name)
            url = url.replace('#walletId#', JSON.parse(this.usingCookieDB.detail_raw).wallet_id);
            const response = await this.context.request.get(
                url,
                {params, headers}
            );
            const raw = await response.text();
            fs.writeFileSync(
                path.resolve(__dirname, 'return.html'),
                raw,
                'utf8'
            );
            console.log('✅ return.html kaydedildi (API cevabı).SDFGSDFGSDFG');

            if (response.status() === 304) {
                return {status: 304, message: 'Not Modified'};
            }

            const data = await response.json();
            let end = new Date();
            const rCookie = await this.context.cookies();
            return {
                cookie: JSON.stringify(rCookie),
                ...data,
                time: (end - start) / 1000
            };

        } catch (error) {
            throw new Error(`İndirme hatası: ${error.message}`);
        } finally {
            try {
                await this.close();
                console.log("✅ HER DURUMDA TARAYICIYI KAPAT :) ")
            } catch (closeErr) {
                console.warn('Tarayıcı kapatılamadı:', closeErr);
            }
        }
    }

    /**
     * Tarayıcıyı kapatır
     */
    async close() {
        if (!this.context) {
            if (this.browser) {
                await this.browser.close();
            }
            return;
        }

        const cookieString = await this.getCookieString();
        const res = await this.context.request.get(
            'https://www.freepik.com/api/user/session',
            {
                headers: {
                    'accept': '*/*',
                    'accept-language': 'tr,en;q=0.9,ru;q=0.8,de;q=0.7,es;q=0.6',
                    'cookie': cookieString,
                    'priority': 'u=1, i',
                    'sec-ch-ua': '"Google Chrome";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
                    'sec-ch-ua-mobile': '?0',
                    'sec-ch-ua-platform': '"Windows"',
                    'sec-fetch-dest': 'empty',
                    'sec-fetch-mode': 'cors',
                    'sec-fetch-site': 'same-origin',
                    'user-agent': this.options.userAgent
                }
            }
        );

        const json = await res.json();
        await updateTypeCookie(this.usingCookieDB.name, await this.getCookieJson(), json.data);

        if (this.browser) {
            await this.browser.close();
            this.browser = null;
            this.context = null;
        }
    }
}


// Export
module.exports = FreepikDownloader;