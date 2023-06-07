<?php
/**
 * Created by PhpStorm.
 * User: Lourence
 * Date: 3/10/2017
 * Time: 9:28 AM
 */



function conn()
{

    $server = '192.168.110.31';

    try{
        $pdo = new PDO("mysql:host=$server; dbname=dohdtr",'rtayong_31','rtayong_31');
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
    $server = '192.168.110.31';
    try{
        $pdo = new PDO("mysql:host=$server; dbname=dtsv3.0",'rtayong_31','rtayong_31');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch (PDOException $err) {
        $err->getMessage() . "<br/>";
        die();
    }
    return $pdo;
}

function pis_con()
{
    $pdo = null;
    $server = '192.168.110.31';
    try{
        $pdo = new PDO("mysql:host=$server; dbname=pis",'rtayong_31','rtayong_31');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch (PDOException $err) {
        $err->getMessage() . "<br/>";
        die();
    }
    return $pdo;
}


?>