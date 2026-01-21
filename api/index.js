const express = require('express');
const app = express();
var os = require('os');
const fs = require('fs');
const path = require('path');
const TelegramBot = require("node-telegram-bot-api")
const getItemEnvatoElements = require('./api/EnvatoElements/index');
const https = require('https'); // Eğer https kullanıyorsanız, http yerine https modülünü kullanın

const getItemFreepik = require('./api/Freepik/index');
const {getFreepikDownChecker} = require('./api/Freepik/downchecker');
const {LC_Freepık_Engine} = require('./api/Freepik/license')

const getItemMotionArray = require('./api/MotionArray/index');
const getItemShutterStock = require('./api/ShutterStock/index');

const cheerio = require('cheerio');

const getItemEpidemicSound = require('./api/EpidemicSound/index');
const getItemFlaticon = require('./api/Flaticon/index');

// Envato Cookie Refresher - Session'lari canli tutar
const EnvatoCookieRefresher = require('./services/EnvatoCookieRefresher');

// Merkezi Credentials Config
const { S3_CONFIG, API_KEY, TELEGRAM_CONFIG, validateApiKey } = require('./config/credentials');

const {
    getGoFilesFile,
    getTypeCookie
} = require('./controllers/MysqlController');
var axios = require('axios');
var FormData = require('form-data');

// AWS S3 - Merkezi config kullan
const AWS = require('aws-sdk');
const spacesEndpoint = new AWS.Endpoint(S3_CONFIG.endpoint);
const BUCKET_NAME = S3_CONFIG.bucketName;
const AwsS3 = new AWS.S3({
    endpoint: spacesEndpoint,
    accessKeyId: S3_CONFIG.accessKeyId,
    secretAccessKey: S3_CONFIG.secretAccessKey
});

setInterval(async () => {
    try {
        await LC_Freepık_Engine()
    } catch (e) {
        console.log('index freepik license downlaoder error')
        console.log(e)
    }
}, 60000)

// Envato Cookie Refresher Cron Job'ini baslat (her 15 dakikada bir)
try {
    EnvatoCookieRefresher.startCronJob();
    console.log('[SYSTEM] Envato Cookie Refresher baslatildi.');
} catch (e) {
    console.log('[SYSTEM] Envato Cookie Refresher baslatilamadi:', e.message);
}

const NotificationSMS = (message) => {
    // Telegram Bot - Merkezi config kullan
    const bot = new TelegramBot(TELEGRAM_CONFIG.token, {polling: false});
    bot.sendMessage(TELEGRAM_CONFIG.chatId, message.replaceAll('\\n', '%0A'));
}


app.get('/stats', async (req, res) => {
    await LC_Freepık_Engine()
    const files = getDirectories(__dirname + '/api');
    const lastModified = files.sort((a, b) => b.modified - a.modified);
    let data = {
        'os': os.type() + ' ' + os.release() + ' ' + os.machine(),
        'mem': {
            'total': formatBytes(os.totalmem(), 2),
            'free': formatBytes(os.freemem(), 2),
            'used': formatBytes(os.totalmem() - os.freemem(), 2),
        },
        'uptime': secondsToWords(os.uptime()),
        'load': os.loadavg(),
        'hostname': os.hostname(),
        'lastUpdate': new Date(lastModified[0].modified).toLocaleString()
    };
    return res.json(data);
})

app.get('/lastChange', async (req, res) => {
    const files = getDirectories(__dirname + '/api');
    const lastModified = files.sort((a, b) => b.modified - a.modified);
    return res.send(new Date(lastModified[0].modified).toLocaleString())
})

// Envato Cookie Refresh Manuel Tetikleme Endpoint'i
app.get('/envato-refresh', async (req, res) => {
    const key = req.query.key;
    if (key !== 'sdasdas333') {
        return res.json({ success: false, error: 'Invalid key' });
    }
    
    try {
        console.log('[API] Manuel Envato cookie refresh tetiklendi...');
        const result = await EnvatoCookieRefresher.manualRefresh();
        return res.json({ success: true, result: result });
    } catch (e) {
        console.error('[API] Envato refresh hatasi:', e.message);
        return res.json({ success: false, error: e.message });
    }
})

