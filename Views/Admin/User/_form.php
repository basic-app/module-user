<?php

use BasicApp\Helpers\Html;

$adminTheme = service('adminTheme');

$form = $adminTheme->createForm($model, $errors);

echo $form->open();

echo $form->inputGroup($data, 'user_name');

echo $form->inputGroup($data, 'user_email');

echo $form->passwordGroup($data, 'user_password');

$link = '';

if ($data->user_verification_token)
{
    $link = ' (<a target="_blank" href="' 
        . $data->getVerificationUrl() 
        . '">' 
        .  t('user', 'URL')
        . '</a>)';
}

echo $form->inputGroup($data, 'user_verification_token', ['disabled' => true], [
    'label' => $data->getFieldLabel('user_verification_token') . $link
]);

$link = '';

if ($data->user_password_reset_token)
{
    $link = ' (<a target="_blank" href="'
        . $data->getResetPasswordUrl()
        .'">'
        . t('user', 'URL')
        .'</a>)';
}

echo $form->inputGroup($data, 'user_password_reset_token', ['disabled' => true], [
    'label' => $data->getFieldLabel('user_password_reset_token') . $link
]);

echo $form->checkboxGroup($data, 'user_enabled');

echo $form->renderErrors();

echo $form->beginButtons();

$label = $data->getPrimaryKey() ? t('admin', 'Update') : t('admin', 'Insert');

echo $form->endButtons();

echo $form->submitButton($label);

echo $form->close();