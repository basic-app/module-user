<?php

use App\Widgets\FormGroup;

/* @var $this \CodeIgniter\View\View */
/* @var $model \App\Models\PasswordResetRequestForm */

$this->data['title'] = 'Request password reset';

$this->data['breadcrumbs'][] = $this->data['title'];

helper(['form']);

?>
    
<p>Please fill out your email. A link to reset password will be sent there.</p>

<?= form_open('user/requestPasswordReset', ['id' => 'request-password-reset-form']);?>

<?= view('_errors', ['errors' => $errors]);?>

<?= FormGroup::factory([
    'content' => form_input(
        'email', 
        array_key_exists('email', $data) ? $data['email'] : '', 
        [
            'class' => 'form-control',
            'autofocus' => true
        ]
    ),
    'label' => $model->getFieldLabel('email'),
    'error' => array_key_exists('email', $errors) ? $errors['email'] : null
]);?>

<div class="form-group">

    <?= form_submit('submit', 'Send', ['class' => 'btn btn-primary']);?>

</div>

<?php form_close();?>