<?php
//admin_3
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    session_start();
    if(isset($_SESSION['userData'])){
        if(!in_array($_SESSION['userData']['userLevel'],[1,2])){
            header('Content-Type: application/json');
            echo json_encode(['message'=>'error','success'=>false]);
            die();
        }
    }else{
        header('Content-Type: application/json');
        echo json_encode(['message'=>'error','success'=>false]);
        die();
    }   
    if (isset($_POST['type'], $_POST['short']) && in_array($_POST['type'], ['project', 'offer']) && in_array($_POST['short'], ['asc', 'desc'])) {
        include('../application/controller_base.class.php');
        include('../application/Encryption.class.php');
        include('../model/db.class.php');
        include('../model/report.class.php');
        $registry = null;
        $report = new report();
        $db = new  db($registry);
        $db->getInstance();
        $result = '';
        foreach ($report->pointsCount($_POST['type'], "", "ORDER BY `count` " . $_POST['short']) as $item) {
            $result .= '
        <tr>
            <td class="text-center">' . $item->id . '</td>
            <td class="text-center">' . $item->count . '</td>
            ' . (($_POST['type'] == 'project') ? '<td class="text-center"><p style=" width: 250px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">' . $item->name . '</p></td>' : '') . '
            <td class="text-center"><p style=" width: 250px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">' . $item->description . '</p></td>
        </tr>
        ';
        }
        header('Content-Type: application/json');
        echo json_encode(['message' => 'success', 'success' => true, 'result' => $result]);
    }else{
        header('Content-Type: application/json');
        echo json_encode(['message'=>'error','success'=>false]);
    }

}else{
    header("HTTP/1.0 404 Not Found");
    die();
}
?>

