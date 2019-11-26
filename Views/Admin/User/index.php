<?php

use BasicApp\User\Models\UserModel;
use BasicApp\Helpers\Url;

require __DIR__ . '/_common.php';

unset($this->data['breadcrumbs'][count($this->data['breadcrumbs']) - 1]['url']);

$this->data['actionMenu'][] = [
	'url' => Url::returnUrl('admin/user/create'), 
	'label' => t('admin', 'Create'), 
	'icon' => 'fa fa-plus',
	'linkAttributes' => [
		'class' => 'btn btn-success'
	]	
];

$adminTheme = service('adminTheme');

echo $adminTheme->table([
    'labels' => [
        UserModel::fieldLabel('user_id'),
        UserModel::fieldLabel('user_created_at'),
        UserModel::fieldLabel('user_email'),
        UserModel::fieldLabel('user_name'),
        UserModel::fieldLabel('user_enabled'),
        '',
        ''
    ],
    'elements' => $elements,
    'columns' => function($model) {
        return [
            $this->createColumn(['field' => 'user_id'])->number()->displaySmall(),
            $this->createColumn(['field' => 'user_created_at'])->displayMedium(),
            $this->createColumn(['field' => 'user_email'])->success(),
            $this->createColumn(['field' => 'user_name']),
            $this->createBooleanColumn(['field' => 'user_enabled']),
            $this->createUpdateLinkColumn(['action' => 'admin/user/update']),
            $this->createDeleteLinkColumn(['action' => 'admin/user/delete'])
        ];
    }
]);

if ($pager)
{
    echo $pager->links('default', 'adminTheme');
}