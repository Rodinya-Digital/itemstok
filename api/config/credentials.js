/**
 * Merkezi Credentials Yönetimi
 * 
 * Tüm hassas bilgiler burada toplanmıştır.
 * Production'da bu değerler environment variable'lardan alınmalıdır.
 * 
 * Kullanım:
 * const { DB_CONFIG, S3_CONFIG, API_KEY } = require('./config/credentials');
 */

// Veritabanı Ayarları
const DB_CONFIG = {
    host: process.env.DB_HOST || '188.132.168.79',
    user: process.env.DB_USER || 'itemstok_org',
    password: process.env.DB_PASSWORD || 'WrNuGSDlK6W7rKgG',
    database: process.env.DB_NAME || 'itemstok_org',
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
    endpoint: process.env.S3_ENDPOINT || 'r8w1.fra.idrivee2-36.com',
    accessKeyId: process.env.S3_ACCESS_KEY || '7M6ATvoK22BBflnKg9K8',
    secretAccessKey: process.env.S3_SECRET_KEY || 'ffEJ2j5mbNbzdzaxbdqt2527226xm5Aj60SU4CX2',
    bucketName: process.env.S3_BUCKET || 'itemstok'
};

// API Güvenlik Anahtarı
const API_KEY = process.env.API_SECRET_KEY || 'sdasdas333';

// Envato Hesap Bilgileri
const ENVATO_CREDENTIALS = {
    email: process.env.ENVATO_EMAIL || 'rodinyatools@rodinyadijital.com',
    password: process.env.ENVATO_PASSWORD || 'Oguzhan99.'
};

// Telegram Bot Ayarları
const TELEGRAM_CONFIG = {
    token: process.env.TELEGRAM_BOT_TOKEN || '8097121235:AAHOlFfgxfhqG_tBMnuGcvRnR6xj6n2bbus',
    chatId: process.env.TELEGRAM_CHAT_ID || '-4748936019'
};

// 2Captcha API Key (reCAPTCHA çözmek için)
const CAPTCHA_CONFIG = {
    apiKey: process.env.CAPTCHA_API_KEY || 'f11f25a7e32dfb9ddf74eec3181a19f4',
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
