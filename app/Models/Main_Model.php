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

    public function getUsers()
    {
        $query = $this->db->table('user')->where('status', 1);
        return $query->get()->getResult();
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
            ->select('*')
            ->where('status', 1);

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

        if ($query == true) {
            $return['error'] = 0;
            $return['id'] = $id;
        } else {
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

        if ($query == true) {
            $return['error'] = 0;
            $return['id'] = $id;
        } else {
            $return['error'] = 1;
            $return['id'] = $id;
        }

        return $return;
    }

    public function getBasketDTProcessingData($params, $id = '')
    {
        $query = $this->db->table('basket_dt');

        if (!empty($id)) {
            $query->where('userID', $id);
        } else {
            $query->groupStart();
            $query->where('1', null, false); // Condición falsa para evitar que la cláusula WHERE sea vacía
            $query->groupEnd();
        }

        if (!empty($params['search'])) {
            $query->groupStart();
            $query->like('formattedDate', $params['search']);
            $query->orLike('basketID', $params['search']);
            $query->orLike('userName', $params['search']);
            $query->orLike('userLastName', $params['search']);
            $query->orLike('paymentMethod', $params['search']);
            $query->orLike('total', $params['search']);
            $query->groupEnd();
        }

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

    public function getTotalBasketDT($id = '')
    {
        if(empty($id)) {

            $query = $this->db->table('basket_dt')
                ->selectCount('basketID')
                ->get()->getResult();
        } else {
            $query = $this->db->table('basket_dt')
                ->selectCount('basketID')
                ->where('userID', $id)
                ->get()->getResult();
        }

        return $query[0]->basketID;
    }

    public function getTotalDayProduction($userID = '')
    {
        $today = date('d-m-Y');

        $query = $this->db->table('basket')
            ->where('dateCalc', (string) $today)
            ->where('status', 2);

        if ($userID != '')
            $query->where('userID', $userID);

        $data = $query->get()->getResult();
        $countData = sizeof($data);

        $total = array();
        $total['cash'] = 0;
        $total['card'] = 0;
        $total['all'] = 0;

        for ($i = 0; $i < $countData; $i++) {

            $total['all'] = (float) $total['all'] + (float) $data[$i]->total;

            if ($data[$i]->payType == 1)
                $total['cash'] = (float) $total['cash'] + (float) $data[$i]->total;
            elseif ($data[$i]->payType == 2)
                $total['card'] = (float) $total['card'] + (float) $data[$i]->total;
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

        for ($i = 0; $i < $countData; $i++) {
            $cat[$i] = $data[$i]->name;
            $result = $this->getTotalDayProduction($data[$i]->id);
            $serie[$i] = $result['all'];
        }

        $charData['cat'] = $cat;
        $charData['serie'] = $serie;

        return $charData;
    }

    public function getCpanelChartWeek($userID = '')
    {
        $firstDayOfWeek = date('Y-m-d', strtotime('monday this week')); // Get the first day of the week (Monday)
        $lastDayOfWeek = date('Y-m-d', strtotime('sunday this week')); // Get the last day of the week (Sunday) 

        $query = $this->db->table('basket')
            ->where('date >=', $firstDayOfWeek)
            ->where('date <=', $lastDayOfWeek)
            ->where('status', 2);

        if (!empty($userID))
            $query->where('userID', $userID);

        $data = $query->get()->getResult();
        $countData = sizeof($data);

        $serie['mon'] = 0;
        $serie['tue'] = 0;
        $serie['wed'] = 0;
        $serie['thu'] = 0;
        $serie['fri'] = 0;
        $serie['sat'] = 0;
        $serie['sun'] = 0;
        $serie['total'] = 0;

        $firstDay = date('d-m-Y', strtotime($firstDayOfWeek));

        for ($i = 0; $i < $countData; $i++) {
            if ($firstDay == $data[$i]->dateCalc) $serie['mon'] = $serie['mon'] + $data[$i]->total;
            elseif (date('d-m-Y', strtotime($firstDay . '+1 day')) == $data[$i]->dateCalc) $serie['tue'] = $serie['tue'] + $data[$i]->total;
            elseif (date('d-m-Y', strtotime($firstDay . '+2 day')) == $data[$i]->dateCalc) $serie['wed'] = $serie['wed'] + $data[$i]->total;
            elseif (date('d-m-Y', strtotime($firstDay . '+3 day')) == $data[$i]->dateCalc) $serie['thu'] = $serie['thu'] + $data[$i]->total;
            elseif (date('d-m-Y', strtotime($firstDay . '+4 day')) == $data[$i]->dateCalc) $serie['fri'] = $serie['fri'] + $data[$i]->total;
            elseif (date('d-m-Y', strtotime($firstDay . '+5 day')) == $data[$i]->dateCalc) $serie['sat'] = $serie['sat'] + $data[$i]->total;
            elseif (date('d-m-Y', strtotime($firstDay . '+6 day')) == $data[$i]->dateCalc) $serie['sun'] = $serie['sun'] + $data[$i]->total;
        }

        $serie['total'] = $serie['total'] + $serie['mon'] + $serie['tue'] + $serie['wed'] + $serie['thu'] + $serie['fri'] + $serie['sat'] + $serie['sun'];

        return $serie;
    }

    public function getCpanelChartMont($year, $userID = '')
    {
        $firstDay = date('Y-m-d', strtotime("$year-01-01"));
        $lastDay = date('Y-m-d', strtotime("$year-12-31"));

        $query = $this->db->table('basket')
            ->where('date >=', $firstDay)
            ->where('date <=', $lastDay)
            ->where('status', 2);

        if (!empty($userID))
            $query->where('userID', $userID);

        $data = $query->get()->getResult();
        $countData = sizeof($data);
        $total = 0;


        for ($month = 1; $month <= 12; $month++) {

            $serie[$month] = 0;
            $mont = date("F", mktime(0, 0, 0, $month, 1, $year));
            $daysInMonth = date("t", mktime(0, 0, 0, $month, 1, $year));

            for ($day = 1; $day <= $daysInMonth; $day++) {

                for ($i = 0; $i < $countData; $i++) {
                    if (date('d-m-Y', strtotime($day . '-' . $mont . '-' . $year)) == $data[$i]->dateCalc)
                        $serie[$month] = $serie[$month] + $data[$i]->total;
                }
            }
            $total = $total + $serie[$month];
        }

        $serie['total'] = $total;

        return $serie;
    }

    public function getBasket($id)
    {
        $query = $this->db->table('basket')
            ->where('id', $id);

        return $query->get()->getResult();
    }

    public function getPrintTicketData($basketID)
    {
        $return = array();
        $queryBasket_dt = $this->db->table('basket_dt')
        ->where('basketID', $basketID)
        ->get()
        ->getResult();

        $user = $queryBasket_dt[0]->userName.' '.$queryBasket_dt[0]->userLastName;
        $payType = $queryBasket_dt[0]->paymentMethod;

        $return['user'] = $user;
        $return['payType'] = $payType;

        $queryBasketProduct = $this->db->table('basketproduct')
        ->select('productID')
        ->where('basketID', $basketID)
        ->get()
        ->getResult();

        $countQueryBasketProduct = sizeof($queryBasketProduct);
        $product = array();
        $total = 0;

        for($i = 0; $i < $countQueryBasketProduct; $i++)
        {
            $result = $this->getProductData($queryBasketProduct[$i]->productID);

            $record = array();
            $record['name'] = $result[0]->name;
            $record['cost'] = $result[0]->cost;

            $total = $total + $result[0]->cost;

            $product[$i] = $record;
        }

        $return['product'] = $product;
        $return['total'] = $total;

        return $return;
    }
}
