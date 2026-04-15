<?php

use BasicApp\Page\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\SignupForm */

require __DIR__ . '/_common.php';

helper(['form']);

$this->setVar('navMenuActiveItem', 'signup');
?>
<?= $this->extend('BasicApp\Site\layouts/app-card');?>

<?= $this->section('cardBody');?>

<h1><?= lang('Signup');?></h1>

<p><?= lang('Please fill out the following fields to signup:');?></p>

<form method="POST" action="<?= site_url('user/signup');?>">
    <div class="mb-3">
        <label><?= lang('Username');?>:</label>
        <input name="username" 
            type="text" 
            class="form-control"
            value="<?= set_value('username', $data['username'] ?? '');?>" 
            autofocus />
    </div>
    <div class="mb-3">
        <label><?= lang('E-mail');?>:</label>
        <input name="email" 
            type="email" 
            class="form-control"
            value="<?= set_value('email', $data['email'] ?? '');?>" />
    </div>
    <div class="mb-3">
        <label><?= lang('Password');?>:</label>
        <input name="password" class="form-control" type="password" value="" />
    </div>
    <?php foreach($errors as $error):?>
        <div class="alert alert-danger"><?= $error;?></div>
    <?php endforeach;?>
    <div class="mb-5">
        <button type="submit" class="btn btn-primary"><?= lang('Signup');?></button>
    </div>
</form>
<?= $this->endSection();?>