<?php
require_once __DIR__ . '/../config/config.php';

class SimpleSMTP {
    private $host;
    private $port;
    private $user;
    private $pass;
    private $socket;

    public function __construct() {
        $this->host = SMTP_HOST;
        $this->port = SMTP_PORT;
        $this->user = SMTP_USER;
        $this->pass = SMTP_PASS;
    }

    private function serverParse($socket, $expected_response) {
        $server_response = '';
        while (substr($server_response, 3, 1) != ' ') {
            if (!($server_response = fgets($socket, 256))) {
                return false;
            }
        }
        if (!(substr($server_response, 0, 3) == $expected_response)) {
            return false;
        }
        return true;
    }

    public function send($to, $subject, $message, $from_email = null, $from_name = null) {
        if ($from_email === null) $from_email = SMTP_FROM_EMAIL;
        if ($from_name === null) $from_name = SMTP_FROM_NAME;

        // Construct headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "From: {$from_name} <{$from_email}>\r\n";
        $headers .= "To: {$to}\r\n";
        $headers .= "Subject: {$subject}\r\n";
        
        $payload = $headers . "\r\n" . $message . "\r\n.\r\n";

        // Connect
        $this->socket = fsockopen($this->host, $this->port, $errno, $errstr, 15);
        if (!$this->socket) {
            error_log("SMTP Error: Could not connect to {$this->host}:{$this->port}");
            return false;
        }

        $this->serverParse($this->socket, "220");

        fwrite($this->socket, "EHLO " . $_SERVER['SERVER_NAME'] . "\r\n");
        $this->serverParse($this->socket, "250");

        // STARTTLS if port 587
        if ($this->port == 587) {
            fwrite($this->socket, "STARTTLS\r\n");
            $this->serverParse($this->socket, "220");
            stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            fwrite($this->socket, "EHLO " . $_SERVER['SERVER_NAME'] . "\r\n");
            $this->serverParse($this->socket, "250");
        }

        // Auth
        fwrite($this->socket, "AUTH LOGIN\r\n");
        $this->serverParse($this->socket, "334");

        fwrite($this->socket, base64_encode($this->user) . "\r\n");
        $this->serverParse($this->socket, "334");

        fwrite($this->socket, base64_encode($this->pass) . "\r\n");
        $this->serverParse($this->socket, "235");

        // Mail From
        fwrite($this->socket, "MAIL FROM: <{$from_email}>\r\n");
        $this->serverParse($this->socket, "250");

        // Rcpt To
        fwrite($this->socket, "RCPT TO: <{$to}>\r\n");
        $this->serverParse($this->socket, "250");

        // Data
        fwrite($this->socket, "DATA\r\n");
        $this->serverParse($this->socket, "354");

        // Send Message
        fwrite($this->socket, $payload);
        $this->serverParse($this->socket, "250");

        // Quit
        fwrite($this->socket, "QUIT\r\n");
        fclose($this->socket);

        return true;
    }
}
?>