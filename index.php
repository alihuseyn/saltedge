<?php

require __DIR__ . "/vendor/autoload.php";

// Client access credentials
define('APP_ID', "AmKCmUJvvY-S04yl7miuqJ1FdF1sqJHLwtl1pvOKDfo");
define("SECRET", "rWErDccAZ1dSKlQD9W7YgIel5OZahue-SmZSNUcPvjE");

// Private key details
$scriptPath     = dirname(__FILE__);
$privateKeyPath = "file://{$scriptPath}/private.pem"; // Path to private key file
$privateKeyPass = null;                               // Optional, if the private key is password protected

// Initialize
try {
    $spectre = new \SaltEdge\Spectre(APP_ID, SECRET, $privateKeyPath, $privateKeyPass);
    $spectre->token()->connect(['customer_id' => 3079342 ])->redirect();
    $spectre->terminate();
} catch (Exception $e) {
    echo "<pre>";
    print_r($e->getMessage());
    echo "</pre>";
}