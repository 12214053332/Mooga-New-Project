<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(isset($_POST['type'],$_POST['id'])&&in_array($_POST['type'],['projects','offers'])){
        session_start();
        if(isset($_SESSION['userData'])){
            if(!in_array($_SESSION['userData']['userLevel'],[2])){
                include'errors/permissions.php';
                die();
            }
            $table=$_POST['type'];
            $id=filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            include  ('../application/controller_base.class.php');
            include  ('../application/Encryption.class.php');
            include  ('../model/db.class.php');
            include  ('../model/report.class.php');
            $db=new db(null);
            $db->getInstance();
            $query="SELECT * FROM $table WHERE id='$id'";
            $result=$db->execquery($query);
            if($result){
                $query="UPDATE $table SET pending='0' WHERE id='$id'";
                $db->execquery($query);
                $data=['message'=>'success active','success'=>true];
                header('Content-Type: application/json');
                echo json_encode($data);
            }else{
                $data=['message'=>'No Data','success'=>false];
                header('Content-Type: application/json');
                echo json_encode($data);
            }
        }else{
            include'errors/404.php';
        }
    }else{
        include'errors/404.php';
    }
}else{
    include'errors/404.php';
}
