<?php if (!defined('BLOG_APP')) { http_response_code(403); exit; } ?>
<article>
    <h2><?= $escape($article['title']) ?></h2>
    <p>Автор: <?= $escape($author['nickname'] ?? 'Автор не найден') ?></p>
    <p><?= nl2br($escape($article['text'])) ?></p>
</article>
