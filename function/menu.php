<?php

function routeRequest($uri) {
    $path = parse_url($uri, PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));
    $route = $segments[0] ?? 'home'; 

    switch ($route) {
        case 'admin':
            // Handle home route
            include 'pages/admin/tes.php';
            break;
        case 'about':
            // Handle about route
            include 'pages/about.php';
            break;
        case 'contact':
            // Handle contact route
            include 'pages/contact.php';
            break;
        default:
            // Handle 404 - route not found
            include 'pages/404.php';
            break;
    }
}