<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Components;

use Exception;

abstract class BaseUserFilter extends \BasicApp\Filters\AuthFilter
{

    public $userService = 'user';

    public function __construct()
    {
        parent::__construct();

        $service = $this->getUserService();

        if (!$service)
        {
            $error = 'User service is required.';

            throw new Exception($error);
        }
    }

}