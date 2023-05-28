<?php

namespace App\Controllers;
use App\Models\Main_Model;

class Main extends BaseController
{
    public $session;

    public function __construct()
    {
        $this->session = session();
    }

    public function index()
    {
        # VERIFY SESSION
        if(empty($this->session->get('id')))
        {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }
            
        $role = $this->session->get('role');

        if($role == 1) // Admin
        {
            $data = array();
            $data['page'] = 'main/c_panel';

            return view('main/index', $data);
        }
    }

    public function listEmployee()
    {
        # VERIFY SESSION
        if(empty($this->session->get('id')))
        {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $role = $this->session->get('role');

        if($role == 1) // Admin
        {
            $data = array();
            $data['page'] = 'main/list_employee';

            return view('main/index', $data);
        }
    }

    public function processingEmployee()
    {
        $dataTableRequest = $_REQUEST;

        $params = array();
        $params['draw'] = $dataTableRequest['draw'];
        $params['start'] = $dataTableRequest['start'];
        $params['length'] = $dataTableRequest['length'];
        $params['search'] = $dataTableRequest['search']['value'];
        $params['sortColumn'] = $dataTableRequest['order'][0]['column'];
        $params['sortDir'] = $dataTableRequest['order'][0]['dir'];

        $row = array();
        $totalRecords = 0;

        $objModel = new Main_Model;
        $result = $objModel->getUserProcessingData($params); 
        $totalRows = sizeof($result );

        for($i = 0; $i < $totalRows; $i++) 
        { 
            $col = array();
            $col['name'] = $result[$i]->name;
            $col['lastName'] = $result[$i]->last_name;
            $col['email'] = $result[$i]->email;
            $col['status'] = $result[$i]->status;
            $col['action'] = '';

            $row[$i] =  $col;
        }

        if($totalRows > 0)
            $totalRecords = $objModel->getTotalUser();

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $data['data'] = $row;

        return json_encode($data);
    }

    public function showModalEmployee()
    {
        # VERIFY SESSION
        if(empty($this->session->get('id')))
        {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $data = array();
        $data['action'] = $this->request->getPost('action');

        if($data['action'] == 'create')
        {
            $data['title'] = 'Nuevo Empleado';
        }

        return view('modals/employee', $data);
    }

    public function createEmployee()
    {
        $response = array();

        # VERIFY SESSION
        if(empty($this->session->get('id')))
        {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $data = array();
        $data['name'] = trim(preg_replace("/[^A-Za-z0-9 ]/", "", $this->request->getPost('name')));
        $data['last_name'] = trim(preg_replace("/[^A-Za-z0-9 ]/", "", $this->request->getPost('lastName')));
        $data['email'] = trim($this->request->getPost('email'));
        $data['role'] = (int) $this->request->getPost('role');
        
        $objModel = new Main_Model;
        $resultCheckEmailExist = $objModel->checkEmailExist($data['email']);

        if(empty($resultCheckEmailExist))
        {
            $result = $objModel->createUser($data);

            if($result['error'] == 0)
            {
                $response['error'] = 0;
                $response['msg'] = 'Empleado creado';
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = 'Ha ocurrido un error en el proceso';
            }
        }
        else
        {
            $response['error'] = 3;
            $response['msg'] = 'Ya existe un empleado con el email introducido';

        }

        return json_encode($response);
    }

    public function product()
    {
        # VERIFY SESSION
        if(empty($this->session->get('id')))
        {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $role = $this->session->get('role');

        if($role == 1) // Admin
        {
            $data = array();
            $data['page'] = 'main/product';

            return view('main/index', $data);
        }
    }

    public function tpv()
    {
        # VERIFY SESSION
        if(empty($this->session->get('id')))
        {
            $data = array();
            $data['page'] = 'dashboard/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('dashboard/index', $data);
        }

        $role = $this->session->get('role');

        if($role == 1) // Admin
        {
            $data = array();
            $data['page'] = 'dashboard/tpv';

            return view('dashboard/index', $data);
        }
    }
}