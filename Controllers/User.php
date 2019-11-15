<?php

namespace BasicApp\User\Controllers;

use Exception;
use CodeIgniter\Exceptions\PageNotFoundException;
use BasicApp\User\Forms\LoginForm;
use BasicApp\User\Forms\SignupForm;
use BasicApp\User\Forms\PasswordResetRequestForm;
use BasicApp\User\Forms\ResendVerificationEmailForm;
use BasicApp\User\Forms\ResetPasswordForm;
use BasicApp\User\Forms\UserModel;

class User extends \BasicApp\User\UserController
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
                $this->session->setFlashdata(
                    'success', 
                    'Thank you for registration. Please check your inbox for verification email.'
                );
            
                return $this->goHome();
            }
            else
            {
                $errors[] = $error;
            }
        }

        return $this->render('user/signup', [
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
        if (!$this->user->isGuest())
        {
            return $this->goHome();
        }

        $model = new LoginForm;

        $data = $this->request->getPost();

        $errors = [];
        
        if ($data && $model->validate($data))
        {
            $rememberMe = array_key_exists('rememberMe', $data) ? $data['rememberMe'] : 0;

            $user = $model->getUser();

            if ($this->user->login($user, $rememberMe, $error))
            {
                return $this->goHome();
            }
            else
            {
                $errors[] = $error;
            }
        }

        if (!$data)
        {
            $data['rememberMe'] = 1;
        }

        return $this->render('user/login', [
            'model' => $model,
            'errors' => array_merge((array) $model->errors(), $errors),
            'data' => $data
        ]);        
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function logout()
    {
        $this->user->logout();

        return $this->goHome();
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return mixed
     */
    public function verifyEmail($id, $token)
    {
        $user = UserModel::findByPrimaryKey($id);

        if (!$user)
        {
            throw new PageNotFoundException;
        }

        if (!UserModel::setUserVerification($user, $token, $error))
        {
            throw new Exception($error);
        }

        $this->session->setFlashdata('success', 'Your email has been confirmed!');

        return $this->redirect(site_url('user/login'));
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
                $this->session->setFlashdata('success', 'Check your email for further instructions.');
            
                return $this->goHome();
            }
            else
            {
                $errors[] = $error;
            }
        }

        return $this->render('user/resendVerificationEmail', [
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

        $data = $this->request->getPost();

        $errors = [];
        
        if ($data && $model->validate($data))
        {
            if ($model->sendEmail($error))
            {
                $this->session->setFlashdata('success', 'Check your email for further instructions.');

                return $this->goHome();
            }
            else
            {
                //'Sorry, we are unable to reset password for the provided email address.'

                $errors[] = $error; 
            }
        }

        return $this->render('user/requestPasswordReset', [
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
        $user = UserModel::findByPrimaryKey($id);

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
                $this->session->setFlashdata('success', 'New password saved.');

                return $this->redirect(site_url('user/login'));
            }
            else
            {
                $errors[] = $error;
            }
        }

        return $this->render('user/resetPassword', [
            'model' => $model,
            'data' => $data,
            'errors' => array_merge((array) $model->errors(), $errors),
            'id' => $id,
            'token' => $token
        ]);
    }

}