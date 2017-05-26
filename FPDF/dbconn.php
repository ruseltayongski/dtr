<?php
/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 3/10/2017
 * Time: 9:28 AM
 */



function conn()
{

    $server = 'localhost';

    try{
        $pdo = new PDO("mysql:host=$server; dbname=dohdtr",'root','');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch (PDOException $err) {
        echo "<h3>Can't connect to database server address $server</h3>";
        exit();
    }
    return $pdo;
}


function dts_con()
{
    $pdo = null;
    $server = 'localhost';
    try{
        $pdo = new PDO("mysql:host=$server; dbname=dtsv3.0",'root','');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch (PDOException $err) {
        $err->getMessage() . "<br/>";
        die();
    }
    return $pdo;
}


?>