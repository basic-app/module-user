<?php

use App\Widgets\FormGroup;

/* @var $this \CodeIgniter\View\View */
/* @var $model \App\Models\SignupForm */

$this->data['title'] = 'Signup';

$this->data['breadcrumbs'][] = $this->data['title'];

helper(['form']);

?>
    
<p>Please fill out the following fields to signup:</p>

<?= view('_errors', ['errors' => $errors]);?>

<?= form_open('user/signup', ['id' => 'form-signup']);?>

<?= FormGroup::factory([
    'content' => form_input(
        'username', 
        array_key_exists('username', $data) ? $data['username'] : '', 
        [
            'autofocus' => true, 
            'class' => 'form-control'
        ]
    ),
    'label' => $model->getFieldLabel('username'),
    'error' => array_key_exists('username', $errors) ? $errors['username'] : null
]);?>

<?= FormGroup::factory([
    'content' => form_input(
        'email', 
        array_key_exists('email', $data) ? $data['email'] : '', 
        [
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

<div class="form-group">

    <?= form_submit('signup-button', 'Signup', ['class' => 'btn btn-primary']);?>

</div>

<?= form_close();?>