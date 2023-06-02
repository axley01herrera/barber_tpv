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

    # EMPLOYEE
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
            $data['user_logged_id'] = $this->session->get('id');
            $data['user_logged_role'] = $this->session->get('role');

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
            $status = '';
            $switch_active_inactive = '';

            if($result[$i]->status == 1)
            {
                $status = '<span class="badge badge-soft-success">Activo</span>';
                $aux = '<input type="checkbox" id="switch1" switch="none" checked="">
                <label for="switch1" data-on-label="On" data-off-label="Off" class="mb-0"></label>';
                $switch_active_inactive = '<div style="margin-left: 44px;" class="form-check form-switch form-switch-md mb-2">
                                                <input data-id="' . $result[$i]->id . '" data-status="' . $result[$i]->status . '" data-role="' . $result[$i]->role . '"class="form-check-input switch_active_inactive" type="checkbox" id="flexSwitchCheckChecked" checked />
                                            </div>';
            }
            else
            {
                $status = '<span class="badge badge-soft-danger">Inactivo</span>';
                $switch_active_inactive = '<div style="margin-left: 44px;" class="form-check form-switch form-switch-md mb-2">
                                                <input data-id="' . $result[$i]->id . '" data-status="' . $result[$i]->status . '" data-role="' . $result[$i]->role . '"class="form-check-input switch_active_inactive" type="checkbox" id="flexSwitchCheckChecked" />
                                            </div>';
            }

            $role = '';

            if($result[$i]->role == 1)
            {
                $role = '<span class="badge badge-soft-primary">Administrador</span>';
            }
            else
            {   
                $role = '<span class="badge badge-soft-secondary">Básico</span>';
            }

            $clave = '';

            if(empty($result[$i]->clave))
            {
                $clave = '<a class="btn-actions-clave" data-id="' . $result[$i]->id . '" data-action="set_clave" href="#"><span class="mdi mdi-key" title="Crear Clave"></span></a>';
            }
            else
            {
                $clave = '<a class="btn-actions-clave" data-id="' . $result[$i]->id . '" data-action="update_clave" href="#"><span class="mdi mdi-key-minus" title="Cambiar Clave"></span></a>';
            }

            $btn_edit = '<a class="btn-edit-employee" data-id="' . $result[$i]->id . '" href="#"><span class="mdi mdi-account-edit-outline" title="Actualizar Empleado"></span></a>';

            $btn_delete = '<a class="btn-delete-employee" data-id="' . $result[$i]->id . '" href="#"><span class="mdi mdi-delete" title="Eliminar Empleado"></span></a>';


            $col = array();
            $col['name'] = $result[$i]->name;
            $col['lastName'] = $result[$i]->last_name;
            $col['email'] = $result[$i]->email;
            $col['password'] = $result[$i]->clave; 
            $col['role'] = $role;
            $col['status'] = $status;
            $col['actionStatus'] = $switch_active_inactive;
            $col['actionClave'] = $clave;
            $col['btnEdit'] = $btn_edit;
            $col['btnDelete'] = $btn_delete;

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

    public function changeUserStatus()
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
        $data['status'] = $this->request->getPost('status');

        $objModel = new Main_Model;
        $result = $objModel->updateUser($data, $this->request->getPost('userID'));

        if($result['error'] == 0)
        {
            $msg = '';

            if($data['status'] == 0)
                $msg = 'Usuario Desactivado';
            elseif($data['status'] == 1)
                $msg = 'Usuario Activado';

            $response['error'] = 0;
            $response['msg'] = $msg;
        }
        else
        {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

        return json_encode($response);
    }

    public function setClave()
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
        $data['clave'] = md5($this->request->getPost('clave'));

        $objModel = new Main_Model;
        $result = $objModel->updateUser($data, $this->request->getPost('userID'));

        if($result['error'] == 0)
        {
            $response['error'] = 0;
            $response['msg'] = 'Proceso realizado con éxito';
        }
        else
        {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

        return json_encode($response);
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
        elseif($data['action'] == 'update')
        {
            $objModel = new Main_Model;
            $result = $objModel->getUserData($this->request->getPost('userID'));
            $data['title'] = 'Actualizando  a '.$result[0]->name.' '.$result[0]->last_name;
            $data['user_data'] = $result;
        }

        return view('modals/employee', $data);
    }

    public function showModalSetClave()
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
        $data['userID'] = $this->request->getPost('userID');
        $data['action'] = $this->request->getPost('action');

        $objModel = new Main_Model;
        $userData = $objModel->getUserData($data['userID']); 
        

        if($data['action'] == 'set_clave')
            $data['title'] = 'Creando Contraseña para '.$userData[0]->name.' '.$userData[0]->last_name;
        else
            $data['title'] = 'Actualizando Contraseña de '.$userData[0]->name.' '.$userData[0]->last_name;

        return view('modals/setClave', $data);
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
        $data['clave'] = md5( $this->request->getPost('password'));
        
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

    public function updateEmployee()
    {
        $response = array();

        # VERIFY SESSION
        if(empty($this->session->get('id')))
        {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $email = $this->request->getPost('email');
        $id = $this->request->getPost('userID');

        $objModel = new Main_Model;
        $result_checkEmailExist = $objModel->checkEmailExist($email, $id);

        if(empty($result_checkEmailExist))
        {
            $data = array();
            $data['email'] = $email;
            $data['name'] = $this->request->getPost('name');
            $data['last_name'] = $this->request->getPost('lastName');
            $data['role'] = $this->request->getPost('role');

            $result_update = $objModel->updateUser($data, $id);

            if($result_update['error'] == 0)
            {
                $response['error'] = 0;
                $response['msg'] = 'Empleado Actualizado';
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = 'Ha ocurrido un error en el proceso';
            }

        }
        else
        {
            $response['error'] = 1;
            $response['msg'] = 'Ya existe un empleado con el email introducido';
        }

        return json_encode($response);
    }

    public function deleteEmployee()
    {
        # VERIFY SESSION
        if(empty($this->session->get('id')))
        {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $id = $this->request->getPost('userID');

        $objModel = new Main_Model;
        $result = $objModel->deleteUser($id);

        if($result == true)
        {
            $response['error'] = 0;
            $response['msg'] = 'Empleado Eliminado';
        }
        else
        {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

            return json_encode($response);

        }


    # PRODUCT

    public function listProduct()
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
        $data['page'] = 'main/list_products';

        return view('main/index', $data);
    }

    public function processingProducts()
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
        $result = $objModel->getProductsProcessingData($params); 
        $totalRows = sizeof($result );

        for($i = 0; $i < $totalRows; $i++) 
        { 

            $btn_editProduct = '<a class="btn-editProduct" data-id="' . $result[$i]->id . '" href="#"><span class="mdi mdi-pencil" title="Actualizar Producto"></span></a>';

            $btn_deleteProduct = '<a class="btn-delete-product" data-id="' . $result[$i]->id . '" href="#"><span class="mdi mdi-delete" title="Eliminar Producto"></span></a>';


            $col = array();
            $col['name'] = $result[$i]->name;
            $col['cost'] = '€ '.number_format((float) $result[$i]->cost, 2,".",',');
            $col['actionedit'] = $btn_editProduct;
            $col['actiondelete'] = $btn_deleteProduct;

            $row[$i] =  $col;
        }

        if($totalRows > 0)
            $totalRecords = $objModel->getTotalProducts();

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $data['data'] = $row;

        return json_encode($data);
    }

    public function showModalProducts()
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
            $data['title'] = 'Nuevo Producto';
        }
        else if($data['action'] == 'update')
        {
            $data['title'] = 'Actualizar Producto';

            $objModel = new Main_Model;
            $result = $objModel->getProductData($this->request->getPost('userID'));
            $data['title'] = 'Actualizar '.$result[0]->name;
            $data['user_data'] = $result;
        }

        return view('modals/products', $data);
    }

    public function updateProduct()
    {
        $response = array();

        # VERIFY SESSION
        if(empty($this->session->get('id')))
        {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $name = $this->request->getPost('name');
        $id = $this->request->getPost('userID');

        $objModel = new Main_Model;
        $result_checkProductExist = $objModel->checkProductExist($name, $id);

        if(empty($result_checkProductExist))
        {
            $data = array();
            $data['id'] = $id;
            $data['name'] = $this->request->getPost('name');
            $data['cost'] = $this->request->getPost('cost');

            $result_update = $objModel->updateProduct($data, $id);

            if($result_update['error'] == 0)
            {
                $response['error'] = 0;
                $response['msg'] = 'Producto Actualizado';
            }
            else
            {
                $response['error'] = 1;
                $response['msg'] = 'Ha ocurrido un error en el proceso';
            }

        }
        else
        {
            $response['error'] = 1;
            $response['msg'] = 'Ya existe un Producto con el mismo nombre';
        }

        return json_encode($response);
    }

    public function createProducts()
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
        $data['cost'] = trim($this->request->getPost('cost'));

        $objModel = new Main_Model;

        $resultCheckProductExist = $objModel->checkProductExist($data['name']);

        if(empty($resultCheckProductExist))
        {
            $result = $objModel->createProducts($data);

            if($result['error'] == 0)
            {
                $response['error'] = 0;
                $response['msg'] = 'Producto creado';
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
            $response['msg'] = 'Ya existe un producto con el mismo nombre';

        }

        return json_encode($response);
    }

    public function deleteProduct()
    {
        # VERIFY SESSION
        if(empty($this->session->get('id')))
        {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $id = $this->request->getPost('userID');

        $objModel = new Main_Model;
        $result = $objModel->deleteProduct($id);

        if($result == true)
        {
            $response['error'] = 0;
            $response['msg'] = 'Producto Eliminado';
        }
        else
        {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

            return json_encode($response);

        }

    # TPV

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