<?php

namespace App\Models;

use CodeIgniter\CLI\Console;
use CodeIgniter\Model;
use CodeIgniter\Database\MySQLi\Builder;

class Main_Model extends Model
{
    protected $db;

    function  __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function verifyCredentials($email, $clave)
    {
        $query = $this->db->table('user')
            ->where('email', $email)
            ->where('clave', $clave);

        return $query->get()->getResult();
    }

    public function checkEmailExist($email, $id = '')
    {
        $query = $this->db->table('user')
            ->where('email', $email);

        if (!empty($id)) {
            $IDs = array();
            $IDs[0] = $id;
            $query->whereNotIn('id', $IDs);
        }

        return $query->get()->getResult();
    }

    public function getTotalUser()
    {
        $query = $this->db->table('user')
            ->selectCount('id')
            ->get()->getResult();

        return $query[0]->id;
    }

    public function getUserProcessingData($params)
    {
        $query = $this->db->table('user');

        if (!empty($params['search'])) {
            $query->like('name', $params['search']);
            $query->orLike('lastName', $params['search']);
            $query->orLike('email', $params['search']);
        }

        $query->offset($params['start']);
        $query->limit($params['length']);
        $query->orderBy($this->getUserProcessingSort($params['sortColumn'], $params['sortDir']));

        return $query->get()->getResult();
    }

    public function getUserProcessingSort($column, $dir)
    {
        $sort = '';

        if ($column == 0) {
            if ($dir == 'asc')
                $sort = 'name ASC';
            else
                $sort = 'name DESC';
        }

        if ($column == 1) {
            if ($dir == 'asc')
                $sort = 'lastName ASC';
            else
                $sort = 'lastName DESC';
        }

        if ($column == 2) {
            if ($dir == 'asc')
                $sort = 'email ASC';
            else
                $sort = 'email DESC';
        }

        if ($column == 3) {
            if ($dir == 'asc')
                $sort = 'status ASC';
            else
                $sort = 'status DESC';
        }

        return $sort;
    }

    public function createUser($data)
    {
        $return = array();

        $query = $this->db->table('user')
            ->insert($data);

        if ($query->resultID == true) {
            $return['error'] = 0;
            $return['id'] = $query->connID->insert_id;
        } else
            $return['error'] = 1;

        return $return;
    }

    public function updateUser($data, $id)
    {
        $return = array();

        $query = $this->db->table('user')
            ->where('id', $id)->update($data);

        if ($query == true) {
            $return['error'] = 0;
            $return['id'] = $id;
        } else {
            $return['error'] = 1;
            $return['id'] = $id;
        }

        return $return;
    }

    public function getUserData($id)
    {
        $query = $this->db->table('user')
            ->where('id', $id);

        return $query->get()->getResult();
    }

    public function deleteUser($id)
    {
        $query = $this->db->table('user')
            ->where('id', $id)
            ->delete();

        return $query->resultID;
    }

    public function createProducts($data)
    {
        $return = array();

        $query = $this->db->table('product')
            ->insert($data);

        if ($query->resultID == true) {
            $return['error'] = 0;
            $return['id'] = $query->connID->insert_id;
        } else
            $return['error'] = 1;

        return $return;
    }

    public function checkProductExist($name, $id = '')
    {
        $query = $this->db->table('product')
            ->where('name', $name);

        if (!empty($id)) {
            $IDs = array();
            $IDs[0] = $id;
            $query->whereNotIn('id', $IDs);
        }

        return $query->get()->getResult();
    }

    public function getProductsProcessingData($params)
    {
        $query = $this->db->table('product');

        if (!empty($params['search'])) {
            $query->like('name', $params['search']);
            $query->orLike('cost', $params['search']);
        }

        $query->offset($params['start']);
        $query->limit($params['length']);
        $query->orderBy($this->getProductsProcessingSort($params['sortColumn'], $params['sortDir']));

        return $query->get()->getResult();
    }

    public function getProductsProcessingSort($column, $dir)
    {
        $sort = '';

        if ($column == 0) {
            if ($dir == 'asc')
                $sort = 'name ASC';
            else
                $sort = 'name DESC';
        }

        if ($column == 1) {
            if ($dir == 'asc')
                $sort = 'cost ASC';
            else
                $sort = 'cost DESC';
        }

        return $sort;
    }

    public function getTotalProducts()
    {
        $query = $this->db->table('product')
            ->selectCount('id')
            ->get()->getResult();

        return $query[0]->id;
    }

    public function getProducts()
    {
        $query = $this->db->table('product')
            ->select('*');

        return $query->get()->getResult();
    }

    public function getProductData($id)
    {
        $query = $this->db->table('product')
        ->where('id', $id);

        return $query->get()->getResult();
    }

