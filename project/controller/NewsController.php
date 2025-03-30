<?php
ob_start(); // Start output buffering to prevent header errors
session_start();

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use jcobhams\NewsApi\NewsApi;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

try {
    $newsapi = new NewsApi($_ENV['NEWS_API_KEY']);

    // Fetch top headlines about Philippines
    $response = $newsapi->getEverything(
        'Philippines',  // Query/keywords
        null,           // Sources
        null,           // Domains
        null,           // Exclude domains
        null,           // From date
        null,           // To date
        'en',           // Language
        'popularity',   // Sort by
        20,             // Page size
        1               // Page number
    );

    // Clear any previous output
    ob_end_clean();
    
    // Set JSON header
    header('Content-Type: application/json');

    // Prepare output array
    $output = [
        'status' => $response->status,
        'totalResults' => $response->totalResults,
        'articles' => []
    ];

    // Loop through articles and format the output
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

    // Output the formatted JSON
    echo json_encode($output['articles']['source']);

} catch (Exception $e) {
    // Clean output buffer before error response
    ob_end_clean();
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'status' => 'error'
    ]);
    exit;
}