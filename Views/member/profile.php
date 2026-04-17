<?php

use BasicApp\Page\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\ProfileForm */

helper(['form']);

$this->setVar('title', lang('Edit Profile'));

$this->setVar('navMenuActiveItem', 'profile');

?>
<p><?= lang('Please fill out the following fields:');?></p>

<?= $this->extend('BasicApp\Site\layouts/app-card');?>

<?= $this->section('cardBody');?>

<form method="POST" action="<?= site_url('member/profile');?>">

    <div class="mb-3">
        <label><?= lang('User Name');?>:</label>
        <input name="user_name" 
            type="text" 
            class="form-control"
            value="<?= set_value('user_name', $data->user_name ?? '');?>" 
            autofocus />
    </div>

    <div class="mb-3">
        <label><?= lang('User E-mail');?>:</label>
        <input name="email" 
            type="email" 
            class="form-control"
            value="<?= set_value('email', $data->email ?? '');?>" 
            disabled />
    </div>
    <div class="mb-3">
        <label><?= lang('User Password');?>:</label>
        <input name="password" class="form-control" type="password" value="" />
    </div>
    
    <?php foreach($errors as $error):?>
        <?= view_cell('Site::alertDanger', ['slot' => $error]);?>
    <?php endforeach;?>

    <div class="mb-5">
        <?= view_cell('Site::submitButton', [
            'slot' => lang('Update')
        ]);?>
    </div>
</form>

<?= $this->endSection();?>