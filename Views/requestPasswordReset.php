<?php

use BasicApp\Page\Models\PageModel;

/* @var $this \CodeIgniter\View\View */
/* @var $model \BasicApp\User\Forms\PasswordResetRequestForm */

require __DIR__ . '/_common.php';

helper(['form']);

$page = PageModel::getPage('user/requestPasswordReset', true, [
    'page_name' => 'Request password reset',
    'page_text' => '<p>Please fill out your email. A link to reset password will be sent there.</p>'
]);

$page->setMetaTags($this);
?>

<?= $this->extend('BasicApp\Site\layouts/app-card');?>

<?= $this->section('cardBody');?>

<form method="POST" action="<?= site_url('user/requestPasswordReset');?>">
    <div class="mb-3">
        <label><?= lang('E-mail');?>:</label>
        <input name="email" 
            type="email" 
            class="form-control"
            value="<?= set_value('email', $data['email'] ?? '');?>" 
            autofocus />
    </div>
    <?php foreach($errors as $error):?>
        <div class="alert alert-danger"><?= $error;?></div>
    <?php endforeach;?>
    <div class="mb-5">
        <button type="submit" class="btn btn-primary"><?= lang('Submit');?></button>
    </div>
</form>
<?= $this->endSection();?>