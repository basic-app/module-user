<?php

use BasicApp\Helpers\Url;

$title = t('admin.menu', 'Users');

$this->tempData['mainMenu']['users']['active'] = true;

$this->tempData['breadcrumbs'][] = ['label' => $title, 'url' => Url::createUrl('admin/user')];

$this->tempData['title'] = $title;
