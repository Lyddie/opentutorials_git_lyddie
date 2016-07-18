<?
include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";
mysql_query("SET NAMES utf8");

// 성공하면 echo 0; 실패하면 echo 1;
$inc = $_GET["inc"];
$idx = $_POST["idx"];   // == MEMBER[num]
$chk_idx=$_REQUEST['chk'];
$MemberId = trim($_POST["memberId"]);
$Kor_Name = trim($_POST["Kor_Name"]);
$Kakao_ID = $_POST["Kakao_ID"];
$newKakao_ID = trim($_POST["newKakao_ID"]);
$phone_Num = trim($_POST["phone_Num"]);
$ApplyDay = $_POST["ApplyDay"];
$category = $_POST["category"];
$ApplyTime = trim($_POST["ApplyTime"]);
$date = $_POST["date"];

$sql = "";
if($inc == "trial"){
    $Kakao_ID = trim($Kakao_ID);

    if($idx == -1 || $idx == "-1"){

        $sql = "INSERT INTO LYDDIE2
                SET
                    StuName='$Kor_Name'
                    ,KakaoId='$Kakao_ID'
                    ,PhoneNo='$phone_Num'
                    ,RegDate_f=STR_TO_DATE('$ApplyDay', '%Y-%m-%d')
                    ,ApplyTime=STR_TO_DATE('$ApplyTime', '%H:%i')
                    ,Class='$category'
                    ,Today=NOW()
                ";

    } else {
        $sql = "UPDATE LYDDIE2
                SET
                    StuName='$Kor_Name'
                    ,KakaoId='$Kakao_ID'
                    ,PhoneNo='$phone_Num'
                    ,RegDate_f=STR_TO_DATE('$ApplyDay', '%Y-%m-%d')
                    ,ApplyTime=STR_TO_DATE('$ApplyTime', '%H:%i')
                    ,Class='$category'
                WHERE
                    idx='$idx'
                ";
    }
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    echo 0;

} else if($inc == "kkd"){
    // num 이 없는 경우
    if($idx == "" || $idx == null){
        echo 1;
        exit;

    // Tutoring_list[N_Student] 변경
    // LYDDIE2[KaKaoId] 변경
    } else if($idx == 0 || $idx == "0"){
        // MEMBER[num] 가져오기
        $sql = "SELECT num FROM MEMBER
                WHERE 
                    KaKaoId='$newKakao_ID'
                ;";
        $result = mysql_query($sql, $dbconn) or die(mysql_error());
        if(!$result){
            echo "ERROR: QUERY MEMBER WHERE Student '$Kakao_ID'";
            exit;

        }
        $rownum = mysql_num_rows($result);
        if($rownum == 0){
            echo "입력한 ID는 없는 카카오톡ID입니다.";
            exit;

        } else if($rownum > 1){
            echo "입력한 카카오톡ID에 해당하는 회원이 2명 이상입니다. 회원정보를 확인해주세요.";
            exit;

        } else if($rownum == 1){
            // update TL 
            $row = mysql_fetch_array($result);
            $sql = "UPDATE Tutoring_list
                    SET
                        N_Student='$row[num]'
                    WHERE 
                        Student='$Kakao_ID'
                        AND N_Student=0
                    ;";
            $result = mysql_query($sql, $dbconn) or die(mysql_error());
            if(!$result){
                echo "ERROR: UPDATE Tutoring_list WHERE Student '$Kakao_ID'";
                exit;

            }
            // update LYDDIE2
            $sql = "UPDATE LYDDIE2
                    SET
                        KaKaoId='$newKakao_ID'
                    WHERE 
                        KaKaoId='$Kakao_ID'
                    ";
            $result = mysql_query($sql, $dbconn) or die(mysql_error());
            if(!$result){
                echo "ERROR: UPDATE LYDDIE2 WHERE Student '$Kakao_ID'";
                exit;

            }
            echo 0;
            exit;
        }
        echo 1;
        exit;
        
    // MEMBER[KaKaoId] 변경
    // Tutoring_list[N_Student] 변경
    // LYDDIE2[KaKaoId] 변경
    } else{
        // update MEMBER
        $sql = "UPDATE MEMBER 
                SET 
                    KaKaoId='$newKakao_ID' 
                WHERE  
                    num=$idx
                ;";
        $result = mysql_query($sql, $dbconn) or die(mysql_error());
        if(!$result){
            echo "ERROR: UPDATE MEMBER WHERE num '$idx'";
            exit;
        }

        // update TL 
        $sql = "UPDATE Tutoring_list
                SET
                    N_Student=$idx
                WHERE 
                    Student='$newKakao_ID'
                    AND N_Student=0
                ;";
        $result = mysql_query($sql, $dbconn) or die(mysql_error());
        if(!$result){
            echo "ERROR: UPDATE Tutoring_list WHERE num '$idx'";
            exit;
        }

        // update LYDDIE2
        $sql = "UPDATE LYDDIE2
                SET
                    KaKaoId='$newKakao_ID'
                WHERE 
                    KaKaoId='$Kakao_ID'
                ";
        $result = mysql_query($sql, $dbconn) or die(mysql_error());
        if(!$result){
            echo "ERROR: UPDATE LYDDIE2 WHERE num '$idx'";
            exit;
        }
        echo 0;
        exit;
    }


} else if($inc == "cal"){
        // calendar check
        $sql = "UPDATE LYDDIE2
                SET
                    Cal_chk='Y'
                WHERE 
                    idx=$idx
                ;";
        $result = mysql_query($sql, $dbconn) or die(mysql_error());

        if(!$result){
            echo "ERROR: UPDATE LYDDIE2 WHERE idx '$idx'";
            exit;

        } else{
            echo 0;
            exit;
        }

} else if($inc == "apply"){
    $kkd_arr = array();
    $id_arr = array();
    // 해당 날짜 카카오아이디 조회
    $sql = "SELECT KakaoId FROM LYDDIE2
            WHERE 
                RegDate_f = STR_TO_DATE('$date', '%Y-%m-%d')
        ";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    while($row = mysql_fetch_array($result)){
        array_push($kkd_arr, trim($row["KakaoId"]));
    }
    $kkd_arr = array_unique($kkd_arr);
    $kkd_str = join("','", $kkd_arr);
    // 해당 카카오아이디 회원 조회
    $sql = "SELECT MemberId FROM MEMBER
            WHERE KaKaoId IN
                ('$kkd_str');                
        ";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    while($row = mysql_fetch_array($result)){
        array_push($id_arr, $row["MemberId"]);
    }
    $id_str = join("','", $id_arr);
    // 해당 회원 중 결제자 아이디 조회
    $sql = "SELECT MemberId FROM Tutoring 
            WHERE MemberId IN
                ('$id_str');
        ";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $id_arr = array();
    while($row = mysql_fetch_array($result)){
        array_push($id_arr, $row["MemberId"]);
    }
    $id_arr = array_unique($id_arr);
    $id_str = join("','", $id_arr);
    // 해당 회원 카카오아이디 조회
    $sql = "SELECT KaKaoId FROM MEMBER 
            WHERE MemberId IN
                ('$id_str');
        ";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $kkd_arr = array();
    while($row = mysql_fetch_array($result)){
        array_push($kkd_arr, $row["KaKaoId"]);
    }
    $kkd_str = join("','", $kkd_arr);
    // 해당 카카오아이디 Apl_chk 'Y'로 변경
    $sql = "UPDATE LYDDIE2
            SET
                Apl_chk='Y'
            WHERE KakaoId IN
                ('$kkd_str');
        ";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());

    if(!$result){
        echo "ERROR: UPDATE LYDDIE2 Apl_chk";
        exit;
    } else {
        echo 0;
        exit;
    }
} else if($inc == "holding_del"){
    for($i=0; $i<count($chk_idx); $i++){
        $sql = "SELECT N_Tutoring FROM holding WHERE idx=".$chk_idx[$i].";";
        $result = mysql_query($sql, $dbconn) or die(mysql_error());
        $row=mysql_fetch_array($result);
        $N_Tutoring = $row[N_Tutoring];
        $sql = "DELETE FROM holding WHERE idx=".$chk_idx[$i].";";
        $result=mysql_query($sql, $dbconn);
        $sql = "UPDATE Tutoring 
                SET 
                    Holding = (Holding + 1)
                WHERE 
                    idx=$N_Tutoring
                ;";
        $result = mysql_query($sql, $dbconn) or die(mysql_error());
    }
    echo "success";
    exit;

} else if($inc == "holding_cfm"){
    $sql = "UPDATE holding SET Status=2 WHERE idx=$idx;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    echo "success_cfm";
    exit;
} else if($inc == "holding_cancle"){
    $sql = "SELECT N_Tutoring FROM holding WHERE idx=$idx;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $row=mysql_fetch_array($result);
    $N_Tutoring = $row[N_Tutoring];
    $sql = "UPDATE Tutoring 
            SET 
                Holding = (Holding + 1)
            WHERE 
                idx=$N_Tutoring
            ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $sql = "UPDATE holding SET Status=3 WHERE idx=$idx;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    echo "success_cancle";
    exit;
} else if($inc == "holding_crt"){
    $N_Tutoring = $_POST["N_Tutoring"];
    $date = $_POST["holding_date"];
    $_mem_num = $_POST["mem_num"];

    $sql = "UPDATE Tutoring
        SET 
            Holding = ( CASE 
                    WHEN Holding > 0 THEN Holding-1
                    ELSE 0
                END
            )
        WHERE 
            idx=$N_Tutoring
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    if(!$result){
        echo "error: update tutoring ";
        exit;
    }
    // Status = 2
    $sql = "INSERT INTO holding  
        SET
            N_Tutoring=$N_Tutoring
            ,MemberNum=$_mem_num
            ,ReqDate=now()
            ,HoldingDate=STR_TO_DATE('$date', '%Y-%m-%d')
            ,Status=2
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    if(!$result){
        echo "error: update holding ";
        exit;
    }
    
    echo "success_crt";
    exit;



} else{
    echo 1;
    exit;
}

?>