// Envato Cookie Refresh Durum Endpoint'i
app.get('/envato-refresh-status', async (req, res) => {
    const status = EnvatoCookieRefresher.getStatus();
    return res.json({ success: true, status: status });
})
// Envato ZORLA LOGIN Endpoint'i (Yeni cookie almak icin)
app.get('/envato-force-login', async (req, res) => {
    const key = req.query.key;
    if (!validateApiKey(key)) {
        return res.json({ success: false, error: 'Invalid key' });
    }
    
    const account = req.query.account || 'envatoelements1';
    
    try {
        console.log('[API] Envato ZORLA LOGIN tetiklendi: ' + account);
        const result = await EnvatoCookieRefresher.forceLogin(account);
        return res.json({ success: true, result: result });
    } catch (e) {
        console.error('[API] Envato force login hatasi:', e.message);
        return res.json({ success: false, error: e.message });
    }
})

function cleanURL(url) {
    try {
        // URL nesnesini oluştur
        const parsedUrl = new URL(url);

        // URL'nin temel yapısını döndür (parametreler hariç)
        return `${parsedUrl.origin}${parsedUrl.pathname}`;
    } catch (error) {
        console.error('Geçersiz URL:', error);
        return null;
    }
}

app.get('/stream-video', (req, res) => {
    // URL parametresinden 'url' parametresini al
    const fileUrl = req.query.url;
    if (!fileUrl) {
        return res.status(400).send('URL parametresi eksik.');
    }

    // URL parametrelerini parçala (filename parametresi gibi)
    const parsedUrl = new URL(fileUrl);
    const filename = parsedUrl.searchParams.get('filename') || 'HATALI_ERROR.mp4';

    // Dosya uzantısını kontrol et ve uygun content-type belirle
    const fileExtension = path.extname(filename).toLowerCase();
    let contentType = 'application/octet-stream'; // Varsayılan content type

    if (fileExtension === '.mp4') {
        contentType = 'video/mp4';
    } else if (fileExtension === '.mov') {
        contentType = 'video/quicktime';
    } else if (fileExtension === '.avi') {
        contentType = 'video/x-msvideo';
    } else if (fileExtension === '.mkv') {
        contentType = 'video/x-matroska';
    }

    // Dosya türünü ayarlayın
    res.setHeader('Content-Type', contentType);
    res.setHeader('Content-Disposition', `attachment; filename="${filename}"`);
    res.setHeader('Cache-Control', 'no-cache'); // Tarayıcı önbelleklemesini engelle

    // Uzak dosyaya HTTP GET isteği gönder
    https.get(fileUrl, (remoteStream) => {
        // Eğer uzak kaynaktan veri akışında bir hata oluşursa
        remoteStream.on('error', (err) => {
            console.error('Uzak kaynağa bağlanırken hata oluştu:', err);
            res.status(500).send('Dosya alınırken bir hata oluştu.');
        });

        // Veriyi doğrudan istemciye aktar
        remoteStream.pipe(res);

    }).on('error', (err) => {
        console.error('Uzak kaynağa bağlanırken hata oluştu:', err);
        res.status(500).send('Dosya alınırken bir hata oluştu.');
    });
});


