<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Controllers\Member;

use BasicApp\User\Forms\ProfileForm;
use CodeIgniter\Entity;

class User extends \BasicApp\Member\MemberController
{

    protected $viewPath = 'BasicApp\User\Views\Member\User';

    /**
     * Edit profile.
     *
     * @return mixed
     */
    public function profile()
    {
        $user = service('user')->getUser();

        $model = new ProfileForm;

        $data = new Entity;

        $data->fill($user->toArray());

        $post = $this->request->getPost();

        $errors = [];

        if ($post)
        {
            $data->fill($post);

            if ($model->saveProfile($data, $error))
            {
                $session = service('session');

                $session->setFlashdata('success', 'Profile updated successfully.');
            }
            else
            {
                $errors[] = $error;
            }
        }

        $data->password = '';

        return $this->render('profile', [
            'model' => $model,
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors)
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function logout()
    {
        service('user')->logout();

        return $this->goHome();
    }

}