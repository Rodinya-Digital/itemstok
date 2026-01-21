const mysql = require('mysql2/promise');
const { DB_CONFIG } = require('../config/credentials');

// Uygulama başladığında bir kez havuzu oluşturun
const pool = mysql.createPool(DB_CONFIG);

// Artık her fonksiyonda bağlantı açıp kapatmak yerine havuzu kullanacağız.
// getFreepikAccountsCookies fonksiyonunu güncellenmiş hali:
const getFreepikAccountsCookies = async () => {
    // try-finally bloğuna gerek yok, havuz bağlantıları otomatik yönetir
    const connection = await pool.getConnection(); // Havuzdan bir bağlantı al
    try {
        const [accounts] = await connection.execute('SELECT * FROM `service_auths` WHERE `name` LIKE \'%freepik%\'');
        return accounts; // Promise otomatik olarak resolve olur
    } finally {
        connection.release(); // Bağlantıyı havuza geri bırak (connection.end() değil!)
    }
};

// Diğer fonksiyonları da aynı şekilde güncelleyin:

function deleteOldDatas(connection) { // Parametreyi conn yerine connection yaptım
    // connection.query'yi execute olarak değiştirdim, daha iyi performans ve güvenlik için
    connection.execute('DELETE FROM `gofiles` WHERE created <= NOW() - INTERVAL 9 DAY;')
        .then(() => {
           // console.log('_-_-_-_-_-_-_-_-_- DELETED OLD GOFILE DATAS !!!');
        })
        .catch(err => {
          //  console.error('Error deleting old gofile datas:', err);
        });
}


const getTypeCookie = async (type) => {
    const connection = await pool.getConnection();
    try {
        deleteOldDatas(connection); // Bağlantıyı havuza döndürmeden önce çağırın

        if (type === 'freepik') {
            const [rows] = await connection.execute(`
                SELECT *
                FROM service_auths
                WHERE name LIKE '%freepik%'
                  AND CAST(JSON_EXTRACT(detail_raw, '$.downloads') AS UNSIGNED) < CAST(JSON_EXTRACT(detail_raw, '$.limit_downloads') AS UNSIGNED)
                ORDER BY id ASC
                    LIMIT 1
            `);
            if (rows.length === 0) throw new Error('İndirilebilir Freepik hesabı bulunamadı.');
            return rows[0];
        } else if (type === 'envatoelements') {
            const [rows] = await connection.execute("SELECT * FROM `service_auths` WHERE `name` LIKE '%envatoelements%' ORDER BY RAND()");
            return rows[0];
        } else if (type === 'flaticon') {
            const [rows] = await connection.execute("SELECT * FROM `service_auths` WHERE `name` LIKE '%flaticon%' ORDER BY RAND()");
            return rows[0];
        } else {
            const [rows] = await connection.execute("SELECT * FROM `service_auths` WHERE `name` = ?", [type]);
            return rows[0];
        }
    } finally {
        connection.release(); // Bağlantıyı havuza geri bırak
    }
};

const updateTypeCookie = async (name, cookie, detail_raw = false, walletId = false) => {
    const datetimeNow = new Date(Date.now() + (1000 * 60 * 60 * 3)).toJSON().slice(0, 19).replace('T', ' ');
    const connection = await pool.getConnection();
    try {
        deleteOldDatas(connection);
        if (detail_raw) {
            await connection.execute("UPDATE `service_auths` SET `cookie`= ?,`detail_raw`= ?,`updated_at`= ? WHERE `name` = ?", [cookie, detail_raw, datetimeNow, name]);
        } else {
            await connection.execute("UPDATE `service_auths` SET `cookie`= ?,`updated_at`= ? WHERE `name` = ?", [cookie, datetimeNow, name]);
        }
        // updateTypeCookie'nin dönüş değeri yoktu, ekledim
        return true;
    } finally {
        connection.release();
    }
};

const saveDownloadedLog = async (user_id, type, name, value) => {
    const datetimeNow = new Date(Date.now() + (1000 * 60 * 60 * 3)).toJSON().slice(0, 19).replace('T', ' ');
    const connection = await pool.getConnection();
    try {
        deleteOldDatas(connection);
        const [rows] = await connection.execute('insert into logs (user_id, type, name, value, created_at,updated_at) values (?,?,?,?,?,?)',
            [user_id, type, name, value, datetimeNow, datetimeNow]);
        return rows;
    } finally {
        connection.release();
    }
};

const getFreepikLD = async () => {
    const connection = await pool.getConnection();
    try {
        deleteOldDatas(connection);
        const [rows] = await connection.execute("SELECT * FROM `freepik_ld` WHERE `updated_at` IS NULL");
        return rows;
    } finally {
        connection.release();
    }
};

const updateFreepikLD = async (slug_id) => {
    const datetimeNow = new Date(Date.now() + (1000 * 60 * 60 * 3)).toJSON().slice(0, 19).replace('T', ' ');
    const connection = await pool.getConnection();
    try {
        deleteOldDatas(connection);
        const [rows] = await connection.execute("UPDATE `freepik_ld` SET `updated_at`= ? WHERE `slug_id` = ?", [datetimeNow, slug_id]);
        return rows[0]; // Bu kısım rows[0] döndürüyor, genellikle affectedRows daha uygun olabilir.
    } finally {
        connection.release();
    }
};

const saveFreepikLD = async (slug_id, url, type, cookie) => {
    const datetimeNow = new Date(Date.now() + (1000 * 60 * 60 * 3)).toJSON().slice(0, 19).replace('T', ' ');
    const connection = await pool.getConnection();
    try {
        deleteOldDatas(connection);
        const [rows] = await connection.execute("SELECT * FROM `freepik_ld` WHERE `slug_id` = ?", [slug_id]);
        if (rows.length < 1) {
            console.log('PREVIOUSLY UNRECORDED LICENSE ASSIGNMENT REGISTERED.');
            const [insertResult] = await connection.execute('insert into freepik_ld (slug_id, url, type, cookie) values (?,?,?,?)',
                [slug_id, url, type, cookie]);
            return 'PREVIOUSLY UNRECORDED LICENSE ASSIGNMENT REGISTERED.'; // Veya insertResult
        } else {
            console.log('PREVIOUSLY REGISTERED LICENSE ASSIGNMENT.');
            return 'PREVIOUSLY REGISTERED LICENSE ASSIGNMENT.';
        }
    } finally {
        connection.release();
    }
};

const saveDownloadedGoFiles = async (service, slug_id, code) => {
    const datetimeNow = new Date(Date.now() + (1000 * 60 * 60 * 3)).toJSON().slice(0, 19).replace('T', ' ');
    const connection = await pool.getConnection();
    try {
        deleteOldDatas(connection);
        const [rows] = await connection.execute('insert into gofiles (service, slug_id, code, created) values (?,?,?,?)',
            [service, slug_id, code, datetimeNow]);
        return rows;
    } finally {
        connection.release();
    }
};

const getGoFilesFile = async (service, slug_id) => {
    const connection = await pool.getConnection();
    try {
        deleteOldDatas(connection);
        const [rows] = await connection.execute("SELECT * FROM `gofiles` WHERE `service` = ? AND `slug_id` = ?", [service, slug_id]);
        return rows[0];
    } finally {
        connection.release();
    }
};


module.exports = {
    getTypeCookie,
    saveDownloadedLog,
    updateTypeCookie,
    saveDownloadedGoFiles,
    getGoFilesFile,
    saveFreepikLD,
    getFreepikLD,
    updateFreepikLD,
    getFreepikAccountsCookies
};