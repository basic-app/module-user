<?php

$adminTheme = service('adminTheme');

$form = $adminTheme->createForm($model, $errors);

echo $form->open();

echo $form->inputGroup($data, 'user_name');

echo $form->inputGroup($data, 'user_email');

echo $form->passwordGroup($data, 'user_password');

echo $form->checkboxGroup($data, 'user_enabled');

echo $form->renderErrors();

echo $form->beginButtons();

$label = $data->getPrimaryKey() ? t('admin', 'Update') : t('admin', 'Insert');

echo $form->endButtons();

echo $form->submitButton($label);

echo $form->close();