<?
include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";

$inc = $_GET[inc];
$idx = $_POST[idx];
$rtn = 1;

// 예약문자 발송 성공
if($inc == "rsv"){
    $sql = "UPDATE LYDDIE2
            SET
                SMS='Y'
            WHERE 
                idx = $idx
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $rtn = 0;

// 카톡아이디 확인문자 발송 성공
} else if($inc == "chk"){
    $sql = "UPDATE LYDDIE2
            SET
                SMS_kkd='Y'
            WHERE 
                idx = $idx
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $rtn = 0;

// 미체험자 문자발송 성공
} else if($inc == "chk0"){
    $sql = "UPDATE LYDDIE2
            SET
                SMS_chk0='Y'
            WHERE 
                idx = $idx
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $rtn = 0;

// 실체험자(진체험자 제외) 문자발송 성공
} else if($inc == "chk1"){
    $sql = "UPDATE LYDDIE2
            SET
                SMS_chk1='Y'
            WHERE 
                idx = $idx
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $rtn = 0;

// 진체험자 문자발송 성공
} else if($inc == "chk2"){
    $sql = "UPDATE LYDDIE2
            SET
                SMS_chk2='Y'
            WHERE 
                idx = $idx
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $rtn = 0;

} else{

}

echo $rtn;

?>