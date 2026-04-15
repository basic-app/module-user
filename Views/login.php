<?php

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\LoginForm */

helper(['language', 'url', 'form']);

require __DIR__ . '/_common.php';

$this->setVar('navMenuActiveItem', 'login');

?>

<?= $this->extend('BasicApp\Site\layouts/app-card');?>

<?= $this->section('cardBody');?>

<p><?= lang('If you forgot your password you <a href="{resetPasswordUrl}">can reset it</a>. Need new verification email? <a href="{resendVerificationUrl}">Resend</a>.', [
    'resetPasswordUrl' => site_url('user/requestPasswordReset'),
    'resendVerificationUrl' => site_url('user/resendVerificationEmail')
]);?></p>

<p><?= lang('Please fill out the following fields to login:');?></p>

<form method="POST" action="<?= site_url('user/login');?>">
    <div class="mb-3">
        <label><?= lang('E-mail');?>:</label>
        <input name="email" 
            type="email" 
            class="form-control"
            value="<?= set_value('email', $data['email'] ?? '');?>" 
            autofocus />
    </div>
    <div class="mb-3">
        <label><?= lang('Password');?>:</label>
        <input name="password" class="form-control" type="password" value="" />
    </div>
    <div class="mb-3">
        <input type="hidden" name="rememberMe" value="0" />
        <label><?= form_checkbox([
            'name' => 'rememberMe',
            'value' => 1,
            'checked' => set_value('rememberMe', $data['rememberMe'] ?? 1) == 1
        ]);?> <?= lang('Remember Me');?></label>
    </div>
    <?php foreach($errors as $error):?>
        <div class="alert alert-danger"><?= $error;?></div>
    <?php endforeach;?>
    <div class="mb-5">
        <button type="submit" class="btn btn-primary"><?= lang('Submit');?></button>
    </div>
</form>

<?= $this->endSection();?>