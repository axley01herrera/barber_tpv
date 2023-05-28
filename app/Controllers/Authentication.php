<?php

namespace App\Controllers;
use App\Models\Main_Model;

class Authentication extends BaseController
{
    public $session;

    public function __construct()
    {
        $this->session = session();
        
        $this->session->set('id', '');
        $this->session->set('email', '');
        $this->session->set('role', '');
    }

    public function index() 
    {
        return view('auth/index');
    }

    public function login()
    {
        $response = array();
        
        $email = $this->request->getPost('email');
        $clave = $this->request->getPost('clave');

        if(!empty($email && !empty($clave)))
        {
            $objModel = new Main_Model;
            $result = $objModel->verifyCredentials($email, $clave);

            if(!empty($result))
            {
                if($result[0]->status == 1)
                {
                    $this->session->set('id', $result[0]->id);
                    $this->session->set('email', $result[0]->email);
                    $this->session->set('role', $result[0]->role);

                    $response['error'] = 0;
                    $response['msg'] = 'Iniciando Sessión';
                }
                else
                {
                    $response['error'] = 1;
                    $response['msg'] = 'Su acceso al sistema está desabiliado';
                }
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = 'Rectifique sus credenciales';
            }
        }
        else
        {
            $response['error'] = 1;
            $response['msg'] = 'Violación de Campos Requeridos';
        }

        return json_encode($response);
    }
}
