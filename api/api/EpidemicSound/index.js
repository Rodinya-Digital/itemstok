const puppeteer = require('puppeteer');
const fs = require('fs');

const {
    getTypeCookie,
    updateTypeCookie
} = require('../../controllers/MysqlController');

// Cookie dosyasını yükleme
const loadCookies = async (page) => {
    const cookies = await getTypeCookie('epidemicsound');
    const cookiesx = JSON.parse(cookies.cookie);
    await page.setCookie(...cookiesx);
};

function clearLangPart(url) {
    // URL'yi parçalarına ayırıyoruz
    const urlParts = new URL(url);
    const pathSegments = urlParts.pathname.split('/').filter(Boolean); // Boş değerleri filtreliyoruz

    // Eğer ilk parametre 'track' ise işlem yapmayacağız
    if (pathSegments[0] === 'track') {
        return url; // URL zaten doğru, hiçbir işlem yapmıyoruz
    }
    if (pathSegments[0] === 'sound-effects') {
        return url; // URL zaten doğru, hiçbir işlem yapmıyoruz
    }

    // Eğer ilk parametre 'track' değilse, ilk segmenti kaldırıyoruz
    return urlParts.origin + '/' + pathSegments.slice(1).join('/') + '/';
}


const getItemEpidemicSound = async (url, format, type = false) => {

    return await new Promise(async (resolve,reject)=>{
        try{
            url = clearLangPart(url);



            // Tarayıcı başlatma
            const browser = await puppeteer.launch({headless: "new", args: ['--window-size=1920,1080', '--no-sandbox']}); // Tarayıcıyı görünür açmak için headless: false
            const page = await browser.newPage();
            await page.setViewport({width: 1920, height: 1080});
            await page._client().send('Page.setDownloadBehavior', {
                behavior: 'deny', // Bu satır ile indirmeyi devre dışı bırakabilirsiniz
                downloadPath: '' // İndirme dizinini boş yaparak devre dışı bırakma
            });
            console.log('E.S. => BROWSER OPENED !')
            await page.setDefaultTimeout(5000)
            // Cookie'leri yükle
            await loadCookies(page);

            console.log('E.S. => COOKIE IMPORTED !')

            // Belirtilen sayfaya git
            await page.goto(url);
            console.log('E.S. => OPENED PAGE !',url)
            // Sayfa tamamen yüklendikten sonra, indirme butonuna tıkla
            await page.waitForSelector('button[aria-label^="Download"]');
            await page.click('button[aria-label^="Download"]');
            console.log('E.S. => OPENED DOWNLAOD MODAL !')

            if (type && type !== 'full') {
                await page.waitForSelector('button[aria-haspopup="listbox"][id^="Stems"]');
                await page.click('button[aria-haspopup="listbox"][id^="Stems"]')
                await page.evaluate((type) => {
                    // 'id' si "Stems" ile başlayan 'ul' elementini seç
                    const dropdown = document.querySelector('ul[id^="Stems"]');

                    if (dropdown) {
                        // 'Bass' metnini içeren 'li' elementini bul ve tıkla
                        const bassOption = Array.from(dropdown.querySelectorAll('li')).find(li => li.innerText === type);
                        if (bassOption) {
                            bassOption.click();
                        }
                    }
                }, type);
            }

            console.log('E.S. => SELECTED CONTENT TYPE !')

            if (format && format !== 'WAV') {
                await page.waitForSelector('button[aria-haspopup="listbox"][id^="File-format"]');
                await page.click('button[aria-haspopup="listbox"][id^="File-format"]')
                await page.evaluate((format) => {
                    // 'id' si "Stems" ile başlayan 'ul' elementini seç
                    const dropdown = document.querySelector('ul[id^="File-format"]');

                    if (dropdown) {
                        // 'Bass' metnini içeren 'li' elementini bul ve tıkla
                        const bassOption = Array.from(dropdown.querySelectorAll('li')).find(li => li.innerText === format);
                        if (bassOption) {
                            bassOption.click();
                        }
                    }
                }, format);
            }

            console.log('E.S. => SELECTED MP3 OR WAV FORMAT !')
            // İndirme işlemi başlatacak butona tıkla
            await page.waitForSelector('[role="dialog"] button[aria-disabled="false"]'); // Download butonu
            await page.click('[role="dialog"] button[aria-disabled="false"]');

            console.log('E.S. => CLICKED DOWNLOAD BUTTON WAITING DOWNLOAD URL !')
            // Network üzerinden dosya indirme işlemini yakala
            page.on('response', async (response) => {
                const url = response.url();
                if (url.includes('.com/download/')) {  // İndirme işlemini yakalayacak
                    const newpagex = await browser.newPage();

                    const response = await newpagex.goto(url)

                    // Yanıtı JSON formatında alıyoruz
                    const responseBody = await response.json(); // Yanıtı JSON olarak işle
                    console.log('E.S. => COMPLATED !',responseBody)

                    resolve({
                        'success': true,
                        'url': responseBody.assetUrl
                    })
                    const cookiesNew = await page.cookies()
                    await updateTypeCookie('epidemicsound', JSON.stringify(cookiesNew));
                    await browser.close();
                    return true;
                }
            });
        }catch (e) {
            return reject(e);
        }
    })

}


module.exports = getItemEpidemicSound;