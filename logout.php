
<?php
include_once 'function/auth.php';

// Proses logout
$result = logout();

// Redirect ke halaman login dengan pesan
header("Location: login.php?logout=success");
exit();
?>
