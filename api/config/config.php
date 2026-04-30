<?php
// config.php
// Archivo central de configuración para el MVP Fintech.

// Base URL del proyecto (usada para generación de enlaces y QR)
define('BASE_URL', 'https://latticework.mx');

// Configuración de la Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'latt1cew_fintech');
define('DB_USER', 'latt1cew_admin');
define('DB_PASS', 'Latt!ceW0rk.2026_MX#');

// Configuración de JWT
define('JWT_SECRET', 'ChamanD1g1tal_Fintech_88xYZ');

// Configuración de Correo SMTP
define('SMTP_HOST', 'smtp.chaman.digital');
define('SMTP_PORT', 587); // Usualmente 587 para TLS o 465 para SSL
define('SMTP_USER', 'promociones@chaman.digital');
define('SMTP_PASS', '1C#@man.Mx');
define('SMTP_FROM_EMAIL', 'promociones@chaman.digital');
define('SMTP_FROM_NAME', 'Fintech MVP');
?>