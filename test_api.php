<?php
$data = json_encode(['email' => 'elchamandigital@gmail.com', 'password' => 'Sieghei1']);
$ch = curl_init('https://latticework.mx/api/auth/login.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$res = curl_exec($ch);
echo "Login: $res\n";
$json = json_decode($res, true);
if (isset($json['token'])) {
    $token = $json['token'];
    $ch2 = curl_init('https://latticework.mx/api/admin/list_users.php');
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, ["Authorization: Bearer $token"]);
    $res2 = curl_exec($ch2);
    echo "Users: $res2\n";
    
    // Pick the non-admin user
    $users = json_decode($res2, true);
    if(isset($users['users'])){
        $client = null;
        foreach($users['users'] as $u){
            if($u['role'] === 'user'){
                $client = $u;
                break;
            }
        }
        if($client){
            $uid = $client['id'];
            $ch3 = curl_init("https://latticework.mx/api/user/balance.php?userId=$uid");
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch3, CURLOPT_HTTPHEADER, ["Authorization: Bearer $token"]);
            $res3 = curl_exec($ch3);
            echo "Balance (uid=$uid): $res3\n";
        }
    }
}
