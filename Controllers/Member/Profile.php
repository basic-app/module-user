<?php
/**
 * @author Basic App Dev Team
 * @license MIT
 */
namespace BasicApp\User\Controllers\Member;

use BasicApp\User\Forms\ProfileForm;
use CodeIgniter\Entity\Entity;
use App\Controllers\BaseController;

class Profile extends BaseController
{
    /**
     * Edit profile.
     *
     * @return mixed
     */
    public function index()
    {
        helper(['user']);

        $user = user();

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

        return view('BasicApp\User\member/profile', [
            'model' => $model,
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors)
        ]);
    }
}