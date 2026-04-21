<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link http://basic-app.com
 */
namespace BasicApp\User\Controllers;

use Exception;
use CodeIgniter\Exceptions\PageNotFoundException;
use BasicApp\User\Models\UserModel;
use BasicApp\User\Forms\LoginForm;
use BasicApp\User\Forms\SignupForm;
use BasicApp\User\Forms\PasswordResetRequestForm;
use BasicApp\User\Forms\ResendVerificationEmailForm;
use BasicApp\User\Forms\ResetPasswordForm;
use App\Controllers\BaseController;

class User extends BaseController
{
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function signup()
    {
        $model = new SignupForm;

        $data = $this->request->getPost();

        $errors = [];

        if ($data && $model->validate($data))
        {
            if (($user = $model->signup($data, $error)) && $model->sendEmail($user, $error))
            {
                $session = service('session');

                $session->setFlashdata(
                    'success', 
                    'Thank you for registration. Please check your inbox for verification email.'
                );
            
                return redirect('/');
            }
            else
            {
                $errors[] = $error;
            }
        }

        $data['password'] = '';

        return view('BasicApp\User\signup', [
            'model' => $model,
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors)
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function login()
    {
        helper(['auth']);

        if (user_id())
        {
            return redirect('/');
        }

        $model = new LoginForm;

        $data = $this->request->getPost();

        $errors = [];
        
        if ($data && $model->validate($data))
        {
            $rememberMe = array_key_exists('rememberMe', $data) ? $data['rememberMe'] : 0;

            $user = $model->getUser();

            login($user->getPrimaryKey(), $rememberMe);

            return redirect('/');
        }
        else
        {
            $errors = (array) $model->errors();
        }

        if (!$data)
        {
            $data['rememberMe'] = 1;
        }

        return view('BasicApp\User\login', [
            'model' => $model,
            'errors' => $errors,
            'data' => $data,
            'attributes' => [
                'email' => lang('E-mail'),
                'password' => lang('Password'),
                'rememberMe' => lang('Remember Me')
            ]
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return mixed
     */
    public function verifyEmail($id, $token)
    {
        $user = UserModel::findByPk($id);

        if (!$user)
        {
            throw new PageNotFoundException;
        }

        if (!UserModel::setUserVerification($user, $token, $error))
        {
            throw new Exception($error);
        }

        $session = service('session');

        $session->setFlashdata('success', 'Your email has been confirmed!');

        return redirect('user/login');
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function resendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm;
        
        $errors = [];

        $data = $this->request->getPost();

        if ($data && $model->validate($data))
        {
            if ($model->sendEmail($error))
            {
                $session = service('session');

                $session->setFlashdata('success', 'Check your email for further instructions.');
            
                return redirect('/');
            }
            else
            {
                $errors[] = $error;
            }
        }

        return view('BasicApp\User\resendVerificationEmail', [
            'model' => $model,
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors)
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function requestPasswordReset()
    {
        $model = new PasswordResetRequestForm;

        $model->validate([]);

        $data = $this->request->getPost();

        $errors = [];
        
        if ($data && $model->validate($data))
        {
            if ($model->sendEmail($error))
            {
                $session = service('session');

                $session->setFlashdata('success', 'Check your email for further instructions.');

                return redirect('/');
            }
            else
            {
                //'Sorry, we are unable to reset password for the provided email address.'

                $errors[] = $error; 
            }
        }

        return view('BasicApp\User\requestPasswordReset', [
            'model' => $model,
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors)
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     */
    public function resetPassword($id, $token)
    {
        $user = UserModel::findByPk($id);

        if (!$user)
        {
            throw new PageNotFoundException;
        }

        if (UserModel::getUserField($user, 'password_reset_token') != $token)
        {
            throw new Exception('Wrong password reset token.');
        }

        $errors = [];

        $model = new ResetPasswordForm;

        $data = $this->request->getPost();

        if ($data && $model->validate($data))
        {
            if ($model->resetPassword($user, $data, $error))
            {
                $session = service('session');

                $session->setFlashdata('success', 'New password saved.');

                return redirect('user/login');
            }
            else
            {
                $errors[] = $error;
            }
        }

        return view('BasicApp\User\resetPassword', [
            'model' => $model,
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors),
            'id' => $id,
            'token' => $token
        ]);
    }
}