app.get('/', async function (req, res) {
    await LC_Freepık_Engine()
    let key, dw, url, user_id, videoSelected


    key = req.query.key
    dw = req.query.dw
    url = req.query.url

    videoSelected = req.query.videoselected || false;
    console.log('Video Type Selected ? : ', req.query.videoselected)

    console.log('KEY : ', dw, url, user_id, videoSelected)


    if (key !== "sdasdas333") {
        return res.json({"success": false, "result": "Invalid Key !"})
    }
    switch (dw) {
        case 'licenseCenter':
            if (url.indexOf('elements.envato.com/') !== -1) {
                if ((url.match(/-([A-Z0-9]{6,})/)) !== null) {
                    let slugID = url.match(/-([A-Z0-9]{6,})/)[1];
                    AwsS3.headObject({
                        Bucket: BUCKET_NAME, Key: 'ee_l/' + slugID + '.txt'
                    }, async function (err, metadata) {
                        if (err && err.code === 'NotFound') {
                            return res.json({
                                "success": false,
                                "error": "Lisans dosyası bulunamadı, lisans dosyası oluşması için içeriğin daha önce indirilmiş olması gerekmektedir."
                            })
                        } else {
                            console.log('ENVATO ELEMENTS LICENSE S3 HAVE...');
                            AwsS3.getSignedUrl('getObject', {
                                Bucket: BUCKET_NAME, Key: 'ee_l/' + slugID + '.txt', Expires: 3600
                            }, (err, url) => {
                                console.log('ENVATO ELEMENTS LICENSE S3 HAVE RETURNED')
                                return res.json({success: true, url: url})
                            });
                        }
                    });
                } else {
                    return res.json({
                        "success": false,
                        "error": "invalid url! Please content url insert!"
                    })
                }
            } else if (url.indexOf('freepik.com/') !== -1) {
                if ((url.match(/_(\d+)/)) !== null) {
                    let slugID = url.match(/_(\d+)/)[1];
                    AwsS3.headObject({
                        Bucket: BUCKET_NAME, Key: 'fp_l/' + slugID + '.pdf'
                    }, async function (err, metadata) {
                        if (err && err.code === 'NotFound') {
                            return res.json({
                                "success": false,
                                "error": "Lisans dosyası bulunamadı, lisans dosyası oluşması için içeriğin daha önce indirilmiş olması gerekmektedir."
                            })
                        } else {
                            console.log('FREEPIK LICENSE S3 HAVE...');
                            AwsS3.getSignedUrl('getObject', {
                                Bucket: BUCKET_NAME, Key: 'fp_l/' + slugID + '.pdf', Expires: 3600
                            }, (err, url) => {
                                console.log('FREEPIK LICENSE S3 HAVE RETURNED')
                                return res.json({success: true, url: url})
                            });
                        }
                    });
                } else {
                    return res.json({
                        "success": false,
                        "error": "invalid url! Please content url insert!"
                    })
                }
            } else if (url.indexOf('motionarray.com/') !== -1) {
                url = cleanURL(url);
                if ((url.match(/-(\d+)/gm)[url.match(/-(\d+)/gm).length - 1]).replace('-', '') !== null) {
                    let slugID = (url.match(/-(\d+)/gm)[url.match(/-(\d+)/gm).length - 1]).replace('-', '');
                    AwsS3.headObject({
                        Bucket: BUCKET_NAME, Key: 'ma_l/' + slugID + '.pdf'
                    }, async function (err, metadata) {
                        if (err && err.code === 'NotFound') {
                            return res.json({
                                "success": false,
                                "error": "Lisans dosyası bulunamadı, lisans dosyası oluşması için içeriğin daha önce indirilmiş olması gerekmektedir."
                            })
                        } else {
                            console.log('MOTION ARRAY LICENSE S3 HAVE...');
                            AwsS3.getSignedUrl('getObject', {
                                Bucket: BUCKET_NAME, Key: 'ma_l/' + slugID + '.pdf', Expires: 3600
                            }, (err, url) => {
                                console.log('MOTION ARRAY LICENSE S3 HAVE RETURNED')
                                return res.json({success: true, url: url})
                            });
                        }
                    });
                } else {
                    return res.json({
                        "success": false,
                        "error": "invalid url! Please insert correct content url!"
                    })
                }
            } else {
                return res.json({
                    "success": false,
                    "error": "invalid url! Please content url insert!"
                })
            }
            break;
        case 'envatoelements':
            if (url.indexOf('elements.envato.com/') === -1) {
                return res.json({
                    "success": false,
                    "error": "invalid url!"
                })
            } else {
                if ((url.match(/-([A-Z0-9]{6,})/)) !== null) {
                    try {
                        let slugID = url.match(/-([A-Z0-9]{6,})/)[1];
                        AwsS3.headObject({
                            Bucket: BUCKET_NAME, Key: 'ee/' + slugID + '.zip'
                        }, async function (err, metadata) {
                            if (err && err.code === 'NotFound') {
                                try {
                                    const envatoelements = await getItemEnvatoElements(url)
                                    return res.json(envatoelements)
                                } catch (e) {
                                    try {
                                        const envatoelements = await getItemEnvatoElements(url)
                                        return res.json(envatoelements)
                                    } catch (e) {
                                        try {
                                            const envatoelements = await getItemEnvatoElements(url)
                                            return res.json(envatoelements)
                                        } catch (e) {
                                            NotificationSMS(e.message);
                                            return res.json({
                                                "success": false,
                                                "error": "index C1-242!" + e.message
                                            })
                                        }
                                    }
                                }
                            } else {
                                console.log('ENVATO ELEMENTS S3 HAVE...');
                                AwsS3.getSignedUrl('getObject', {
                                    Bucket: BUCKET_NAME, Key: 'ee/' + slugID + '.zip', Expires: 3600
                                }, (err, url) => {
                                    console.log('ENVATO ELEMENTS S3 HAVE RETURNED')
                                    return res.json({success: true, url: url})
                                });
                            }
                        });
                    } catch (e) {
                        //NotificationSMS('URL: ' + url + ' \n ' + e.message)
                        return res.json({
                            "success": false,
                            "error": "index C1-242!" + e.message
                        })
                    }
                } else {
                    return res.json({
                        "success": false,
                        "error": "invalid url! Please content url insert!"
                    })
                }
            }
            break;
        case 'freepik':
            if ((url.match(/_(\d+)/)) !== null) {
                try {
                    let slugID = url.match(/_(\d+)/)[1];
                    let typeContentIsVideo = url.includes("/free-video/") || url.includes("/premium-video/") || url.includes("/video-gratis/") || url.includes("/video-premium/") || url.includes("/video-gratuito/") || url.includes("/video-gratuite/");
                    console.log('Video Tipi Seçilme Durumu : ', videoSelected)
                    console.log('İçerik Video Mu ? : ', typeContentIsVideo)
                    if (typeContentIsVideo && videoSelected != 'secildi') {
                        console.log('Video Tipi Seçilme Durumu div içi ', videoSelected)
                        console.log('video tipi seçilmedi ve içerik tipi video görünüyor.')

                        let gelendata;
                        try {
                            const puppeteer = require('puppeteer');
                            const browser = await puppeteer.launch({
                                headless: "new",
                                args: ['--window-size=1920,1080', '--disable-setuid-sandbox', '--no-sandbox'/*,'--proxy-server=server3.livaproxy.com:40416'*/],
                            }); // Puppeteer'ı başlat
                            const page = await browser.newPage();
                            await page.setViewport({
                                width: 1920, height: 1080,
                            });
                            /*const cookiesFR = await getTypeCookie('freepik');
                            const deserializedCookiesFR = JSON.parse(cookiesFR.cookie);
                            await page.setCookie(...deserializedCookiesFR)*/
                            await page.goto(url, {
                                waitUntil: 'domcontentloaded'
                            });

                            const html = await page.content(); // Sayfanın HTML içeriğini al

                            await browser.close(); // Tarayıcıyı kapat

                            console.log(url)
                            //console.log(datass.split('__NEXT_DATA__" type="application/json">')[1].split('</script>'))
                            let TypesObj = JSON.parse(html.split('__NEXT_DATA__" type="application/json">')[1].split('</script>')[0]).props.pageProps.options;

                            return res.json({
                                "success": false,
                                "error": "FREEPIK VIDEO DOWNLOAD SECTION IS CURRENTLY UNDER MAINTENANCE.",
                                'types': TypesObj
                            })

                        } catch (e) {
                            NotificationSMS('URL: ' + url + ' \n ' + e.message)
                            return res.json({
                                "success": false,
                                "error": 'ERROR ! CODE: axiGetType' + e.message
                            })
                        }
                    } else {
                        AwsS3.headObject({
                            Bucket: BUCKET_NAME, Key: 'fp/' + slugID + '.zip'
                        }, async function (err, metadata) {
                            if (err && err.code === 'NotFound') {
                                try {
                                    const freepik = await getItemFreepik(url, req.query.xurl)
                                    if(freepik.success){
                                        if(freepik.url.includes('cdnpk.net/videos/')){
                                            freepik.url= 'https://www.itemstok.org/stream-video?url='+encodeURIComponent(freepik.url)
                                        }
                                    }
                                    return res.json(freepik)
                                } catch (e) {
                                    console.log(e)
                                    NotificationSMS('URL: ' + url + ' \n ' + e.message)
                                    return res.json({
                                        "success": false,
                                        "error": "index C2-242!" + e.message
                                    })
                                }
                            } else {
                                console.log('FREEPIK S3 HAVE...');
                                AwsS3.getSignedUrl('getObject', {
                                    Bucket: BUCKET_NAME, Key: 'fp/' + slugID + '.zip', Expires: 3600
                                }, (err, url) => {
                                    console.log('FREEPIK S3 HAVE RETURNED')
                                    return res.json({success: true, url: url})
                                });
                            }
                        });
                    }
                } catch (e) {
                    NotificationSMS('URL: ' + url + ' \n ' + e.message)
                    return res.json({
                        "success": false,
                        "error": 'ERROR ! CODE: S3C2-AIDCXNSTRE' + e.message
                    })
                }
            } else {
                return res.json({
                    "success": false,
                    "error": "invalid url! Please content url insert!"
                })
            }
            break;
        case 'motionarray':
            if (url.indexOf('motionarray.com/') === -1) {
                return res.json({
                    "success": false,
                    "error": "invalid url!"
                })
            } else {
                try {
                    let slugID = (url.match(/-(\d+)/gm)[url.match(/-(\d+)/gm).length - 1]).replace('-', '');
                    AwsS3.headObject({
                        Bucket: BUCKET_NAME, Key: 'ma/' + slugID + '.zip'
                    }, async function (err, metadata) {
                        if (err && err.code === 'NotFound') {
                            try {
                                const motionarray = await getItemMotionArray(url)
                                return res.json(motionarray)
                            } catch (e) {
                                NotificationSMS('URL: ' + url + ' \n ' + e.message)
                                return res.json({
                                    "success": false,
                                    "error": "index MA C1-242!" + e.message
                                })
                            }
                        } else {
                            console.log('MOTION ARRAY S3 HAVE...');
                            AwsS3.getSignedUrl('getObject', {
                                Bucket: BUCKET_NAME, Key: 'ma/' + slugID + '.zip', Expires: 3600
                            }, (err, url) => {
                                console.log('MOTION ARRAY S3 HAVE RETURNED')
                                return res.json({success: true, url: url})
                            });
                        }
                    });
                } catch (e) {
                    let logID = new Date().getTime();
                    NotificationSMS('URL: ' + url + ' \n ' + e.message)
                    if (e.response.status == 401)
                        NotificationSMS('URL: ' + url + ' \n ' + e.message + '  Sistem Tarafından Yenileme Gerekli Lütfen Bekleyin.')
                    return res.json({
                        "success": false,
                        "error": "index C4-242!" + e.message
                    })
                }
            }
            break;
        case 'shutterstock':
            if (url.indexOf('shutterstock.com/') === -1) {
                return res.json({
                    "success": false,
                    "message": "invalid url! .1"
                })
            } else {
                try {
                    const ShutterStock = await getItemShutterStock(url)
                    return res.json(ShutterStock)
                } catch (e) {
                    console.log(e)
                    return res.json({
                        "success": false,
                        "message": "invalid url! .2"
                    })
                }
            }
            break;
        case 'flaticon':
            if (url.indexOf('flaticon.') === -1) {
                return res.json({
                    "success": false,
                    "error": "invalid url!"
                })
            } else {
                if ((url.match(/(\d+)/)) !== null) {
                    try {
                        const Flaticon = await getItemFlaticon(url, req.query.dwType)
                        return res.json(Flaticon)
                    } catch (e) {
                        NotificationSMS('URL: ' + url + ' \n ' + e.message)
                        return res.json({
                            "success": false,
                            "error": "index C88-242!" + e.message
                        })
                    }
                } else {
                    return res.json({
                        "success": false,
                        "error": "invalid url! Please content url insert!"
                    })
                }
            }
            break;
        case 'epidemicsound':
            if (url.indexOf('epidemicsound.') === -1) {
                return res.json({
                    "success": false,
                    "error": "invalid url!"
                })
            } else {
                if (url.includes('epidemicsound.com/track') || url.includes('epidemicsound.com/sound-effects')) {
                    try {

                        let dwType = req.query.dwType;
                        console.log('E.S. => MISSION ACCEPTED => ' + url + '  dw ' + dwType + ' !')
                        dwType = dwType.split('#')
                        if (dwType.length > 1) {
                            const EpidemicSound = await getItemEpidemicSound(url, dwType[1], dwType[0])
                            return res.json(EpidemicSound)
                        } else {
                            const EpidemicSound = await getItemEpidemicSound(url, dwType[0])
                            return res.json(EpidemicSound)
                        }
                    } catch (e) {
                        NotificationSMS('URL: ' + url + ' \n ' + e.message)
                        return res.json({
                            "success": false,
                            "error": "index C88-242!" + e.message
                        })
                    }
                } else {
                    return res.json({
                        "success": false,
                        "error": "invalid url! Please content url insert!"
                    })
                }
            }
            break;
        default:
            return res.json({
                "success": false,
                "message": "invalid parameters!"
            })
            break;
    }
})


