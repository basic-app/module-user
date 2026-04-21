<?php

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\LoginForm */

helper(['language', 'url', 'form']);

require __DIR__ . '/_common.php';

$this->setVar('navMenuActiveItem', 'login');

?>

<?= $this->extend('BasicApp\Site\layouts/app-card');?>

<?= $this->section('cardBody');?>

<h1><?= lang('Login');?></h1>

<p><?= lang('If you forgot your password you <a href="{resetPasswordUrl}">can reset it</a>. Need new verification email? <a href="{resendVerificationUrl}">Resend</a>.', [
    'resetPasswordUrl' => site_url('user/requestPasswordReset'),
    'resendVerificationUrl' => site_url('user/resendVerificationEmail')
]);?></p>

<p><?= lang('Please fill out the following fields to login:');?></p>

<form method="POST" action="<?= site_url('user/login');?>">
    
    <?= view_cell('Site::formInputGroup', [
        'attributes' => [
            'type' => 'email',
            'name' => 'email',
            'value' => set_value('email', $data['email'] ?? ''),
            'autofocus' => true
        ],
        'label' => $attributes['email'] ?? 'email',
        'error' => $errors['email'] ?? null
    ]);?>

    <?= view_cell('Site::formPasswordGroup', [
        'attributes' => [
            'name' => 'password'
        ],
        'label' => $attributes['password'] ?? 'password',
        'error' => $errors['password'] ?? null
    ]);?>
    
    <?= view_cell('Site::formCheckboxGroup', [
        'attributes' => [
            'name' => 'rememberMe',
            'id' => 'rememberMe-checkbox',
            'value' => 1,
            'uncheckValue' => 0,
            'checked' => set_value('rememberMe', $data['rememberMe'] ?? 1) == 1
        ],
        'label' => $attributes['rememberMe'] ?? 'rememberMe',
        'error' => $errors['rememberMe'] ?? null
    ]);?>

    <?php foreach($errors as $error):?>
        <?= view_cell('Site::alertDanger', ['slot' => $error]);?>
    <?php endforeach;?>

    <div class="mb-5">
        <?= view_cell('Site::formSubmit', ['attributes' => [
            'value' => lang('Submit')
        ]]);?>
    </div>
</form>

<?= $this->endSection();?>