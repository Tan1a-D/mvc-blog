<?php
declare(strict_types=1);
if (!defined('BLOG_APP')) { http_response_code(403); exit; }
final class ArticlesController
{
    public function __construct(private PDO $db, private string $basePath = '') {}

    public function show(int $id): void
    {
        $query = $this->db->prepare('SELECT id, title, text, author_id FROM articles WHERE id = :id');
        $query->execute(['id' => $id]);
        $article = $query->fetch();
        if ($article === false) {
            http_response_code(404);
            View::render($this->basePath, 'error.php', ['title' => 'Ошибка', 'message' => 'Статья не найдена']);
            return;
        }

        // Fetch the author only after the article has been found.
        $query = $this->db->prepare('SELECT id, nickname FROM users WHERE id = :id');
        $query->execute(['id' => $article['author_id']]);
        $author = $query->fetch();

        View::render($this->basePath, 'article.php', [
            'title' => $article['title'],
            'article' => $article,
            'author' => $author === false ? null : $author,
        ]);
    }
}
