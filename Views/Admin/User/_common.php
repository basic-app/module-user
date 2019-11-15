<?php

use BasicApp\Helpers\Url;

$title = t('admin.menu', 'Users');

$this->data['mainMenu']['users']['active'] = true;

$this->data['breadcrumbs'][] = ['label' => $title, 'url' => Url::createUrl('admin/user')];

$this->data['title'] = $title;
