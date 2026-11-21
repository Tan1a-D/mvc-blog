<?php
declare(strict_types=1);
if (!defined('BLOG_APP')) { http_response_code(403); exit; }
final class View
{
    public static function render(string $basePath, string $template, array $data = []): void
    {
        $escape = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        extract($data, EXTR_SKIP);
        ob_start();
        require dirname(__DIR__) . '/templates/' . $template;
        $content = ob_get_clean();
        require dirname(__DIR__) . '/templates/layout.php';
    }
}
