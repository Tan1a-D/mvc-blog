<?php
declare(strict_types=1);
header('Content-Type: text/html; charset=UTF-8');
define('BLOG_APP', true);
require __DIR__ . '/src/View.php';
require __DIR__ . '/src/Database.php';
require __DIR__ . '/src/Controllers/MainController.php';
require __DIR__ . '/src/Controllers/ArticlesController.php';
// Derive the hosting subdirectory so the same project works at / and /mvc-blog/.
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = $basePath === '/' || $basePath === '.' ? '' : rtrim($basePath, '/');
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (!is_string($path)) { http_response_code(400); exit('Некорректный адрес'); }
if ($basePath !== '' && ($path === $basePath || str_starts_with($path, $basePath . '/'))) $path = substr($path, strlen($basePath));
$path = $path === '' ? '/' : $path;
$controller = new MainController($basePath);
if (preg_match('~^/articles/([1-9][0-9]*)/?$~', $path, $matches) === 1) {
    $id = filter_var($matches[1], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($id === false) {
        http_response_code(404); $controller->error('Статья не найдена'); exit;
    }
    try {
        $articles = new ArticlesController(Database::connect(), $basePath);
        $articles->show($id);
    } catch (Throwable $error) {
        http_response_code(500);
        error_log('Article loading failed: ' . $error->getMessage());
        $controller->error('Не удалось загрузить статью. Проверьте подключение к базе данных.');
    }
    exit;
}
$routes = [
    '~^/$~' => 'index',
    '~^/about-me/?$~' => 'aboutMe',
    '~^/bye/([^/]+)/?$~u' => 'sayBye',
    '~^/hello/([^/]+)/?$~u' => 'sayHello',
];
foreach ($routes as $pattern => $action) {
    if (preg_match($pattern, $path, $matches) !== 1) continue;
    if (in_array($action, ['sayBye', 'sayHello'], true)) {
        $name = rawurldecode($matches[1]);
        if (preg_match('//u', $name) !== 1 || preg_match('/[[:cntrl:]]/u', $name) || str_contains($name, '/') || str_contains($name, chr(92)) || trim($name) === '' || strlen($name) > 400) {
            http_response_code(400); $controller->error('Некорректное имя'); exit;
        }
        $controller->$action($name);
    } else { $controller->$action(); }
    exit;
}
http_response_code(404);
$controller->error('Страница не найдена');
