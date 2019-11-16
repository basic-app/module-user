<?php

use BasicApp\Site\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\PasswordResetRequestForm */

$page = PageModel::getPage('user/requestPasswordReset', true, [
    'page_name' => 'Request password reset',
    'page_text' => '<p>Please fill out your email. A link to reset password will be sent there.</p>'
]);

$page->setMetaTags($this);

$this->data['breadcrumbs'][] = $this->data['title'];

$theme = service('theme');

echo PageModel::pageText($page);

$form = $theme->createForm($model, $errors);

echo $form->open();

echo $form->inputGroup($data, 'email');

echo $form->renderErrors();

echo $form->beginButtons();

$submit = t('user', 'Send');

echo $form->submitButton($submit);

echo $form->endButtons();

echo $form->close();