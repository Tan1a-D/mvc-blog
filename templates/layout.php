<?php if (!defined('BLOG_APP')) { http_response_code(403); exit; } ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $escape($title) ?></title>
    <link rel="stylesheet" href="<?= $escape($basePath) ?>/styles/styles.css">
</head>
<body>
<table class="layout">
    <tr><td colspan="2" class="header">Мой блог</td></tr>
    <tr>
        <td class="content"><?= $content ?></td>
        <td class="sidebar">
            <div class="sidebarHeader">Меню</div>
            <ul>
                <li><a href="<?= $escape($basePath) ?>/">Главная страница</a></li>
                <li><a href="<?= $escape($basePath) ?>/about-me">Обо мне</a></li>
                <li><a href="<?= $escape($basePath) ?>/bye/<?= rawurlencode('Татьяна') ?>">Попрощаться с Татьяной</a></li>
            </ul>
        </td>
    </tr>
    <tr><td class="footer" colspan="2">Все права защищены (c) Мой блог</td></tr>
</table>
</body>
</html>
