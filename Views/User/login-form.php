<?php

$form = $theme->createForm($model, $errors);

echo $form->open();

echo $form->inputGroup($data, 'email', ['autofocus' => true]);

echo $form->passwordGroup($data, 'password');

echo $form->checkboxGroup($data, 'rememberMe');

echo $form->renderErrors();

echo $form->beginButtons();

$submit = t('user', 'Login');

echo $form->submitButton($submit);

echo $form->endButtons();

echo $form->close();