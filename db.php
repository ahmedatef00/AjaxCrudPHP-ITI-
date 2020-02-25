<?php
try{
$username = 'root';
$password = '';
$connection = new PDO( 'mysql:host=localhost;dbname=crud', $username, $password );
array(PDO::MYSQL_ATTR_INIT_COMMAND=> "SET NAMES UTF8",//arabic 
PDO:: ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,

);}
catch (PDOException $e){
    $e->getMessage();
}