    public function updateProduct($data, $id)
    {
        $return = array();

        $query = $this->db->table('product')
        ->where('id', $id)->update($data); 

        if($query == true)
        {
            $return['error'] = 0;
            $return['id'] = $id;
        }
        else
        {
            $return['error'] = 1;
            $return['id'] = $id;
        }

        return $return;
    }

    public function deleteProduct($id)
    {
        $query = $this->db->table('product')
        ->where('id', $id)
        ->delete(); 

        return $query->resultID;
    }

    public function createBasket($data)
    {
        $query = $this->db->table('basket')
            ->insert($data);

        if ($query->resultID == true) {
            $return['error'] = 0;
            $return['id'] = $query->connID->insert_id;
        } else
            $return['error'] = 1;

        return $return;
    }

    public function createBasketProduct($data)
    {
        $query = $this->db->table('basketproduct')
            ->insert($data);

        if ($query->resultID == true) {
            $return['error'] = 0;
            $return['id'] = $query->connID->insert_id;
        } else
            $return['error'] = 1;

        return $return;
    }

    public function getBasketView($basketID)
    {
        $query = $this->db->table('basket_view')
            ->where('basketID', $basketID);

        return $query->get()->getResult();
    }

    public function deleteBasketProduct($id)
    {
        $query = $this->db->table('basketproduct')
            ->where('id', $id)
            ->delete();

        return $query->resultID;
    }

    public function updateBasket($data, $id)
    {
        $return = array();

        $query = $this->db->table('basket')
        ->where('id', $id)
        ->update($data);

        if($query == true)
        {
            $return['error'] = 0;
            $return['id'] = $id;
        }
        else
        {
            $return['error'] = 1;
            $return['id'] = $id;
        }

        return $return;
    }

    public function getBasketDTProcessingData($params, $id = '')
    {
        $query = $this->db->table('basket_dt');

        if (!empty($params['search'])) {
            $query->like('formattedDate', $params['search']);
            $query->orLike('basketID', $params['search']);
            $query->orLike('userName', $params['search']);
            $query->orLike('userLastName', $params['search']);
            $query->orLike('paymentMethod', $params['search']);
            $query->orLike('total', $params['search']);
        }

        if(!empty($id))
            $query->where('userID', $id);
            
        $query->offset($params['start']);
        $query->limit($params['length']);
        $query->orderBy($this->getBasketDTProcessingSort($params['sortColumn'], $params['sortDir']));


        return $query->get()->getResult();
    }

    public function getBasketDTProcessingSort($column, $dir)
    {
        $sort = '';

        if ($column == 0) {
            if ($dir == 'asc')
                $sort = 'formattedDate ASC';
            else
                $sort = 'formattedDate DESC';
        }

        if ($column == 1) {
            if ($dir == 'asc')
                $sort = 'basketID ASC';
            else
                $sort = 'basketID DESC';
        }

        if ($column == 2) {
            if ($dir == 'asc')
                $sort = 'userName ASC';
            else
                $sort = 'userName DESC';
        }

        if ($column == 3) {
            if ($dir == 'asc')
                $sort = 'userLastName ASC';
            else
                $sort = 'userLastName DESC';
        }

        if ($column == 4) {
            if ($dir == 'asc')
                $sort = 'paymentMethod ASC';
            else
                $sort = 'paymentMethod DESC';
        }

        if ($column == 4) {
            if ($dir == 'asc')
                $sort = 'paymentMethod ASC';
            else
                $sort = 'paymentMethod DESC';
        }

        if ($column == 5) {
            if ($dir == 'asc')
                $sort = 'total ASC';
            else
                $sort = 'total DESC';
        }

        return $sort;
    }

    public function getTotalBasketDT()
    {
        $query = $this->db->table('basket_dt')
            ->selectCount('basketID')
            ->get()->getResult();

        return $query[0]->basketID;
    }

    public function getTotalDayProduction($userID = '')
    {
        $today = date('d-m-Y');

        $query = $this->db->table('basket')
        ->where('dateCalc', (string) $today)
        ->where('status', 2);

        if($userID != '')
            $query->where('userID', $userID);
        
        $data = $query->get()->getResult();
        $countData = sizeof($data);
        $total = 0;

        for($i = 0; $i < $countData; $i++)
        {
            $total = (float) $total + (float) $data[$i]->total;
        }

        return $total;
    }

    public function getCpanelChartEmployees()
    {
        $query = $this->db->table('user')
        ->select('id, name')
        ->where('status', 1);

        $data = $query->get()->getResult();
        $countData = sizeof($data);

        $cat = array();
        $serie = array();

        for($i = 0; $i < $countData; $i++)
        {
            $cat[$i] = $data[$i]->name;
            $serie[$i] = $this->getTotalDayProduction($data[$i]->id);
        }

        $charData['cat'] = $cat;
        $charData['serie'] = $serie;

        return $charData;
    }
}
