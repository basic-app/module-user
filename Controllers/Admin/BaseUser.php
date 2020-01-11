<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Controllers\Admin;

use BasicApp\User\Models\Admin\UserModel;

abstract class BaseUser extends \BasicApp\Admin\AdminCrudController
{

	protected $modelClass = UserModel::class;

	protected $viewPath = 'BasicApp\User\Admin\User';

	protected $returnUrl = 'admin/user';

}