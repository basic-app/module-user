<?php

use BasicApp\Page\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\PasswordResetRequestForm */

require __DIR__ . '/_common.php';

$page = PageModel::getPage('user/requestPasswordReset', true, [
    'page_name' => 'Request password reset',
    'page_text' => '<p>Please fill out your email. A link to reset password will be sent there.</p>'
]);

$page->setMetaTags($this);

$this->data['breadcrumbs'][] = $page->page_name;

$theme = service('theme');

echo PageModel::pageText($page);

$form = $theme->createForm($model, $errors);

echo $form->open();

echo $form->inputGroup($data, 'email', ['autofocus' => true]);

echo $form->renderErrors();

echo $form->beginButtons();

$submit = t('user', 'Send');

echo $form->submitButton($submit);

echo $form->endButtons();

echo $form->close();