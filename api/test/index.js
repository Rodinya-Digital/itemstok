const puppeteer = require('puppeteer-extra');
const {executablePath} = require('puppeteer')
const path = require('path');
const fs = require('fs');
const cookieFile = require('./cookie.json');

const getLicense = async (cookieJson,slugId,type,pageNo=1) => {
    const fileLocation = '/tempFiles'
    const browser = await puppeteer.launch({
        headless: true,
        args: ['--window-size=1920,1080', '--no-sandbox'/*,'--proxy-server=193.17.6.121:443'*/],
        executablePath: executablePath()
    });
    const page = (await browser.pages())[0];
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');
    await page.setViewport({
        width: 1920, height: 1080,
    });
    /* await page.authenticate({
         username: 'root',
         password: 'master34',
     });*/

    const client = await page.target().createCDPSession()
    await client.send('Page.setDownloadBehavior', {
        behavior: 'allow',
        /*downloadPath: 'C:\\Users\\volty\\OneDrive\\Desktop\\freepik bot\\tempFiles',*/
        downloadPath: __dirname + fileLocation,
    })
    await page.setCookie(...cookieJson)

    console.log('## NEW FREEPIK MISSION -> GOTO :  ##')
    await page.goto('https://www.freepik.com/user/downloads?page='+pageNo+'&type='+type, {waitUntil: 'networkidle2'});

    await page.screenshot({path: __dirname + '/freepik_license_ss.png'})
    console.log('## FREEPIK GOTED LINK SS SAVED ##')

    await page.evaluate((slugId) => {
        let data = document.querySelector("[href*='"+slugId+"']").closest('tr')
        data.lastChild.lastChild.firstChild.click()
    },slugId);
    await page.waitForTimeout(3000);
    const filesAll = fs.readdirSync(__dirname + fileLocation)
    filesAll.forEach((v,i)=>{
        if(v.includes(slugId)){
            fs.rename(__dirname + fileLocation+'/'+v, __dirname + fileLocation+'/'+slugId+'.pdf', function(err) {
                if ( err ) console.log('ERROR: ' + err);
            });

        }
    })

}

getLicense(cookieFile,31562118,'regular')