<?php

use BasicApp\Page\Models\PageModel;
use BasicApp\Member\MemberEvents;

require __DIR__ . '/_common.php';

$theme = service('theme');

$page = PageModel::getPage('member', true, [
    'page_name' => 'Member',
    'page_text' => '<p>Member area.</p>'
]);

$page->setMetaTags($this);

echo PageModel::pageText($page);

echo $theme->userMenu([
    'items' => MemberEvents::memberMenu()
]);