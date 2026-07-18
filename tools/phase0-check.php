<?php
/**
 * AmarMart Phase 0 environment checker.
 * Run: php tools/phase0-check.php
 */

declare(strict_types=1);

echo "=== AmarMart Phase 0 Environment Check ===" . PHP_EOL;
echo "PHP: " . PHP_VERSION . PHP_EOL;

$required = [
    'openssl', 'pdo', 'mbstring', 'tokenizer', 'xml',
    'ctype', 'json', 'fileinfo', 'curl', 'zip', 'oci8',
];

$failed = false;
foreach ($required as $ext) {
    $ok = extension_loaded($ext);
    echo str_pad($ext, 12) . ($ok ? 'OK' : 'MISSING') . PHP_EOL;
    if (!$ok) {
        $failed = true;
    }
}

$pdoOci = in_array('oci', PDO::getAvailableDrivers(), true);
echo str_pad('pdo_oci', 12) . ($pdoOci ? 'OK' : 'MISSING') . PHP_EOL;
if (!$pdoOci) {
    $failed = true;
}

$user = getenv('AMARMART_DB_USER') ?: 'amarmart';
$pass = getenv('AMARMART_DB_PASS') ?: 'AmarMart123';
$tns  = getenv('AMARMART_DB_TNS') ?: 'localhost:1521/XE';

echo PHP_EOL . "Testing Oracle connection ($user@$tns)..." . PHP_EOL;

$conn = @oci_connect($user, $pass, $tns);
if (!$conn) {
    $e = oci_error();
    echo 'OCI8 connection FAILED: ' . ($e['message'] ?? 'unknown') . PHP_EOL;
    $failed = true;
} else {
    $stid = oci_parse($conn, 'SELECT user AS u FROM dual');
    oci_execute($stid);
    $row = oci_fetch_assoc($stid);
    echo 'OCI8 connection OK as ' . $row['U'] . PHP_EOL;
    oci_free_statement($stid);
    oci_close($conn);
}

try {
    $pdo = new PDO('oci:dbname=//' . $tns, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'PDO_OCI connection OK as ' . $pdo->query('SELECT user FROM dual')->fetchColumn() . PHP_EOL;
} catch (Throwable $ex) {
    echo 'PDO_OCI connection FAILED: ' . $ex->getMessage() . PHP_EOL;
    $failed = true;
}

echo PHP_EOL . ($failed ? 'RESULT: FAIL' : 'RESULT: PASS — Phase 0 environment is ready') . PHP_EOL;
exit($failed ? 1 : 0);
