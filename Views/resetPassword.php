<?php

use BasicApp\Page\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\ResetPasswordForm */

require __DIR__ . '/_common.php';

$theme = service('theme');

$page = PageModel::getPage('user/resetPassword', true, [
    'page_name' => 'Reset password',
    'page_text' => '<p>Please choose your new password:</p>'
]);

$page->setMetaTags($this);

$this->data['breadcrumbs'][] = $page->page_name;

echo PageModel::pageText($page);

$form = $theme->createForm($model, $errors);

echo $form->open();

echo $form->passwordGroup($data, 'password', ['autofocus' => true]);

echo $form->renderErrors();

echo $form->beginButtons();

$submit = t('user', 'Save');

echo $form->submitButton($submit);

echo $form->endButtons();

echo $form->close();