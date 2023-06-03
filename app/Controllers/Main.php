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
        if (empty($this->session->get('id'))) {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $objModel = new Main_Model;

        if ($this->session->get('role') == 1) // ADMIN
        {
            $data = array();
            $data['page'] = 'main/cPanel';
            $data['totalDayProduction'] = $objModel->getTotalDayProduction();

            return view('main/index', $data);
        }
        elseif($this->session->get('role') == 2) // EMPLOYEE
        {
            $userID = (int) $this->session->get('id');
            
            $employee = $objModel->getUserData($userID);

            $data = array();
            $data['employee'] = $employee;
            $data['page'] = 'main/employeeDetail';

            return view('main/index', $data);
        }
    }

    # EMPLOYEE
    public function listEmployee()
    {
        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $role = $this->session->get('role');

        if ($role == 1) // Admin
        {
            $data = array();
            $data['page'] = 'main/listEmployee';
            $data['userLoggedId'] = $this->session->get('id');
            $data['userLoggedRole'] = $this->session->get('role');

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
        $totalRows = sizeof($result);

        for ($i = 0; $i < $totalRows; $i++) {
            $status = '';
            $switch = '';

            if ($result[$i]->status == 1) {
                $status = '<span class="badge badge-soft-success">Activo</span>';
                $switch = '<div style="margin-left: 44px;" class="form-check form-switch form-switch-md mb-2">
                                                <input data-id="' . $result[$i]->id . '" data-status="' . $result[$i]->status . '" data-role="' . $result[$i]->role . '"class="form-check-input switch" type="checkbox" id="flexSwitchCheckChecked" checked />
                                            </div>';
            } else {
                $status = '<span class="badge badge-soft-danger">Inactivo</span>';
                $switch = '<div style="margin-left: 44px;" class="form-check form-switch form-switch-md mb-2">
                                                <input data-id="' . $result[$i]->id . '" data-status="' . $result[$i]->status . '" data-role="' . $result[$i]->role . '"class="form-check-input switch" type="checkbox" id="flexSwitchCheckChecked" />
                                            </div>';
            }

            $role = '';

            if ($result[$i]->role == 1) {
                $role = '<span class="badge badge-soft-primary">Administrador</span>';
            } else {
                $role = '<span class="badge badge-soft-secondary">Empleado</span>';
            }

            $clave = '';

            if (empty($result[$i]->clave)) {
                $clave = '<button class="ms-1 me-1 btn btn-sm btn-primary btn-actions-clave" data-id="' . $result[$i]->id . '" data-action="set_clave"><span class="mdi mdi-key" title="Crear Clave"></span></button>';
            } else {
                $clave = '<button class="ms-1 me-1 btn btn-sm btn-primary btn-actions-clave" data-id="' . $result[$i]->id . '" data-action="update_clave"><span class="mdi mdi-key-minus" title="Cambiar Clave"></span></button>';
            }

            $btn_edit = '<button class="ms-1 me-1 btn btn-sm btn-warning btn-edit-employee" data-id="' . $result[$i]->id . '"><span class="mdi mdi-account-edit-outline" title="Editar Empleado"></span></button>';
            $btn_delete = '<button class="ms-1 me-1 btn btn-sm btn-danger btn-delete-employee" data-id="' . $result[$i]->id . '"><span class="mdi mdi-trash-can-outline" title="Eliminar Empleado"></span></button>';

            $col = array();
            $col['name'] = '<a href="' . base_url('Main/employee') . '/' . $result[$i]->id . '">' . $result[$i]->name . '</a>';
            $col['lastName'] = $result[$i]->lastName;
            $col['email'] = $result[$i]->email;
            $col['role'] = $role;
            $col['status'] = $status;
            $col['switch'] = $switch;
            $col['action'] = $clave . $btn_edit . $btn_delete;

            $row[$i] =  $col;
        }

        if ($totalRows > 0)
            $totalRecords = $objModel->getTotalUser();

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $data['data'] = $row;

        return json_encode($data);
    }

    public function employee()
    {
        # VERIFY SESSION
        if (empty($this->session->get('id'))) {

            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $userLoggedID = (int) $this->session->get('id');
        $userID = (int) $this->request->uri->getSegment(3);

        if ($userLoggedID != $userID) {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $objModel = new Main_Model;
        $employee = $objModel->getUserData($userID);

        $data = array();
        $data['employee'] = $employee;
        $data['page'] = 'main/employeeDetail';

        return view('main/index', $data);
    }

    public function changeUserStatus()
    {
        $response = array();

        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $data = array();
        $data['status'] = $this->request->getPost('status');

        $objModel = new Main_Model;
        $result = $objModel->updateUser($data, $this->request->getPost('userID'));

        if ($result['error'] == 0) {
            $msg = '';

            if ($data['status'] == 0)
                $msg = 'Usuario Desactivado';
            elseif ($data['status'] == 1)
                $msg = 'Usuario Activado';

            $response['error'] = 0;
            $response['msg'] = $msg;
        } else {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

        return json_encode($response);
    }

    public function setClave()
    {
        $response = array();

        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $data = array();
        $data['clave'] = md5($this->request->getPost('clave'));

        $objModel = new Main_Model;
        $result = $objModel->updateUser($data, $this->request->getPost('userID'));

        if ($result['error'] == 0) {
            $response['error'] = 0;
            $response['msg'] = 'Proceso realizado con éxito';
        } else {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

        return json_encode($response);
    }

    public function showModalEmployee()
    {
        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $data = array();
        $data['action'] = $this->request->getPost('action');

        if ($data['action'] == 'create') {
            $data['title'] = 'Nuevo Empleado';
        } elseif ($data['action'] == 'update') {
            $objModel = new Main_Model;
            $result = $objModel->getUserData($this->request->getPost('userID'));
            $data['title'] = 'Actualizando ' . $result[0]->name . ' ' . $result[0]->lastName;
            $data['user_data'] = $result;
        }

        return view('modals/employee', $data);
    }

    public function showModalSetClave()
    {
        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
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


        if ($data['action'] == 'set_clave')
            $data['title'] = 'Creando Contraseña para ' . $userData[0]->name . ' ' . $userData[0]->lastName;
        else
            $data['title'] = 'Actualizando Contraseña de ' . $userData[0]->name . ' ' . $userData[0]->lastName;

        return view('modals/setClave', $data);
    }

    public function createEmployee()
    {
        $response = array();

        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $data = array();
        $data['name'] = trim($this->request->getPost('name'));
        $data['lastName'] = trim($this->request->getPost('lastName'));
        $data['email'] = trim($this->request->getPost('email'));
        $data['role'] = (int) $this->request->getPost('role');

        $objModel = new Main_Model;
        $resultCheckEmailExist = $objModel->checkEmailExist($data['email']);

        if (empty($resultCheckEmailExist)) {
            $result = $objModel->createUser($data);

            if ($result['error'] == 0) {
                $response['error'] = 0;
                $response['msg'] = 'Empleado creado';
            } else {
                $response['error'] = 1;
                $response['msg'] = 'Ha ocurrido un error en el proceso';
            }
        } else {
            $response['error'] = 3;
            $response['msg'] = 'Ya existe un empleado con el email introducido';
        }

        return json_encode($response);
    }

    public function deleteEmployee()
    {
        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $id = $this->request->getPost('userID');

        $objModel = new Main_Model;
        $result = $objModel->deleteUser($id);

        if ($result == true) {
            $response['error'] = 0;
            $response['msg'] = 'Empleado Eliminado';
        } else {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

        return json_encode($response);
    }

    public function updateEmployee()
    {
        $response = array();

        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $email = $this->request->getPost('email');
        $id = $this->request->getPost('userID');

        $objModel = new Main_Model;
        $result_checkEmailExist = $objModel->checkEmailExist($email, $id);

        if (empty($result_checkEmailExist)) {
            $data = array();
            $data['email'] = $email;
            $data['name'] = $this->request->getPost('name');
            $data['lastName'] = $this->request->getPost('lastName');
            $data['role'] = $this->request->getPost('role');

            $result_update = $objModel->updateUser($data, $id);

            if ($result_update['error'] == 0) {
                $response['error'] = 0;
                $response['msg'] = 'Empleado Actualizado';
            } else {
                $response['error'] = 1;
                $response['msg'] = 'Ha ocurrido un error en el proceso';
            }
        } else {
            $response['error'] = 1;
            $response['msg'] = 'Ya existe un empleado con el email introducido';
        }

        return json_encode($response);
    }

    # PRODUCT

    public function listProduct()
    {
        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $data = array();
        $data['page'] = 'main/listProducts';

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
        $totalRows = sizeof($result);

        for ($i = 0; $i < $totalRows; $i++) {
            $btn_editProduct = '<button class="ms-1 me-1 btn btn-sm btn-warning btn-editProduct" data-id="' . $result[$i]->id . '" href="#"><span class="mdi mdi-pencil" title="Editar Producto"></span></button>';
            $btn_deleteProduct = '<button class="ms-1 me-1 btn btn-sm btn-danger btn-delete-product" data-id="' . $result[$i]->id . '" href="#"><span class="mdi mdi-delete" title="Eliminar Producto"></span></button>';

            $col = array();
            $col['name'] = $result[$i]->name;
            $col['cost'] = '€ ' . number_format((float) $result[$i]->cost, 2, ".", ',');
            $col['action'] = $btn_editProduct . $btn_deleteProduct;

            $row[$i] =  $col;
        }

        if ($totalRows > 0)
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
        if (empty($this->session->get('id'))) {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $data = array();
        $data['action'] = $this->request->getPost('action');

        if ($data['action'] == 'create') {
            $data['title'] = 'Nuevo Producto';
        } else if ($data['action'] == 'update') {
            $data['title'] = 'Actualizar Producto';

            $objModel = new Main_Model;
            $result = $objModel->getProductData($this->request->getPost('userID'));
            $data['title'] = 'Actualizar ' . $result[0]->name;
            $data['user_data'] = $result;
        }

        return view('modals/products', $data);
    }

    public function createProducts()
    {
        $response = array();

        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $data = array();
        $data['name'] = trim($this->request->getPost('name'));
        $data['cost'] = trim($this->request->getPost('cost'));

        $objModel = new Main_Model;

        $resultCheckProductExist = $objModel->checkProductExist($data['name']);

        if (empty($resultCheckProductExist)) {
            $result = $objModel->createProducts($data);

            if ($result['error'] == 0) {
                $response['error'] = 0;
                $response['msg'] = 'Producto creado';
            } else {
                $response['error'] = 1;
                $response['msg'] = 'Ha ocurrido un error en el proceso';
            }
        } else {
            $response['error'] = 3;
            $response['msg'] = 'Ya existe un producto con el mismo nombre';
        }

        return json_encode($response);
    }

    public function updateProduct()
    {
        $response = array();

        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $name = $this->request->getPost('name');
        $id = $this->request->getPost('userID');

        $objModel = new Main_Model;
        $result_checkProductExist = $objModel->checkProductExist($name, $id);

        if (empty($result_checkProductExist)) {
            $data = array();
            $data['id'] = $id;
            $data['name'] = $this->request->getPost('name');
            $data['cost'] = $this->request->getPost('cost');

            $result_update = $objModel->updateProduct($data, $id);

            if ($result_update['error'] == 0) {
                $response['error'] = 0;
                $response['msg'] = 'Producto Actualizado';
            } else {
                $response['error'] = 1;
                $response['msg'] = 'Ha ocurrido un error en el proceso';
            }
        } else {
            $response['error'] = 1;
            $response['msg'] = 'Ya existe un Producto con el mismo nombre';
        }

        return json_encode($response);
    }

    public function deleteProduct()
    {
        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $response['error'] = 2;
            $response['msg'] = 'Sessión Expirada';

            return json_encode($response);
        }

        $id = $this->request->getPost('userID');

        $objModel = new Main_Model;
        $result = $objModel->deleteProduct($id);

        if ($result == true) {
            $response['error'] = 0;
            $response['msg'] = 'Producto Eliminado';
        } else {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

        return json_encode($response);
    }

    # TPV

    public function tpv()
    {
        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $data_basket = array();
        $data_basket['userID'] = $this->session->get('id');

        $objModel = new Main_Model;
        $result_create_basket = $objModel->createBasket($data_basket);

        if ($result_create_basket['error'] == 0) {
            $data = array();
            $data['basketID'] = $result_create_basket['id'];
            $data['userRole'] = $this->session->get('role');
            $data['page'] = 'main/tpv';
        }

        return view('main/index', $data);
    }

    public function returnBasket()
    {
        $objModel = new Main_Model;
        $basketID = $this->request->getPost('basketID');

        $data['basketView'] = $objModel->getBasketView($basketID);
        $data['countBasketView'] = sizeof($data['basketView']);

        return view('main/tpvBasket', $data);
    }

    public function returnProducts()
    {
        $objModel = new Main_Model;

        $data = array();
        $data['products'] = $objModel->getProducts();
        $data['count_products'] = sizeof($data['products']);

        return view('main/tpvProducts', $data);
    }

    public function createBasketProduct()
    {
        $objModel = new Main_Model;

        $data = array();
        $data['basketID'] = $this->request->getPost('basketID');
        $data['productID'] = $this->request->getPost('productID');

        $result_create_barberTPV = $objModel->createBasketProduct($data);

        if ($result_create_barberTPV['error'] == 0) {
            $response['error'] = 0;
            $response['msg'] = 'Producto Añadido a la Lista';
        } else {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

        return json_encode($response);
    }

    public function deleteBasketProduct()
    {
        $response = array();

        $objModel = new Main_Model;
        $result = $objModel->deleteBasketProduct($this->request->getPost('id'));

        if ($result == true) {
            $response['error'] = 0;
            $response['msg'] = 'Producto Eliminado de la Lista';
        } else {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

        return json_encode($response);
    }

    public function showModalSelectPayMethod()
    {
        # VERIFY SESSION
        if (empty($this->session->get('id'))) {
            $data = array();
            $data['page'] = 'main/logout';
            $data['msg'] = 'Sessión Expirada';

            return view('main/index', $data);
        }

        $data = array();
        $data['basketID'] = $this->request->getPost('basketID');
        $data['total'] = $this->request->getPost('total');
        $data['title'] = 'Seleccione un método de pago';
        $data['action'] = $this->request->getPost('action');
        $data['userID'] = $this->session->get('id');

        return view('modals/selectPaymentMethod', $data);
    }

    public function updateBasket()
    {
        $basketID = $this->request->getPost('basketID');

        $data = array();
        $data['total'] = $this->request->getPost('total');
        $data['status'] = 2;
        $data['payType'] = $this->request->getPost('payType');

        $objModel = new Main_Model;
        $resultUpdateBasket = $objModel->updateBasket($data, $basketID);

        if ($resultUpdateBasket['error'] == 0) {
            $response['error'] = 0;
            $response['msg'] = 'Ticket Creado';
        } else {
            $response['error'] = 1;
            $response['msg'] = 'Ha ocurrido un error en el proceso';
        }

        return json_encode($response);
    }

    public function processingBasketDT()
    {
        $userID = '';

        $dataTableRequest = $_REQUEST;


        if(!empty($this->request->getPost('userID')))
            $userID = $this->request->getPost('userID');

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
        $result = $objModel->getBasketDTProcessingData($params, $userID);
        $totalRows = sizeof($result);

        for ($i = 0; $i < $totalRows; $i++) {

            $col = array();
            $col['date'] = $result[$i]->formattedDate;
            $col['ticketID'] = $result[$i]->basketID;
            $col['userName'] = $result[$i]->userName;
            $col['userlastName'] = $result[$i]->userLastName;
            $col['paymentType'] = $result[$i]->paymentMethod;
            $col['Total'] = '€ ' . number_format((float) $result[$i]->total, 2, ".", ',');
     
            $row[$i] =  $col;
        }

        if ($totalRows > 0)
            $totalRecords = $objModel->getTotalBasketDT();

        $data = array();
        $data['draw'] = $dataTableRequest['draw'];
        $data['recordsTotal'] = intval($totalRecords);
        $data['recordsFiltered'] = intval($totalRecords);
        $data['data'] = $row;

        return json_encode($data);
    }
}
