<?php
/**
 * Created by PhpStorm.
 * User: ABUZO family
 * Date: 3/1/2018
 * Time: 11:03 AM
 */

$host = "localhost";
$username = "root";
$password = "";
$database = "recruitment";
$message = "";

try{
    $connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $error){
    $message = $error->getMessage();
}
