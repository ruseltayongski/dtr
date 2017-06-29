<?php
class pdoController extends BaseController
{
    //PDO
    public static function connect()
    {
        /*return new PDO("mysql:host=localhost;dbname=dtsv3.0",'root','');*/
        return DB::connection('dts')->getPdo();
    }
    public static function users()
    {
        $db=pdoController::connect();
        $sql="SELECT * FROM USERS ORDER BY FNAME ASC";
        $pdo = $db->prepare($sql);
        $pdo->execute();
        $row = $pdo->fetchAll();
        $db = null;
        return $row;
    }
    public static function user_search($id)
    {
        $db=pdoController::connect();
        $sql="SELECT * FROM USERS WHERE USERNAME = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($id));
        $row = $pdo->fetch();
        $db = null;
        return $row;
    }
    public static function user_search1($id)
    {
        $db= pdoController::connect();
        $sql="SELECT * FROM USERS WHERE id = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($id));
        $row = $pdo->fetch();
        $db = null;
        return $row;
    }
    public static function designation_search($id)
    {
        $db = pdoController::connect();
        $sql = "select * from designation where id = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($id));
        $row = $pdo->fetch();
        $db = null;
        return $row;
    }
    public static function division()
    {
        $db=pdoController::connect();
        $sql="SELECT * FROM DIVISION";
        $pdo = $db->prepare($sql);
        $pdo->execute();
        $row = $pdo->fetchAll();
        $db = null;
        return $row;
    }
    public static function division_head($head)
    {
        $db=pdoController::connect();
        $sql="SELECT * FROM DIVISION where head = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($head));
        $row = $pdo->fetch();
        $db = null;
        return $row;
    }
    public static function section()
    {
        $db=pdoController::connect();
        $sql="SELECT * FROM SECTION";
        $pdo = $db->prepare($sql);
        $pdo->execute();
        $row = $pdo->fetchAll();
        $db = null;
        return $row;
    }
    public static function section_head($head)
    {
        $db=pdoController::connect();
        $sql="SELECT * FROM DIVISION where head = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($head));
        $row = $pdo->fetch();
        $db = null;
        return $row;
    }
    public static function insert_tracking_master($route_no,$doc_type,$prepared_date,$prepared_by,$description)
    {
        $db=pdoController::connect();
        $sql="INSERT INTO TRACKING_MASTER(route_no,doc_type,prepared_date,prepared_by,description,created_at,updated_at) values(?,?,?,?,?,now(),now())";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($route_no,$doc_type,$prepared_date,$prepared_by,$description));
        $db=null;
    }
    public static function delete_tracking_master($route_no)
    {
        try{
            $db=pdoController::connect();
            $sql="delete from tracking_master where route_no=?";
            $pdo = $db->prepare($sql);
            $pdo->execute(array($route_no));
            $db = null;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }
    public static function delete_tracking_release($route_no)
    {
        try{
            $db=pdoController::connect();
            $sql="delete from tracking_relese where route_no=?";
            $pdo = $db->prepare($sql);
            $pdo->execute(array($route_no));
            $db = null;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }
    public static function delete_tracking_details($route_no)
    {
        try{
            $db=pdoController::connect();
            $sql="delete from tracking_details where route_no=?";
            $pdo = $db->prepare($sql);
            $pdo->execute(array($route_no));
            $db = null;
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
    }
    public static function insert_tracking_details($route_no,$date_in,$received_by,$delivered_by,$action)
    {
        $db=pdoController::connect();
        $sql="INSERT INTO TRACKING_DETAILS(route_no,date_in,received_by,delivered_by,action,created_at,updated_at) values(?,?,?,?,?,now(),now())";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($route_no,$date_in,$received_by,$delivered_by,$action));
        $db=null;
    }
    public static function insert_system_logs($user_id,$name,$activity,$route_no)
    {
        $db=pdoController::connect();
        $sql="INSERT INTO SYSTEMLOGS(user_id,name,activity,description,created_at,updated_at) values(?,?,?,?,now(),now())";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($user_id,$name,$activity,$route_no));
        $db=null;
    }
    public static function search_tracking_master($route_no)
    {
        $db=pdoController::connect();
        $sql="SELECT * FROM tracking_master where route_no = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($route_no));
        $row = $pdo->fetch();
        $db = null;
        return $row;
    }
    public static function search_tracking_details($route_no)
    {
        $db=pdoController::connect();
        $sql="SELECT * FROM tracking_details where route_no = ? ORDER BY id ASC";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($route_no));
        $row = $pdo->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        return $row;
    }
    public static function search_section($id)
    {
        $db=pdoController::connect();
        $sql="SELECT * FROM section where id = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($id));
        $row = $pdo->fetch();
        $db = null;
        return $row;
    }
    public static function search_division($id)
    {
        $db=pdoController::connect();
        $sql="SELECT * FROM division where id = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($id));
        $row = $pdo->fetch();
        $db = null;
        return $row;
    }
    public static function update_tracking_master($prepared_date,$subject,$route_no){
        $db = pdoController::connect();
        $sql = "UPDATE tracking_master set prepared_date = ? ,description = ? where route_no = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($prepared_date,$subject,$route_no));
        $db = null;
    }
    public static function update_tracking_details($subject,$route_no){
        $db = pdoController::connect();
        $sql = "UPDATE tracking_details set action = ? where route_no = ?";
        $pdo = $db->prepare($sql);
        $pdo->execute(array($subject,$route_no));
        $db = null;
    }
}