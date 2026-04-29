<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProfileController extends BaseController
{
    public function index()
    {   
        $session = session();
        $data = [
            'username' => $session -> username,
            'email' =>  $session -> email,
            'role' => $session -> role,
            'logintime' => $session -> logintime,
            'isLoggedIn' => $session -> isLoggedIn

        ];
        
        return view("v_profile",$data);
    }

}
