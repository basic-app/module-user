<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\User\Controllers\Member;

use App\Controllers\BaseController;

class Logout extends BaseController
{
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function index()
    {
        helper(['auth']);

        logout('user');

        return redirect('/');
    }
}