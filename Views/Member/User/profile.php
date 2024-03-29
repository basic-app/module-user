<?php

use BasicApp\Page\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\ProfileForm */

require __DIR__ . '/_common.php';

$theme = service('theme');

$page = PageModel::getPage('member/user/profile', true, [
    'page_name' => 'Edit Profile',
    'page_text' => '<p>Please fill out the following fields:</p>'
]);

$page->setMetaTags($this);

$this->data['title'] = t('site', 'Profile');

$this->data['breadcrumbs'][] = $this->data['title'];

$this->data['userMenu']['profile']['active'] = true;

echo PageModel::pageText($page);

$form = $theme->createForm($model, $errors);

echo $form->open();

echo $form->inputGroup($data, 'user_name', ['autofocus' => true]);

echo $form->inputGroup($data, 'user_email', ['disabled' => true]);

echo $form->passwordGroup($data, 'password');

echo $form->renderErrors();

echo $form->beginButtons();

$submit = t('user', 'Update');

echo $form->submitButton($submit);

echo $form->endButtons();

echo $form->close();