app.listen(3450,async () => {
    await getFreepikDownChecker();
    console.log('yayındayız')
})


const secondsToWords = (seconds) => {
    const totalDays = Math.floor(seconds / (3600 * 24));
    const totalHours = Math.floor(seconds % (3600 * 24) / 3600);
    const totalMinutes = Math.floor(seconds % 3600 / 60);
    const totalSeconds = Math.floor(seconds % 60);

    const daysInWords = totalDays > 0 ? totalDays + (totalDays === 1 ? ' day, ' : ' days, ') : '';
    const hoursInWords = totalHours > 0 ? totalHours + (totalHours === 1 ? ' hour, ' : ' hours, ') : '';
    const minutesInWords = totalMinutes > 0 ? totalMinutes + (totalMinutes === 1 ? ' min, ' : ' min, ') : '';
    const secondsInWords = totalSeconds > 0 ? totalSeconds + (totalSeconds === 1 ? ' sec' : ' sec') : '';

    const finalResult = (daysInWords + hoursInWords + minutesInWords + secondsInWords).replace(/\, $/, '');

    if (finalResult === '') {
        return "less than a second";
    } else {
        return finalResult;
    }
};

const uptime = (uptimeTarget = 99.9, daysPerMonth = 30, daysPerQuarter = 90, daysPerYear = 365) => {
    const secondsPerDay = 60 * 60 * 24;
    const secondsPerWeek = 60 * 60 * 24 * 7;

    let secondsPerMonth = 60 * 60 * 24 * daysPerMonth;
    let secondsPerQuarter = 60 * 60 * 24 * daysPerQuarter;
    let secondsPerYear = 60 * 60 * 24 * daysPerYear;

    // dodging the floating point math
    const allowedDowntime = (100 * 100 - uptimeTarget * 100) / (100 * 100);

    return {
        secondsPerDay: secondsToWords(allowedDowntime * secondsPerDay),
        secondsPerWeek: secondsToWords(allowedDowntime * secondsPerWeek),
        secondsPerMonth: secondsToWords(allowedDowntime * secondsPerMonth),
        secondsPerQuarter: secondsToWords(allowedDowntime * secondsPerQuarter),
        secondsPerYear: secondsToWords(allowedDowntime * secondsPerYear)
    };
};

function formatBytes(bytes, decimals = 2) {
    if (!+bytes) return '0 Bytes'

    const k = 1024
    const dm = decimals < 0 ? 0 : decimals
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

    const i = Math.floor(Math.log(bytes) / Math.log(k))

    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
}

const getDirectories = (source) => {

    const files = [];

    function getFiles(dir) {

        fs.readdirSync(dir).map(file => {

            const absolutePath = path.join(dir, file);

            const stats = fs.statSync(absolutePath);

            if (fs.statSync(absolutePath).isDirectory()) {

                return getFiles(absolutePath);

            } else {
                const modified = {
                    name: file,
                    dir: dir,
                    created: stats.birthtime.toLocaleString('EN'),
                    modified: stats.mtime
                };
                return files.push(modified);
            }
        });
    }

    getFiles(source);
    return files;
}


