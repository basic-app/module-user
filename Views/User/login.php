<?php

use BasicApp\Page\Models\PageModel;
use BasicApp\Helpers\Url;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\LoginForm */

require __DIR__ . '/_common.php';

$theme = service('theme');

$page = PageModel::getPage('user/login', true, [
    'page_name' => 'Login',
    'page_text' => '<p>If you forgot your password you <a href="{resetPasswordUrl}">can reset it</a>. Need new verification email? <a href="{resendVerificationUrl}">Resend</a>.</p>' . '<p> Please fill out the following fields to login:</p>'
]);

$page->setParams([
    '{resetPasswordUrl}' => Url::createUrl('user/requestPasswordReset'),
    '{resendVerificationUrl}' => Url::createUrl('user/resendVerificationEmail')
]);

$page->setMetaTags($this);

$this->data['breadcrumbs'][] = $page->page_name;

$this->data['accountMenu']['login']['active'] = true;

echo PageModel::pageText($page);

echo app_view('BasicApp\User\Views\User\login-form', [
    'model' => $model, 
    'errors' => $errors, 
    'data' => $data,
    'theme' => $theme
]);?>