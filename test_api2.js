const https = require('https');

function postData(url, data) {
    return new Promise((resolve, reject) => {
        const dataStr = JSON.stringify(data);
        const req = https.request(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Content-Length': Buffer.byteLength(dataStr)
            }
        }, (res) => {
            let body = '';
            res.on('data', chunk => body += chunk);
            res.on('end', () => resolve(JSON.parse(body)));
        });
        req.on('error', reject);
        req.write(dataStr);
        req.end();
    });
}

function getData(url, token) {
    return new Promise((resolve, reject) => {
        const req = https.request(url, {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token
            }
        }, (res) => {
            let body = '';
            res.on('data', chunk => body += chunk);
            res.on('end', () => resolve(JSON.parse(body)));
        });
        req.on('error', reject);
        req.end();
    });
}

async function run() {
    try {
        const loginRes = await postData('https://latticework.mx/api/login.php', {email: 'elchamandigital@gmail.com', password: 'Sieghei1'});
        if (loginRes.token) {
            const usersRes = await getData('https://latticework.mx/api/admin/list_users.php', loginRes.token);
            console.log(usersRes.users);
        }
    } catch (e) {
        console.log("Error:", e);
    }
}
run();
