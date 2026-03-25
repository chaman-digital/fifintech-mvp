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

require_once 'config/db.php';
require_once 'utils/auth.php';

// Authenticate user
$user = authenticate();

// Users can only view their own balance, admins can view any by providing a userId parameter
$userId = isset($_GET['userId']) ? intval($_GET['userId']) : $user['id'];

// If trying to access another user's balance, must be admin
if ($userId != $user['id'] && $user['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["message" => "Forbidden. Cannot view other user's balance."]);
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Fetch dynamic data from user profile (like annual return rate)
$profileQuery = "SELECT data FROM user_profiles WHERE userId = :userId LIMIT 1";
$profileStmt = $db->prepare($profileQuery);
$profileStmt->bindParam(":userId", $userId, PDO::PARAM_INT);
$profileStmt->execute();

if ($profileStmt->rowCount() == 0) {
    http_response_code(404);
    echo json_encode(["message" => "User profile not found."]);
    exit;
}

$profileRow = $profileStmt->fetch(PDO::FETCH_ASSOC);
$profileData = json_decode($profileRow['data'], true);

$annualReturnRate = isset($profileData['annualReturnRate']) ? floatval($profileData['annualReturnRate']) : 0.0;
$riskProfile = isset($profileData['riskProfile']) ? htmlspecialchars($profileData['riskProfile'], ENT_QUOTES, 'UTF-8') : 'Conservative';

// Calculate total deposits dynamically
$depositsQuery = "SELECT COALESCE(SUM(amount), 0) AS totalDeposits FROM transactions WHERE userId = :userId AND type = 'deposit' AND status = 'completed'";
$depositsStmt = $db->prepare($depositsQuery);
$depositsStmt->bindParam(":userId", $userId, PDO::PARAM_INT);
$depositsStmt->execute();
$depositsRow = $depositsStmt->fetch(PDO::FETCH_ASSOC);
$totalDeposits = floatval($depositsRow['totalDeposits']);

// Calculate total withdrawals dynamically
$withdrawalsQuery = "SELECT COALESCE(SUM(amount), 0) AS totalWithdrawals FROM transactions WHERE userId = :userId AND type = 'withdrawal' AND status = 'completed'";
$withdrawalsStmt = $db->prepare($withdrawalsQuery);
$withdrawalsStmt->bindParam(":userId", $userId, PDO::PARAM_INT);
$withdrawalsStmt->execute();
$withdrawalsRow = $withdrawalsStmt->fetch(PDO::FETCH_ASSOC);
$totalWithdrawals = floatval($withdrawalsRow['totalWithdrawals']);

// The Strict Formula Calculation
$netDeposits = $totalDeposits - $totalWithdrawals;

// We assume annualReturn is a projected simple return calculated based on current net deposits.
$annualReturn = $netDeposits * ($annualReturnRate / 100);

$totalBalance = $netDeposits + $annualReturn;

$transactionsSummary = [
    "totalDeposits" => $totalDeposits,
    "totalWithdrawals" => $totalWithdrawals,
    "netDeposits" => $netDeposits,
    "annualReturnRate" => $annualReturnRate,
    "annualReturn" => $annualReturn,
    "totalBalance" => $totalBalance,
    "riskProfile" => $riskProfile
];

http_response_code(200);
echo json_encode([
    "message" => "Balance retrieved successfully.",
    "userId" => $userId,
    "balance" => $transactionsSummary
]);
?>