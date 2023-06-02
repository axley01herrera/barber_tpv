<?php

namespace App\Models;

use CodeIgniter\CLI\Console;
use CodeIgniter\Model;
use CodeIgniter\Database\MySQLi\Builder;

class Main_Model extends Model 
{
    protected $db;
    
    function  __construct () 
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

        if(!empty($id))
        {
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

        if(!empty($params['search']))
        {
            $query->like('name', $params['search']);
            $query->orLike('last_name', $params['search']);
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

        if($column == 0)
        {
            if($dir == 'asc')
                $sort = 'name ASC'; 
            else
                $sort = 'name DESC'; 
        }

        if($column == 1)
        {
            if($dir == 'asc')
                $sort = 'last_name ASC'; 
            else
                $sort = 'last_name DESC'; 
        }

        if($column == 2)
        {
            if($dir == 'asc')
                $sort = 'email ASC'; 
            else
                $sort = 'email DESC'; 
        }

        if($column == 3)
        {
            if($dir == 'asc')
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

        if($query->resultID == true)
        {
            $return['error'] = 0;
            $return['id'] = $query->connID->insert_id;
        }
        else
            $return['error'] = 1;
        
        return $return;
    }

    public function updateUser($data, $id)
    {
        $return = array();

        $query = $this->db->table('user')
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

    public function deleteUser($id)
    {

        $query = $this->db->table('user')
        ->where('id', $id)
        ->delete(); 

        return $query;
    }

    public function getUserData($id)
    {
        $query = $this->db->table('user')
        ->where('id', $id);

        return $query->get()->getResult();
    }

    public function createProducts($data)
    {
        $return = array();

        $query = $this->db->table('product')
        ->insert($data);

        if($query->resultID == true)
        {
            $return['error'] = 0;
            $return['id'] = $query->connID->insert_id;
        }
        else
            $return['error'] = 1;
        
        return $return;
    }

    public function checkProductExist($name, $id='')
    {
        $query = $this->db->table('product')
        ->where('name', $name);

        if(!empty($id))
        {
            $IDs = array();
            $IDs[0] = $id;
            $query->whereNotIn('id', $IDs);
        }

        return $query->get()->getResult();
    }

    public function getProductsProcessingData($params)
    {
        $query = $this->db->table('product');

        if(!empty($params['search']))
        {
            $query->like('name', $params['search']);
            $query->orLike('cost', $params['search']);
        }

        $query->offset($params['start']);
        $query->limit($params['length']);
        $query->orderBy($this->getProductsProcessingSort($params['sortColumn'], $params['sortDir']));

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

    public function getProductsProcessingSort($column, $dir)
    {
        $sort = '';

        if($column == 0)
        {
            if($dir == 'asc')
                $sort = 'name ASC'; 
            else
                $sort = 'name DESC'; 
        }

        if($column == 1)
        {
            if($dir == 'asc')
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

}