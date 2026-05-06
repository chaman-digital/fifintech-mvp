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
        console.log("Logging in...");
        const loginRes = await postData('https://latticework.mx/api/login.php', {email: 'elchamandigital@gmail.com', password: 'Sieghei1'});
        console.log("Login Status:", loginRes.status);
        
        if (loginRes.token) {
            console.log("Fetching users...");
            const usersRes = await getData('https://latticework.mx/api/admin/list_users.php', loginRes.token);
            console.log("Users total:", usersRes.users ? usersRes.users.length : 0);
            
            let client = usersRes.users.find(u => u.role === 'user');
            if (client) {
                console.log("Fetching balance for client:", client.id);
                const balanceRes = await getData('https://latticework.mx/api/user/balance.php?userId=' + client.id, loginRes.token);
                console.log("Balance status:", balanceRes.status);
                
                console.log("Fetching transactions for client:", client.id);
                const transRes = await getData('https://latticework.mx/api/user/transactions.php?userId=' + client.id, loginRes.token);
                console.log("Transactions status:", transRes.status);
                console.log("Transactions count:", transRes.transactions ? transRes.transactions.length : 0);
            }
        }
    } catch (e) {
        console.log("Error:", e);
    }
}
run();
