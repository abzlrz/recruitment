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
    public $connection;

    private $firstname;
    private $lastname;
    private $acctype;
    public $email;
    private $password;
    public $id;

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
            $this->msg = "incorrect username or password";
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

    public function getId()
    {
        return $this->id;
    }

    public function isApplicant(){
        if($this->acctype == 0){
            return true;
        }
        return false;
    }

    public function proceed(){
        if($this->acctype == 1){
            header("location: core/jobposting.php");
        }else{
            header("location: index.php");
        }

    }

    public function logout(){
        session_destroy();
    }

    public function signup($firstname, $lastname, $email, $password){
        try{
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
                $this->msg = "Email already registered";
                return false;
            }
        }catch (Exception $ex){
            $this->msg = "Email already registered";
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
        $this->id = $result['id'];
        $this->firstname = $result['firstname'];
        $this->lastname = $result['lastname'];
        $this->email = $result['email'];
        $this->password = $result['password'];
        $this->acctype = $result['accesstype'];
    }
}

class JobPost{
    private $_id;
    private $_jobDescription;
    private $_salary;
    private $_skillRequirements;
    private $_hiringTime;
    private $connection;

    public $msg;

    public function __construct(){
    }

    public function setConnection($pdo){
        $this->connection = $pdo;
    }

    public function insert($jobDescription, $salary, $skillRequirements, $hiringTime){
        try{
            $query = $this->connection->prepare("call sp_insert_jobpost(?,?,?,?)");
            $query->bindParam(1, $jobDescription);
            $query->bindParam(2, $salary);
            $query->bindParam(3, $skillRequirements);
            $query->bindParam(4, $hiringTime);
            $result = $query->execute();
            if ($result){
                $this->msg = "data successfully saved!";
                return true;
            }else{
                return false;
            }
        }catch (Exception $ex){
            $this->msg = $ex->getMessage();
        }
    }

    public function update($jobDescription, $salary, $skillRequirements, $hiringTime, $id){
        try{
            $query = $this->connection->prepare("call sp_update_jobpost(?,?,?,?,?)");
            $query->bindParam(1, $jobDescription);
            $query->bindParam(2, $salary);
            $query->bindParam(3, $skillRequirements);
            $query->bindParam(4, $hiringTime);
            $query->bindParam(5, $id);
            $result = $query->execute();

            if ($result){
                $data = $query->fetch();
                $this->getInfo($data);
                $this->msg = "data successfully saved!";
                return true;
            }else{
                return false;
            }
        }catch (Exception $ex){

        }
    }

    public function applyJob($id, $post){
        try{
            $query = $this->connection->prepare("call sp_apply_jobpost(?,?)");
            $query->bindParam(1, $id);
            $query->bindParam(2, $post);
            $query->execute();
        }catch (Exception $ex){
            $this->msg = $ex->getMessage();
        }
    }

    public function searchJob($input){
        try{
            $query = $this->connection->prepare("call sp_search_jobpost(?)");
            $query->bindParam(1, $input);
            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $ex){
            $this->msg = $ex->getMessage();
        }
    }

    private function getInfo($result){
        $this->_id = $result['id'];
        $this->_jobDescription = $result['jobdescription'];
        $this->_salary = $result['salary'];
        $this->_skillRequirements = $result['skillrequirements'];
        $this->_hiringTime = $result['hiringtime'];
    }

    public function showAll(){
        try{
            $results = $this->connection->query("call sp_show_jobpost()");
            return $results;
        }catch (Exception $ex){
            $this->msg = $ex->getMessage();
        }
    }

    public function getInfoByID($value){
        try{
            $query = $this->connection->prepare("call sp_get_jobpost(?)");
            $query->bindParam(1, $value);
            $query->execute();

            $result = $query->fetch();
            $this->getInfo($result);
        }catch (Exception $ex){
            $this->msg = $ex->getMessage();
        }
    }

    public function delete($value){
        try{
            $query = $this->connection->prepare("call sp_delete_jobpost(?)");
            $query->bindParam(1, @$value);
            $query->execute();
        }catch (Exception $ex){
            $this->msg = $ex->getMessage();
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getJobDescription()
    {
        return $this->_jobDescription;
    }

    /**
     * @return mixed
     */
    public function getSalary()
    {
        return $this->_salary;
    }

    /**
     * @return mixed
     */
    public function getSkillRequirements()
    {
        return $this->_skillRequirements;
    }

    /**
     * @return mixed
     */
    public function getHiringTime()
    {
        return $this->_hiringTime;
    }
}
