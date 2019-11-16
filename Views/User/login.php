<?php

use BasicApp\Site\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\LoginForm */

$theme = service('theme');

$page = PageModel::getPage('user/login', true, [
    'page_name' => 'Login',
    'page_text' => '<p>Please fill out the following fields to login:</p>'
]);

$page->setMetaTags($this);

$this->data['breadcrumbs'][] = $this->data['title'];

echo PageModel::pageText($page);

$form = $theme->createForm($model, $errors);

echo $form->open();

echo $form->inputGroup($data, 'email');

echo $form->passwordGroup($data, 'password');

echo $form->checkboxGroup($data, 'rememberMe');

echo $form->renderErrors();

echo $form->beginButtons();

$submit = t('user', 'Login');

echo $form->submitButton($submit);

echo $form->endButtons();

echo $form->close();