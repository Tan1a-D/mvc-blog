-- Import into if0_43500458_contacts. The contacts table is not modified.
SET NAMES utf8mb4;
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS articles (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    text TEXT NOT NULL,
    author_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_blog_article_author FOREIGN KEY (author_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO users (id, nickname)
SELECT 1, 'tania' WHERE NOT EXISTS (SELECT 1 FROM users WHERE id = 1);
INSERT INTO users (id, nickname)
SELECT 2, 'editor' WHERE NOT EXISTS (SELECT 1 FROM users WHERE id = 2);
INSERT INTO articles (id, title, text, author_id)
SELECT 1, 'Статья 1', 'Всем привет, это текст первой статьи', 1
WHERE NOT EXISTS (SELECT 1 FROM articles WHERE id = 1);
INSERT INTO articles (id, title, text, author_id)
SELECT 2, 'Статья 2', 'Всем привет, это текст второй статьи', 2
WHERE NOT EXISTS (SELECT 1 FROM articles WHERE id = 2);
