<?php

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

// $api_host = "http://127.0.0.1:8000";
$api_host = "https://health-diet.jerit.in";



$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/api-admin') {
  header('Location: ' . $api_host . '/admin');

  exit();
}


switch (true) {
  case $uri === '/':
    echo $twig->render('pages/index.twig', ['api_host' => $api_host]);
    break;
  case $uri === '/register':
    echo $twig->render('pages/signup.twig', ['api_host' => $api_host]);
    break;
  case $uri === '/login':
    echo $twig->render('pages/login.twig', ['api_host' => $api_host]);
    break;
  case preg_match('#^/articles/(\d+)$#', $uri, $matches) === 1:
    $articleID = $matches[1];
    echo $twig->render('pages/article.twig', ['api_host' => $api_host, 'articleId' => $articleID]);
    break;
  case preg_match('#^/plans/(\d+)$#', $uri, $matches) === 1:
    $planId = $matches[1];
    echo $twig->render('pages/plan.twig', ['api_host' => $api_host, 'planId' => $planId]);
    break;
  case $uri === '/admin':
    echo $twig->render('pages/admin.twig', ['api_host' => $api_host]);
    break;
    default:
      http_response_code(404);
      echo "Page Not Found";
      exit();
}
