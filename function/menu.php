
<?php
// Handle route from GET parameter
if (isset($_GET['route'])) {
    $route = $_GET['route'];
    switch ($route) {
        case 'admin':
            include 'pages/admin/tes.php';
            break;
        case 'about':
            include 'pages/about.php';
            break;
        case 'contact':
            include 'pages/contact.php';
            break;
    }
}
?>
