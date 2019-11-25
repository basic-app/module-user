<?php

namespace BasicApp\User;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\Services;
use Exception;

abstract class BaseMemberController extends \BasicApp\System\Controller
{

    protected $user;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------

        $this->user = Services::user()->getUser();

        if (!$this->user)
        {
            throw new Exception('Access denied.');
        }
    }

}