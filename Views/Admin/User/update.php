<?php

require __DIR__ . '/_common.php';

$this->tempData['breadcrumbs'][] = ['label' => t('admin', 'Update')];

$this->tempData['enableCard'] = true;

$this->tempData['cardTitle'] = $this->tempData['title'];

$this->extend('BasicApp\Admin/layouts/app');

$this->section('content');

echo app_view('BasicApp\User\Admin\User\_form', [
    'model' => $model,
    'errors' => $errors
]);

$this->endSection();