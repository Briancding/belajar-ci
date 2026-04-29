<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    public function index()
    {   
        $data = [
            'username' => session()->get('username'),
            'email' => session()->get('email'),
            'role' => session()->get('role'),
            'loginTime' => date('d M Y H:i:s', session()->get('logintime'))
        ];

        return view('v_profile', $data);
    }

}
