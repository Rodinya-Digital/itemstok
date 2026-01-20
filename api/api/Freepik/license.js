const {
    getFreepikLD,
    updateFreepikLD
} = require('../../controllers/MysqlController');
const FreepikDownloader = require('./FreepikDownloader'); // İlk attığın dosyayı import et
const fs = require("fs");
const AWS = require('aws-sdk');

// AWS S3 Configuration
const spacesEndpoint = new AWS.Endpoint('r8w1.fra.idrivee2-36.com');
const ID = '7M6ATvoK22BBflnKg9K8';
const SECRET = 'ffEJ2j5mbNbzdzaxbdqt2527226xm5Aj60SU4CX2';
const BUCKET_NAME = 'itemstok';
const AwsS3 = new AWS.S3({
    endpoint: spacesEndpoint,
    accessKeyId: ID,
    secretAccessKey: SECRET
});
const servicePrefix = 'fp_l/';

/**
 * Freepik License Engine
 * FreepikDownloader sınıfını kullanarak lisans dosyalarını indirir ve S3'e yükler
 */
class FreepikLicenseEngine {
    constructor(options = {}) {
        this.concurrency = options.concurrency || 3; // Aynı anda kaç dosya işlenecek
        this.tempDir = options.tempDir || (__dirname + '/tempFiles');
        this.retryAttempts = options.retryAttempts || 3;

        // Temp dizinini oluştur
        if (!fs.existsSync(this.tempDir)) {
            fs.mkdirSync(this.tempDir, { recursive: true });
        }
    }

    /**
     * Tek bir lisans dosyasını işler
     * @param {Object} item - Veritabanından gelen öğe
     * @returns {Promise<boolean>} İşlem başarılı mı
     */
    async processLicenseItem(item) {
        const downloader = new FreepikDownloader({
            headless: true,
            viewport: { width: 1366, height: 768 }
        });

        try {
            console.log(`## FREEPIK LICENSE PROCESS START ## ${item.slug_id}`);

            // Downloader'ı başlat
            await downloader.initialize();

            // Lisans PDF URL'ini oluştur
            const licenseUrl = `https://www.freepik.com/profile/license/pdf/${item.slug_id}`;
            const fileName = `${item.slug_id}.pdf`;
            const filePath = `${this.tempDir}/${fileName}`;

            // Cookie string'ini al
            const cookieString = await downloader.getCookieString();

            // PDF'i indir
            const response = await downloader.context.request.get(licenseUrl, {
                headers: {
                    'accept': '*/*',
                    'accept-language': 'tr,en;q=0.9,ru;q=0.8,de;q=0.7,es;q=0.6',
                    'cookie': cookieString,
                    'priority': 'u=1, i',
                    'referer': 'https://www.freepik.com/premium-vector/realistic-optical-illusion-background_11797146.htm',
                    'sec-ch-ua': '"Google Chrome";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
                    'sec-ch-ua-mobile': '?0',
                    'sec-ch-ua-platform': '"Windows"',
                    'sec-fetch-dest': 'empty',
                    'sec-fetch-mode': 'cors',
                    'sec-fetch-site': 'same-origin',
                    'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36'
                }
            });

            // Yanıt kontrolü
            if (!response.ok()) {
                throw new Error(`HTTP ${response.status()}: ${response.statusText()}`);
            }

            // Dosya boyutu kontrolü
            const buffer = await response.body();
            if (buffer.length < 1000) { // Çok küçük dosyalar muhtemelen hata
                console.log(`## FREEPIK FILE NOT READY SKIP PROCESS ## ${item.slug_id}`);
                return false;
            }

            // Dosyayı kaydet
            fs.writeFileSync(filePath, buffer);
            console.log(`## FREEPIK FILE DOWNLOADED ## ${item.slug_id} (${buffer.length} bytes)`);

            // S3'e yükle
            await this.uploadToS3(filePath, fileName);

            // Veritabanını güncelle
            await updateFreepikLD(item.slug_id);

            // Temp dosyayı sil
            this.cleanupTempFile(filePath);

            console.log(`## FREEPIK LICENSE PROCESS FINISH ## ${item.slug_id}`);
            return true;

        } catch (error) {
            console.error(`## FREEPIK LICENSE ERROR ## ${item.slug_id}:`, error.message);

            // Temp dosyayı temizle
            const filePath = `${this.tempDir}/${item.slug_id}.pdf`;
            this.cleanupTempFile(filePath);

            return false;
        } finally {
            // Downloader'ı kapat
            await downloader.close();
        }
    }

    /**
     * Dosyayı S3'e yükler
     * @param {string} filePath - Local dosya yolu
     * @param {string} fileName - S3'teki dosya adı
     */
    async uploadToS3(filePath, fileName) {
        try {
            await AwsS3.upload({
                Bucket: BUCKET_NAME,
                Key: servicePrefix + fileName,
                Body: fs.createReadStream(filePath),
                ContentType: 'application/pdf'
            }).promise();

            console.log(`## FREEPIK LICENSE S3 UPLOAD FINISHED ## ${fileName}`);
        } catch (error) {
            throw new Error(`S3 upload failed: ${error.message}`);
        }
    }

    /**
     * Temp dosyayı temizler
     * @param {string} filePath - Silinecek dosya yolu
     */
    cleanupTempFile(filePath) {
        try {
            if (fs.existsSync(filePath)) {
                fs.unlinkSync(filePath);
                console.log(`## TEMP FILE DELETED ## ${filePath}`);
            }
        } catch (error) {
            console.warn(`Temp file cleanup failed: ${error.message}`);
        }
    }

    /**
     * Batch işleme - birden fazla öğeyi paralel işler
     * @param {Array} items - İşlenecek öğeler
     * @returns {Promise<Object>} İşlem sonuçları
     */
    async processBatch(items) {
        const results = {
            total: items.length,
            success: 0,
            failed: 0,
            errors: []
        };

        // Concurrency ile paralel işleme
        const chunks = [];
        for (let i = 0; i < items.length; i += this.concurrency) {
            chunks.push(items.slice(i, i + this.concurrency));
        }

        for (const chunk of chunks) {
            const promises = chunk.map(async (item) => {
                try {
                    const success = await this.processLicenseItem(item);
                    if (success) {
                        results.success++;
                    } else {
                        results.failed++;
                    }
                } catch (error) {
                    results.failed++;
                    results.errors.push({
                        slug_id: item.slug_id,
                        error: error.message
                    });
                }
            });

            await Promise.all(promises);
        }

        return results;
    }
}

/**
 * Ana engine fonksiyonu - eski interface'i korur
 */
const LC_Freepık_Engine = async (options = {}) => {
    try {
        console.log('## FREEPIK LICENSE ENGINE START ##');

        // Veritabanından verileri al
        const datas = await getFreepikLD();

        if (!datas || datas.length === 0) {
            console.log('## NO FREEPIK LICENSE DATA FOUND ##');
            return { success: true, message: 'No data to process' };
        }

        // Engine'i başlat ve işle
        const engine = new FreepikLicenseEngine(options);
        const results = await engine.processBatch(datas);

        console.log('## FREEPIK LICENSE ENGINE FINISH ##');
        console.log(`Processed: ${results.total}, Success: ${results.success}, Failed: ${results.failed}`);

        if (results.errors.length > 0) {
            console.log('Errors:', results.errors);
        }

        return results;

    } catch (error) {
        console.error('## FREEPIK LICENSE ENGINE ERROR ##', error);
        throw error;
    }
};

module.exports = {
    LC_Freepık_Engine,
    FreepikLicenseEngine
};