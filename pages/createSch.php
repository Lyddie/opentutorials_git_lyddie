<?
include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";

// ������ �⵵, ��, ������ ��
$year = (int)date("Y", strtotime(now));
$month = (int)date("m", strtotime(now)) + 1;
$lastDate = date("t", strtotime($year."-".$month."-01"));

if($month > 12){
    $month = 1;
    $year++;
}

// ������ ������ �������� Ȯ��
$sql = "SELECT * FROM LYDDIE1
        WHERE 
            DATE_FORMAT(RegDate_f, '%Y-%m')=DATE_FORMAT('$year-$month-01', '%Y-%m')
    ;";
$result = mysql_query($sql, $dbconn) or die(mysql_error());
$cnt = mysql_num_rows($result);

// �̹� ������
if($cnt > 0){
    echo "
        <script>
            alert('Already created!');
            location.replace('./custom1.html');
        </script>";

// ����
} else{        
    $insert_rows = "";
    // ��¥
    for($i = 1; $i <= $lastDate; $i++){
        // �ð�
        for($j = 7; $j <= 22; $j++){
        $insert_rows.= "
            ('$year-$month-$i', '$j:00','A', 0, 0, 0, 'n'),
            ('$year-$month-$i', '$j:00','B', 0, 0, 0, 'n'),
            ('$year-$month-$i', '$j:30','B', 0, 0, 0, 'n'),";
        }
    }
    $insert_rows = trim($insert_rows);
    $insert_rows = trim($insert_rows, ",");

    $sql = "INSERT INTO LYDDIE1 
                (RegDate_f, ApplyTime, Class, Capa, RealNum, Rest, Avail)
            VALUES 
                $insert_rows
            ;";
    $result=mysql_query($sql, $dbconn) or die(mysql_error());
    echo "
        <script>
            alert('Success');
            location.replace('./custom1.html');
        </script>";
}

?>