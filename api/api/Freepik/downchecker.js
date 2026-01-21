const puppeteer = require('puppeteer-extra');
const StealthPlugin = require('puppeteer-extra-plugin-stealth')
puppeteer.use(StealthPlugin())
const {executablePath} = require('puppeteer')
const axios = require('axios');

const {
    updateTypeCookie,
    getFreepikAccountsCookies
} = require('../../controllers/MysqlController');

async function getFreepikDownChecker() {
    try {
        const accounts = await getFreepikAccountsCookies();

        for (const account of accounts) {
            const browser = await puppeteer.launch({
                headless: "new",
                args: ['--window-size=1920,1080', '--disable-setuid-sandbox', '--no-sandbox'],
                executablePath: executablePath()
            });

            try {
                const page = await browser.newPage();
                const oldCookies = JSON.parse(account.cookie);
                await page.setCookie(...oldCookies);
                await page.goto('https://www.freepik.com', { waitUntil: 'networkidle0' });

                // Yeni cookieleri al
                const newCookies = await page.cookies();

                // Axios için header'da kullanılacak formatta string oluştur
                const cookieHeader = newCookies.map(c => `${c.name}=${c.value}`).join('; ');


                // Güncel cookieler ile axios isteği
                try {
                    const response = await axios.get('https://www.freepik.com/api/user/session', {
                        params: {  },
                        headers: {
                            'accept': '*/*',
                            'accept-language': 'tr,en;q=0.9,ru;q=0.8,de;q=0.7,es;q=0.6',
                            'cookie': cookieHeader,
                            'priority': 'u=1, i',
                            'sec-ch-ua': '"Google Chrome";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
                            'sec-ch-ua-mobile': '?0',
                            'sec-ch-ua-platform': '"Windows"',
                            'sec-fetch-dest': 'empty',
                            'sec-fetch-mode': 'cors',
                            'sec-fetch-site': 'same-origin',
                            'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36'
                        }
                    });

                    //console.log('Download limit:', response.data);
                    await updateTypeCookie(account.name, JSON.stringify(newCookies), response.data.data);
                } catch (error) {
                    console.log('User Limit Error:', error?.response?.status);
                }

                await page.close();
            } catch (error) {
                console.error(`Error checking account: ${error.message}`);
            } finally {
                await browser.close();
            }
        }

    } catch (error) {
        console.error('Database Error:', error);
    } finally {
        console.log('Freepik DownChecker Finished');
        setTimeout(() => {
            getFreepikDownChecker()
        }, 300000)
    }
}


module.exports = {
    getFreepikDownChecker
}