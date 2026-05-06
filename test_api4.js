const https = require('https');

function postData(url, data, token) {
    return new Promise((resolve, reject) => {
        const dataStr = JSON.stringify(data);
        const req = https.request(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Content-Length': Buffer.byteLength(dataStr),
                'Authorization': 'Bearer ' + token
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

async function run() {
    try {
        const loginRes = await postData('https://latticework.mx/api/login.php', {email: 'elchamandigital@gmail.com', password: 'Sieghei1'}, null);
        const token = loginRes.token;
        
        // Add a user!
        const res = await postData('https://latticework.mx/api/admin/create_user.php', {
            firstName: 'TestUser',
            lastName: 'Manual',
            email: 'testmanual@latticework.mx',
            phone: '5555555555',
            password: 'Password1!',
            annualReturnRate: 12,
            riskProfile: 'Moderado',
            investmentPeriod: 'Mensual'
        }, token);
        console.log("Create user:", res);
        
    } catch (e) {
        console.log("Error:", e);
    }
}
run();
