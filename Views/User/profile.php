<?php

use BasicApp\Site\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\SignupForm */

$theme = service('theme');

$page = PageModel::getPage('user/profile', true, [
    'page_name' => 'Profile',
    'page_text' => '<p>Please fill out the following fields:</p>'
]);

$page->setMetaTags($this);

$this->data['breadcrumbs'][] = $this->data['title'];

$this->data['accountMenu']['profile']['active'] = true;

echo PageModel::pageText($page);

$form = $theme->createForm($model, $errors);

echo $form->open();

echo $form->inputGroup($data, 'user_name', ['autofocus' => true]);

//echo $form->inputGroup($data, 'email');

echo $form->passwordGroup($data, 'password');

echo $form->renderErrors();

echo $form->beginButtons();

$submit = t('user', 'Update');

echo $form->submitButton($submit);

echo $form->endButtons();

echo $form->close();