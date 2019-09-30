<?php
/**
 * @license MIT
 * @author Basic App Dev Team
 */
namespace BasicApp\User\Models\Admin;

abstract class BaseUser extends \BasicApp\User\Models\User
{

	protected $modelClass = UserModel::class;

}