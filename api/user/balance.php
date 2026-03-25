<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../utils/auth.php';

// Validar JWT genérico (cualquier usuario logueado)
$user = authenticate();
$userId = intval($user['id']);

if (isset($_GET['userId']) && !empty($_GET['userId'])) {
    $dbRole = new Database();
    $conn = $dbRole->getConnection();
    $stmtRole = $conn->prepare("SELECT role FROM users WHERE id = :uid");
    $uidRole = $user['id'];
    $stmtRole->bindParam(':uid', $uidRole, PDO::PARAM_INT);
    $stmtRole->execute();
    $roleRow = $stmtRole->fetch(PDO::FETCH_ASSOC);
    
    if ($roleRow && in_array($roleRow['role'], ['superadmin', 'subadmin'])) {
        $userId = intval($_GET['userId']); // Suplantar
    }
}

$database = new Database();
$db = $database->getConnection();

try {
    // 1. Obtener la información del usuario (riskProfile, annualReturnRate, nextInvestmentDate)
    $queryUser = "SELECT riskProfile, annualReturnRate, nextInvestmentDate FROM users WHERE id = :userId LIMIT 1";
    $stmtUser = $db->prepare($queryUser);
    $stmtUser->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmtUser->execute();
    
    if ($stmtUser->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Usuario no encontrado"]);
        exit;
    }
    
    $rowUser = $stmtUser->fetch(PDO::FETCH_ASSOC);
    $riskProfile = $rowUser['riskProfile'] ? $rowUser['riskProfile'] : "Moderate";
    $annualReturnRate = $rowUser['annualReturnRate'] !== null ? floatval($rowUser['annualReturnRate']) : 0.00;
    $nextInvestmentDate = $rowUser['nextInvestmentDate'];

    // 2. Calcular los balances reales desde la tabla transactions
    $queryBalance = "
        SELECT 
            COALESCE(SUM(CASE WHEN type = 'deposit' AND status = 'completed' THEN amount ELSE 0 END), 0) AS netDeposits,
            COALESCE(SUM(CASE WHEN type = 'withdrawal' AND status = 'completed' THEN amount ELSE 0 END), 0) AS netWithdrawals
        FROM transactions 
        WHERE userId = :userId
    ";
    
    $stmtBalance = $db->prepare($queryBalance);
    $stmtBalance->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmtBalance->execute();
    
    $rowBalance = $stmtBalance->fetch(PDO::FETCH_ASSOC);
    $netDeposits = floatval($rowBalance['netDeposits']);
    $netWithdrawals = floatval($rowBalance['netWithdrawals']);
    
    $totalBalance = $netDeposits - $netWithdrawals;

    // 3. Simular el rendimiento calculado (Phase 4 request)
    // Rendimiento anual = totalBalance * (tasa / 100)
    $annualReturn = $totalBalance * ($annualReturnRate / 100);

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "balance" => [
            "netDeposits" => $netDeposits,
            "totalBalance" => $totalBalance,
            "annualReturnRate" => $annualReturnRate,
            "annualReturn" => $annualReturn,
            "riskProfile" => $riskProfile,
            "nextInvestmentDate" => $nextInvestmentDate
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error al obtener el balance: " . $e->getMessage()
    ]);
}
?>