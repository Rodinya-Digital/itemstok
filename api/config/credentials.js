/**
 * Merkezi Credentials Yönetimi
 * 
 * Tüm hassas bilgiler .env dosyasından okunur.
 * Dosya: /app/api/.env
 */

// .env dosyasını yükle
require('dotenv').config({ path: __dirname + '/../.env' });

// Veritabanı Ayarları
const DB_CONFIG = {
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME,
    charset: 'utf8mb4',
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0,
    idleTimeout: 60000,
    enableKeepAlive: true,
    keepAliveInitialDelay: 0
};

// AWS S3 Ayarları (iDrive e2)
const S3_CONFIG = {
    endpoint: process.env.S3_ENDPOINT,
    accessKeyId: process.env.S3_ACCESS_KEY,
    secretAccessKey: process.env.S3_SECRET_KEY,
    bucketName: process.env.S3_BUCKET
};

// API Güvenlik Anahtarı
const API_KEY = process.env.API_SECRET_KEY;

// Envato Hesap Bilgileri
const ENVATO_CREDENTIALS = {
    email: process.env.ENVATO_EMAIL,
    password: process.env.ENVATO_PASSWORD
};

// Telegram Bot Ayarları
const TELEGRAM_CONFIG = {
    token: process.env.TELEGRAM_BOT_TOKEN,
    chatId: process.env.TELEGRAM_CHAT_ID
};

// 2Captcha API Key (reCAPTCHA çözmek için)
const CAPTCHA_CONFIG = {
    apiKey: process.env.CAPTCHA_API_KEY,
    // Envato'nun bilinen reCAPTCHA site key'i
    envatoSiteKey: '6LcjX04UAAAAANHJ3jT8TPbv1BlGmymOxfFwj-wt'
};

// Service Prefix'leri (S3 klasör yapısı)
const SERVICE_PREFIXES = {
    envatoElements: 'ee/',
    envatoElementsLicense: 'ee_l/',
    freepik: 'fp/',
    freepikLicense: 'fp_l/',
    motionArray: 'ma/',
    motionArrayLicense: 'ma_l/',
    shutterstock: 'ss/',
    flaticon: 'fi/'
};

// Timeout Ayarları (ms)
const TIMEOUTS = {
    navigation: 90000,
    wait: 15000,
    login: 60000,
    download: 120000
};

// API key doğrulama fonksiyonu
function validateApiKey(key) {
    return key === API_KEY;
}

module.exports = {
    DB_CONFIG,
    S3_CONFIG,
    API_KEY,
    ENVATO_CREDENTIALS,
    TELEGRAM_CONFIG,
    CAPTCHA_CONFIG,
    SERVICE_PREFIXES,
    TIMEOUTS,
    validateApiKey
};
