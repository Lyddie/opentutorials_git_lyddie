<?
include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";

$inc = $_GET[inc];
$idx = $_POST[idx];
$rtn = 1;

// ���๮�� �߼� ����
if($inc == "rsv"){
    $sql = "UPDATE LYDDIE2
            SET
                SMS='Y'
            WHERE 
                idx = $idx
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $rtn = 0;

// ī����̵� Ȯ�ι��� �߼� ����
} else if($inc == "chk"){
    $sql = "UPDATE LYDDIE2
            SET
                SMS_kkd='Y'
            WHERE 
                idx = $idx
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $rtn = 0;

// ��ü���� ���ڹ߼� ����
} else if($inc == "chk0"){
    $sql = "UPDATE LYDDIE2
            SET
                SMS_chk0='Y'
            WHERE 
                idx = $idx
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $rtn = 0;

// ��ü����(��ü���� ����) ���ڹ߼� ����
} else if($inc == "chk1"){
    $sql = "UPDATE LYDDIE2
            SET
                SMS_chk1='Y'
            WHERE 
                idx = $idx
        ;";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $rtn = 0;

// ��ü���� ���ڹ߼� ����
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