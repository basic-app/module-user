<?php

use BasicApp\Site\Models\PageModel;
use BasicApp\System\SystemEvents;

require __DIR__ . '/_common.php';

$theme = service('theme');

$page = PageModel::getPage('member', true, [
    'page_name' => 'Member',
    'page_text' => '<p>Member area.</p>'
]);

$page->setMetaTags($this);

echo $theme->userMenu([
    'items' => SystemEvents::userMenu()
]);