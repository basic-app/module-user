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

echo $adminTheme->grid([
    'headers' => [
        ['class' => $adminTheme::GRID_HEADER_PRIMARY_KEY, 'content' => $model->getFieldLabel('user_id')],
        $model->getFieldLabel('user_created_at'),
        [
            'class' => $adminTheme::GRID_HEADER_LABEL,
            'content' => $model->getFieldLabel('user_email')
        ],
        [
            'class' => $adminTheme::GRID_HEADER_MEDIUM, 
            'content' => $model->getFieldLabel('user_name')
        ],
        ['class' => $adminTheme::GRID_HEADER_BOOLEAN, 'content' => $model->getFieldLabel('user_enabled')],
        ['class' => $adminTheme::GRID_HEADER_BUTTON_UPDATE],
        ['class' => $adminTheme::GRID_HEADER_BUTTON_DELETE]
    ],
    'items' => function() use ($elements, $adminTheme) {

        foreach($elements as $data)
        {
            yield [
                $data->user_id,
                $data->user_created_at,
                $data->user_email,
                $data->user_name,
                $data->user_enabled,
                ['url' => Url::createUrl('admin/user/update', ['id' => $data->user_id])],
                ['url' => Url::createUrl('admin/user/delete', ['id' => $data->user_id])]
            ];
        }
    }
]);

if ($pager)
{
    echo $pager->links('default', 'adminTheme');
}