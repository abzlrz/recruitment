<?php
/**
 * Created by PhpStorm.
 * User: ABUZO Family
 * Date: 3/10/2018
 * Time: 10:17 AM
 */
include "config.php";

class User{
    public $msg;
    private $connection;

    private $firstname;
    private $lastname;
    private $acctype;
    private $email;
    private $password;

    public function __construct()
    {
        session_start();
    }

    public function setConnection($pdo){
        $this->connection = $pdo;
    }

    public function login($email, $password){
        try{
            if($this->checkInputs($email, $password)){
                $query = $this->connection->prepare("call sp_login(?,?)");
                $query->bindParam(1, $this->email);
                $query->bindParam(2, $this->password);
                $query->execute();

                if ($query->rowCount() == 1){
                    $result = $query->fetch();
                    $this->getInfo($result);
                    return true;
                } else{
                    $this->msg = "incorrect username or password";
                    return false;
                }
            }
        }catch (Exception $ex){
            $this->msg = $ex->getMessage();
        }
    }

    public function getFirstname(){
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function isApplicant(){
        if($this->acctype == 0){
            return true;
        }
        return false;
    }

    public function proceed(){
        if($this->acctype == 1){
            header("location: manage.php");
        }else{
            header("location: index.php");
        }

    }

    public function logout(){
        session_destroy();
    }

    public function signup($firstname, $lastname, $email, $password){
        $query = $this->connection->prepare("call sp_sign_up(?,?,?,?)");
        $query->bindParam(1, $firstname);
        $query->bindParam(2, $lastname);
        $query->bindParam(3, $email);
        $query->bindParam(4, $password);
        $result = $query->execute();
        if ($result){
            $this->getInfoByEmail($email);
            return true;
        }else{
            return false;
        }
    }

    public function updateAccount($firstname, $lastname, $email, $password, $accesstype, $targetemail){
        $query = $this->connection->prepare("call sp_update_account(?,?,?,?,?,?)");
        $query->bindParam(1, $firstname);
        $query->bindParam(2, $lastname);
        $query->bindParam(3, $email);
        $query->bindParam(4, $password);
        $query->bindParam(5, $accesstype);
        $query->bindParam(6, $targetemail);
        $result = $query->execute();

        if ($result){
            $this->getInfoByEmail($email);
            $this->msg = "data saved!";
            return true;
        }else{
            return false;
        }
    }

    private function getInfoByEmail($email){
        try{
            $query = $this->connection->prepare("select * from person where email=?");
            $query->bindParam(1, $email);
            $query->execute();

            $result = $query->fetch();
            $this->getInfo($result);
        }catch (Exception $ex){
            $this->msg = $ex->getMessage();
        }
    }

    private function checkInputs($email, $password){
        if(!empty($email) || !empty($password)){
            $this->email = $email;
            $this->password = $password;
            return true;
        }
        else{
            $this->msg = "Please enter username and password";
            return false;
        }
    }

    private function getInfo($result){
        $this->firstname = $result['firstname'];
        $this->lastname = $result['lastname'];
        $this->email = $result['email'];
        $this->password = $result['password'];
        $this->acctype = $result['accesstype'];
    }
}

class DatabaseTable{

    public $pdo;
    public $table;
    public $primaryKey;

    private function query($sql, $parameters = []){
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
    }

    private function processDates($fields) {
        foreach ($fields as $key => $value) {
            if ($value instanceof DateTime) {
                $fields[$key] = $value->format('Y-m-d');
            }
        }
        return $fields;
    }

    private function insert($fields){
        $query = "insert into '$this->table'(";
        foreach ($fields as $key => $value){
            $query .= "'$key',";
        }
        $query = rtrim($query, ',');
        $query .= ") values(";
        foreach ($fields as $key => $value){
            $query .= ":$key, ";
        }
        $query = rtrim($query, ',');
        $query .= ")";
        $fields = $this->processDates($fields);

        $this->query($query, $fields);
    }

    private function update($fields){
        $query = "update '$this->table' set";
        foreach ($fields as $key => $value){
            $query .= "'$key' = :$key,";
        }
        $query = rtrim($query, ',');
        $query .= "where '$this->primaryKey' = :primarykey";
        $fields['primaryKey'] = $fields['id'];
        $fields = $this->processDates($fields);

        $this->query($query, $fields);
    }

    public function delete($id){
        $parameters = [":id" => $id];
        $sql = "delete from '$this->table' where '$this->primaryKey' = :id";
        $this->query($sql, $parameters);
    }

    public function findAll(){
        $result = $this->query( "select * from '$this->table'");
        return $result->fetchAll();
    }

    public function total(){
        $query = $this->query("select count(*) from '$this->table'");
        $row = $query->fetch();
        return $row[0];
    }

    public function find($column, $value){
        $query = "select * from '$this->table' where '$column' = '$value'";
        $parameters = ['value' => $value];
        $query = $this->query($query, $parameters);
        return $query->fetchAll();
    }

    public function findByVals($extension){
        $query = "select * from '$this->table' where $extension";
        $query = $this->query($query);
        return $query->fetchAll();
    }

    public function findByID($value){
        $query = "select * from '$this->table' where '$this->primaryKey' = :value";
        $parameters = [
            'value' => $value
        ];
        $query = $this->query($query, $parameters);
        return $query->fetch();
    }

    public function save($record){
        try{
            if($record[$this->primaryKey] == ''){
                $record[$this->primaryKey] = null;
            }
            $this->insert($record);
        } catch (PDOException $exception){
            $this->update($record);
        }
    }

    public function __construct(PDO $pdo, string $table, string $primaryKey){
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }
}