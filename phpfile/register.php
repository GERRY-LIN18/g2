<?php
// 前台 會員註冊
// //跨域(正式開發不能這樣)
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try {
    // 註冊帳號資料
    if($_POST["action"] === "register"){ //送出註冊
        $mem_mail = $_POST["mem_mail"];
        $mem_pwd = $_POST["mem_pwd"];
        $mem_name = $_POST["mem_name"];
        $bday = $_POST["bday"];

        // 身形資料
        $chest = $_POST["chest"];
        $shoulder = $_POST["shoulder"];
        $waistline = $_POST["waistline"];
        $hip = $_POST["hip"];
        $clothes = $_POST["clothes"];
        $pants = $_POST["pants"];
        $chest = $_POST["chest"];
        $shoesize = $_POST["shoesize"];
        $height = $_POST["height"];
        $weight = $_POST["weight"];
        $msg = '';
        $errMsg = "";
        require_once("../connectBooks.php");

        $sql = "INSERT INTO member (mem_mail, mem_pwd, mem_name, bday, mem_date, chest, shoulder, waistline, clothes, pants, shoesize, height, weight,hip)
        VALUES (:mem_mail, :mem_pwd, :mem_name, :bday, CURRENT_DATE(),:chest, :shoulder, :waistline, :clothes, :pants, :shoesize, :height,:weight,:hip);";
        
        $member = $pdo->prepare( $sql );
        $member->bindValue(":mem_mail", $mem_mail);
        $member->bindValue(":mem_pwd", $mem_pwd);
        $member->bindValue(":mem_name", $mem_name);
        $member->bindValue(":bday", $bday);
        $member->bindValue(":chest", $chest);
        $member->bindValue(":shoulder", $shoulder);
        $member->bindValue(":waistline", $waistline);
        $member->bindValue(":clothes", $clothes);
        $member->bindValue(":pants", $pants);
        $member->bindValue(":shoesize", $shoesize);
        $member->bindValue(":height", $height);
        $member->bindValue(":weight", $weight);

        $member->execute();//執行之
        $msg = "success";

    }else if($_POST["action"] === "check_email"){ //檢查 email 是否已註冊
        require_once("../connectBooks.php");
        $sql = "SELECT * from member where mem_mail=:mem_mail;";
        $msg = '';
        $errMsg = '';
        $member = $pdo->prepare( $sql );
        $member->bindValue(":mem_mail", $_POST["mem_mail"]);
        $member->execute();//執行之
        if ($member->rowCount() == 1) { // 已有帳號
            $errMsg = "此帳號已註冊";
        }else{
            $msg = "帳號可使用";
        }
    }
} catch (PDOException $e) {
    $msg = "錯誤 : ".$e -> getMessage();
    $msg .= ", 行號 : ".$e -> getLine();
}
echo json_encode(["msg" => $msg , "errMsg" => $errMsg]);
?> 
