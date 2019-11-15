<?php

use App\Widgets\FormGroup;

/* @var $this \CodeIgniter\View\View */
/* @var $model \App\Models\LoginForm */

$this->data['title'] = 'Login';

$this->data['breadcrumbs'][] = $this->data['title'];

helper(['form']);
?>

<p>Please fill out the following fields to login:</p>

<?= form_open('user/login', ['id' => 'login-form']);?>

<?= view('_errors', ['errors' => $errors]);?>

<?= FormGroup::factory([
    'content' => form_input(
        'email', 
        array_key_exists('email', $data) ? $data['email'] : '', 
        [
            'autofocus' => true,
            'class' => 'form-control'
        ]
    ),
    'label' => $model->getFieldLabel('email'),
    'error' => array_key_exists('email', $errors) ? $errors['email'] : null
]);?>

<?= FormGroup::factory([
    'content' => form_password(
        'password', 
        '', 
        [
            'class' => 'form-control'
        ]
    ),
    'label' => $model->getFieldLabel('password'),
    'error' => array_key_exists('password', $errors) ? $errors['password'] : null
]);?>

<?= form_hidden('rememberMe', 0);?>

<?= FormGroup::factory([
    'content' => '<br>'. form_checkbox(
        'rememberMe',
        '1',
        (array_key_exists('rememberMe', $data) && $data['rememberMe']) ? true : false,
        [
            'id' => 'remember-me-checkbox'
        ]
    ),
    'label' => $model->getFieldLabel('rememberMe'),
    'labelOptions' => [
        'class' => 'mb-0',
        'for' => 'remember-me-checkbox'
    ],
    'error' => array_key_exists('rememberMe', $errors) ? $errors['rememberMe'] : null
]);?>

<div class="form-group">
    
    <?= form_submit('login-button', 'Login', ['class' => 'btn btn-primary']);?>

</div>

<?= form_close();?>