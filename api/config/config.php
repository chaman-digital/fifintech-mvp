<?php
// config.php
// Archivo central de configuración para el MVP Fintech.

// Base URL del proyecto (usada para generación de enlaces y QR)
define('BASE_URL', 'https://chaman.digital/fifintech');

// Configuración de la Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'chamand3_fintech');
define('DB_USER', 'chamand3_muninn');
define('DB_PASS', 'L@n37FliX.mX');

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