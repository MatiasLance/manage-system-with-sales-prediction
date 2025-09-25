<?php
ob_start();
session_start();

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use jcobhams\NewsApi\NewsApi;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

try {
    $newsapi = new NewsApi($_ENV['NEWS_API_KEY']);

    $response = $newsapi->getEverything(
        'Philippines',
        null,
        null,
        null,
        null,
        null,
        'en',
        'popularity',
        20,
        1
    );

    ob_end_clean();
    
    header('Content-Type: application/json');

    $output = [
        'status' => $response->status,
        'totalResults' => $response->totalResults,
        'articles' => []
    ];

    foreach ($response->articles as $article) {
        $output['articles'][] = [
            'source' => $article->source->name,
            'title' => $article->title,
            'description' => $article->description,
            'url' => $article->url,
            'publishedAt' => $article->publishedAt,
            'content' => $article->content
        ];
    }

    echo json_encode($output['articles']);

} catch (Exception $e) {
    ob_end_clean();
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'status' => 'error'
    ]);
    exit;
}