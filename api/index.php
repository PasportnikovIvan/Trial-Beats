<?php

$request = str_replace("/~paspoiva/Semestralni-prace/main", "", strtok($_SERVER["REQUEST_URI"], '?'));

switch ($request) {
    case '/' :
        require __DIR__ . '/views/index.php';
        break;
    case '' :
        require __DIR__ . '/views/index.php';
        break;
    case '/album' :
        require __DIR__ . '/views/album.php';
        break;
    case '/register':
        require __DIR__ . '/views/register.php';
        break;
    case '/login':
        require __DIR__ . '/views/login.php';
        break;
    case '/logout':
        require __DIR__ . '/views/logout.php';
        break;
    case '/like':
        require __DIR__ . '/views/like.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}