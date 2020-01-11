<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Models\Admin;

abstract class BaseUser extends \BasicApp\User\Models\User
{

	protected $modelClass = UserModel::class;

}