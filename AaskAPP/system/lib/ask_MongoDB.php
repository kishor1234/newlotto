<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CMongoDB
 *
 * @author asksoft
 */
class ask_MongoDB {

    //put your code here
    public $db;
    public $connection;
    public function ask_MongoDB() {
        $this->db = $this->createMongoDB();
    }

    public function createMongoDB() {
        $config = array(
            'username' => 'kishor',
            'password' => 'kishor',
            'dbname' => 'siddhi',
            'connection_string' => sprintf('mongodb://%s:%d/%s', '127.0.0.1', '27017', 'admin')
        );
        try {
            if (!class_exists('Mongo')) {
                echo ("The MongoDB PECL extension has not been installed or enabled");
                return false;
            }

            $this->connection = new \MongoClient($config['connection_string'], array('username' => $config['username'], 'password' => $config['password']));
            return $this->db =  $this->connection->selectDB($config['dbname']);
        } catch (Exception $e) {
            return false;
        }
    }

    public function insertData($collection, $data) {
        $table = $this->db->selectCollection($collection);
        return $table->insert($data);
    }

    public function insertInvoice($collection, $data) {
        $table = $this->db->selectCollection($collection);
        $table->insert($data);
        return $data; // var_dump($data);
    }

    public function incdata($id, $collection, $data) {
        $table = $this->db->selectCollection($collection);
        //echo $id;
        $criteria = array("_id" => new \MongoId($id));
        $newdata = array('$inc' => $data);
        $options = array("upsert" => true);
        //$oldData=array('_id'=> new MongoId($id));
        //echo $oldData['_id'];
        return $table->update(
                        $criteria, $newdata, $options
        );
    }
    public function putData($id,$collection,$data)
    {
        $table = $this->db->selectCollection($collection);
        //echo $id;
        $criteria = array("_id" => new \MongoId($id));
        $newdata = array('$push' => $data);
        $options = array("upsert" => true);
        //$oldData=array('_id'=> new MongoId($id));
        //echo $oldData['_id'];
        return $table->update(
                        $criteria, $newdata, $options
        );
    }
    public function selectData($collection, $data) {
        $table = $this->db->selectCollection($collection);
        return $table->find($data);
    }

    public function removeData($collection, $_id) {
        if (strlen($_id) == 24) {
            $_id = new \MongoId($_id);
        }
        $table = $this->db->selectCollection($collection);
        $result = $table->remove(array("_id" => $_id));
        if (!$_id) {
            return false;
        }
        return $result;
    }

    public function updateData($id, $collection, $data) {
        $table = $this->db->selectCollection($collection);
        //echo $id;
        $criteria = array("_id" => new \MongoId($id));
        $newdata = array('$set' => $data);
        $options = array("upsert" => true, "multiple" => true);
        //$oldData=array('_id'=> new MongoId($id));
        //echo $oldData['_id'];
        return $table->update(
                        $criteria, $newdata, $options
        );
        // $table->update($oldData,$data);
    }

    public function getID($email) {
        
    }
    public function getCollection()
    {
        $db= $this->connection->selectDB("siddhi");
        return $db->listCollections();
    }

}
