const {
    getTypeCookie,
    updateTypeCookie,
    saveDownloadedLog,
    saveDownloadedGoFiles
} = require('../../controllers/MysqlController');
const axios = require('axios');
const path = require('path');
const fs = require('fs');
const archiver = require('archiver');
const {DownloaderHelper} = require('node-downloader-helper');
const AWS = require('aws-sdk');




const spacesEndpoint = new AWS.Endpoint('r8w1.fra.idrivee2-36.com');
const ID = '7M6ATvoK22BBflnKg9K8';
const SECRET = 'ffEJ2j5mbNbzdzaxbdqt2527226xm5Aj60SU4CX2';
const BUCKET_NAME = 'itemstok';
const AwsS3 = new AWS.S3({
    endpoint: spacesEndpoint,
    accessKeyId: '7M6ATvoK22BBflnKg9K8',
    secretAccessKey: 'ffEJ2j5mbNbzdzaxbdqt2527226xm5Aj60SU4CX2'
});
const servicePrefix = 'ss/';
const getItemShutterStock = async (requestedUrl) => {
    return new Promise(async (resolve, reject) => {
        try {
            console.log('SHUTTERSTOCK TALEP ALINDI URL: ' + requestedUrl)
            let slugID = requestedUrl.match(/-([A-Z0-9]{6,})/)[1];
            AwsS3.headObject({
                Bucket: BUCKET_NAME, Key: servicePrefix + slugID + '.zip'
            }, async function (err, metadata) {
                if (err && err.code === 'NotFound') {


                    let config = {
                        method: 'get',
                        maxBodyLength: Infinity,
                        url: 'http://www.itemstok.org/api/shutterstock_custom?accesskey=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9&url=' + requestedUrl,
                        headers: {}
                    };

                    axios.request(config)
                        .then((response) => {
                            let resultData = response.data;
                            console.log('SHUTTERSTOCK REQUESTED',resultData)
                            if (resultData.success) {
                                const dl = new DownloaderHelper(resultData.download, __dirname + '/files');
                                let downloadedFileName = '';
                                dl.on('end', async () => {
                                    console.log('SHUTTERSTOCK DOWNLOAD FINISHED !')
                                    const output = fs.createWriteStream(__dirname + '/' + slugID + '.zip');
                                    const archive = archiver('zip', {
                                        zlib: {level: 0} // Sets the compression level.
                                    });
                                    console.log('SHUTTERSTOCK ZIPPING START')
                                    output.on('close',async function () {
                                        console.log('SHUTTERSTOCK ZIP CLOSED')
                                        if (await fs.existsSync(__dirname + '/files/' + downloadedFileName))
                                            fs.unlinkSync(__dirname + '/files/' + downloadedFileName);
                                        console.log('SHUTTERSTOCK S3 UPLOAD START')
                                        await AwsS3.upload({
                                            Bucket: BUCKET_NAME,
                                            Key: servicePrefix + slugID + '.zip',
                                            Body: fs.createReadStream(__dirname + '/' + slugID + '.zip')
                                        }).promise().then(async e => {
                                            console.log('SHUTTERSTOCK S3 UPLOAD FINISHED')
                                            if (await fs.existsSync(__dirname + '/' + slugID + '.zip'))
                                                fs.unlinkSync(__dirname + '/' + slugID + '.zip');
                                            console.log('SHUTTERSTOCK TRASH FILES DELETED')
                                            AwsS3.getSignedUrl('getObject', {
                                                Bucket: BUCKET_NAME, Key: servicePrefix + slugID + '.zip', Expires: 3600
                                            }, (err, url) => {
                                                console.log('SHUTTERSTOCK RETURNED')
                                                return resolve({success: true, download: url})
                                            });
                                        })
                                    });

                                    archive.on('error', function (err) {
                                        console.log('SHUTTERSTOCK ZIP ERROR ',err)
                                        return reject(err)
                                    });
                                    archive.pipe(output);
                                    archive
                                        .append(fs.createReadStream(__dirname + '/files/' + downloadedFileName), { name: downloadedFileName })
                                        .finalize();
                                });
                                dl.on('download', async (r) => {
                                    console.log('SHUTTERSTOCK DOWNLOAD ACCEPT INFO',r)
                                    downloadedFileName = r.fileName
                                    if (r.totalSize >= 20000000000000) { //Max File IF 2G
                                        dl.stop()
                                    }
                                })
                                dl.on('error', (err) => console.log('## SHUTTERSTOCK FILE DOWNLOAD FAILED CODE: DL.ONL5466 ##', err));
                                console.log('SHUTTERSTOCK DOWNLADER START')
                                dl.start().catch(err => console.error(err));
                            } else {
                                console.log('SHUTTERSTOCK SUCCES-FALSE ! RETURNED')
                                return resolve(resultData)
                            }
                        })
                        .catch((error) => {
                            console.log('SHUTTERSTOCK IN AXIOS',error)
                            return reject(err)
                        });
                } else {
                    console.log('SHUTTERSTOCK S3 HAVE...');
                    AwsS3.getSignedUrl('getObject', {
                        Bucket: BUCKET_NAME, Key: servicePrefix + slugID + '.zip', Expires: 3600
                    }, (err, url) => {
                        console.log('SHUTTERSTOCK S3 HAVE RETURNED')
                        return resolve({success: true, download: url})
                    });
                }
            });
        } catch (err) {
            console.log('SHUTTERSTOCK IN CACTCH')
            return reject(err)
        }
    })
}

module.exports = getItemShutterStock
