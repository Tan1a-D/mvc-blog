<?php if (!defined('BLOG_APP')) { http_response_code(403); exit; } ?>
<h2><?= $escape($message) ?></h2>
<p><a href="<?= $escape($basePath) ?>/">На главную страницу</a></p>
