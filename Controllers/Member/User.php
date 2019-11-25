<?php

namespace BasicApp\User\Controllers\Member;

use BasicApp\User\Forms\ProfileForm;

class User extends \BasicApp\User\MemberController
{

    protected $viewPath = 'BasicApp\User\Views\Member';
    
    /**
     * Member page.
     *
     * @return mixed
     */
    public function index()
    {
        return $this->render('index');
    }

    /**
     * Edit profile.
     *
     * @return mixed
     */
    public function profile()
    {
        $model = new ProfileForm;

        $data = new \CodeIgniter\Entity;

        $data->fill($this->user->toArray());

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