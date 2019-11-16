<?php

use BasicApp\Site\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\SignupForm */

$theme = service('theme');

$page = PageModel::getPage('user/signup', true, [
    'page_name' => 'Signup',
    'page_text' => '<p>Please fill out the following fields to signup:</p>'
]);

$page->setMetaTags($this);

$this->data['breadcrumbs'][] = $this->data['title'];

echo PageModel::pageText($page);

$form = $theme->createForm($model, $errors);

echo $form->open();

echo $form->inputGroup($data, 'username');

echo $form->inputGroup($data, 'email');

echo $form->passwordGroup($data, 'password');

echo $form->renderErrors();

echo $form->beginButtons();

$submit = t('user', 'Signup');

echo $form->submitButton($submit);

echo $form->endButtons();

echo $form->close();