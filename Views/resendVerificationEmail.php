<?php

use BasicApp\Page\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\ResendVerificationEmailForm */

require __DIR__ . '/_common.php';

$theme = service('theme');

$page = PageModel::getPage('user/resendVerificationEmail', true, [
    'page_name' => 'Resend verification email',
    'page_text' => '<p>Please fill out your email. A verification email will be sent there.</p>'
]);

$page->setMetaTags($this);

$this->data['breadcrumbs'][] = $page->page_name;

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