<?php
declare(strict_types=1);
if (!defined('BLOG_APP')) { http_response_code(403); exit; }
final class MainController
{
    public function __construct(private string $basePath = '') {}

    public function index(): void
    {
        $this->render('home.php', 'Мой блог');
    }

    public function aboutMe(): void
    {
        $this->render('about.php', 'Обо мне');
    }

    public function sayBye(string $name): void
    {
        $this->render('bye.php', 'До встречи', ['name' => $name]);
    }

    public function error(string $message): void
    {
        $this->render('error.php', 'Ошибка', ['message' => $message]);
    }

    private function render(string $template, string $title, array $data = []): void
    {
        $basePath = $this->basePath;
        $escape = static fn(string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        extract($data, EXTR_SKIP);
        ob_start();
        require dirname(__DIR__, 2) . '/templates/' . $template;
        $content = ob_get_clean();
        require dirname(__DIR__, 2) . '/templates/layout.php';
    }
}
