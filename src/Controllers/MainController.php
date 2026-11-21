<?php
declare(strict_types=1);
if (!defined('BLOG_APP')) { http_response_code(403); exit; }
final class MainController
{
    public function __construct(private string $basePath = '') {}

    public function index(): void
    {
        $this->render('home.php');
    }

    public function aboutMe(): void
    {
        $this->render('about.php', ['title' => 'Обо мне']);
    }

    public function sayBye(string $name): void
    {
        $this->render('bye.php', ['title' => 'До встречи', 'name' => $name]);
    }

    public function sayHello(string $name): void
    {
        $this->render('hello.php', ['title' => 'Страница приветствия', 'name' => $name]);
    }

    public function error(string $message): void
    {
        $this->render('error.php', ['title' => 'Ошибка', 'message' => $message]);
    }

    private function render(string $template, array $data = []): void
    {
        View::render($this->basePath, $template, $data);
    }
}
