<?
include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";
mysql_query("SET CHARACTER SET 'utf8'");

/*****************************************************************
*사용자 정보 변수
*****************************************************************/
$smsid	= "tella";			// sms 아이디 입력
$pass		= "Pwhoza@2015";		// 비밀번호 입력
$host = "agent1.kssms.kr";
/*****************************************************************
* 리턴값 - code:0000|msg:등록성공|count:1|type:sms|etc1:value1|etc2:value2
*****************************************************************/

// 문자종류 분류
$inc = $_GET["inc"];
// SMS 필수 변수
$send_ok		= $_POST["send_ok"];
$phone			= $_POST["phone"];
$mtype			= $_POST["mtype"];
$msg			= $_POST["msg"];
$callback		= "070-5118-9565";
$upfile			= $_POST["upfile"];
$reservetime	= $_POST["reservetime"];
$reserve_chk	= $_POST["reservetime_chk"];
$etc1				= $_POST["etc1"];
$etc2				= $_POST["etc2"];
$subject			= $_POST["subject"];

if($inc == "once"){
    $rtncd = "";
    // SMS api
    //*****************************************************************
	include_once($_SERVER['DOCUMENT_ROOT']."/home/sms/api.php");
    //*****************************************************************
	$return_arr = smsSend($mtype, $phone, $msg, $callback, $upfile, $reservetime, $subject, $etc1, $etc2, $host, $smsid, $pass, $reserve_chk);
    $rtnarr = explode("|", $return_arr);
    $rtnarr = explode(":", $rtnarr[0]);
    $rtncd = $rtnarr[1];
    if(!($rtncd == 0000 || $rtncd == "0000")){
        echo $rtncd;
        exit;

    } else{
        echo $rtncd;
        exit;

    }

} else if($inc == "finstu"){
    $subject = "[텔라] 수업 종료 안내";
    $week = $_POST["week"];
    $hparr = $_POST["hparr"];
    $banarr = $_POST["banarr"];
    $namearr = $_POST["namearr"];
    $finDate = $_POST["finDate"];
    $errorMsg = "";
    $finMM = date("m", strtotime($finDate));
    $finMM = (int)$finMM;
    $finDD = date("d", strtotime($finDate));
    $finDD = (int)$finDD;

    // 이미 보냈는지 확인
    $sql = "SELECT * FROM sendSMS
            WHERE
                week='$week'
                AND DATE_FORMAT(date_finstu, '%Y-%m-%d')=DATE_FORMAT('$finDate', '%Y-%m-%d')
        ";
    $result = mysql_query($sql, $dbconn) or die(mysql_error());
    $cntRow = mysql_num_rows($result);

    //echo $sql;
    //echo $cntRow;

    // 요일과 날짜가 동시에 일치하지 않으면 SMS 전송
    if($cntRow == 0){
    //if(true){
        if($send_ok=="y") {
            for($i = 0; $i < count($hparr); $i++){
                $phone = $hparr[$i];
                $banstr = "";
                // 튜터링 종류 문자열
                // 텔라톡(텔라콜/ 텔라톡&콜패키지)
                if(strpos($banarr[$i], "텔라톡") !== false) {
                    $banstr = "텔라톡";
                } else if(strpos($banarr[$i], "텔라콜") !== false){
                    $banstr = "텔라콜";
                } else if(strpos($banarr[$i], "/") !== false){
                    $banstr = "텔라톡&콜패키지";
                } else{
                    $banstr = "";
                }
                $msg = $namearr[$i]."님, $banstr 수업 즐겁게 받아보고 계신가요? :)
기신청해주신 $banstr 수업이 ".$finMM."월 ".$finDD."일에 종료됩니다. 지금 바로 사용 가능한 5% 할인쿠폰 발급해드렸습니다! 새로워진 홈페이지(http://tella.co.kr )를 통해 수강 등록해주세요!
이용하시면서 좋았던 점이나, 불편하셨던 점 혹은 문의사항 있으시면 언제든지 이곳 고객센터로 문의해주세요. 좋은 하루 되시기 바랍니다!
고객지원센터
■ 전화 : 070-5118-9565
■ 카톡 : tellakor
■ 메일 : tella@tella.co.kr

*회화의 시작은, 텔라
";
                // SMS api
                //*****************************************************************
	            include_once($_SERVER['DOCUMENT_ROOT']."/home/sms/api.php");
                //*****************************************************************
	            $return_arr = smsSend($mtype, $phone, $msg, $callback, $upfile, $reservetime, $subject, $etc1, $etc2, $host, $smsid, $pass, $reserve_chk);
                $rtnarr = explode("|", $return_arr);
                $rtnarr = explode(":", $rtnarr[0]);
                $rtncd = $rtnarr[1];
                if(!($rtncd == 0000 || $rtncd == "0000")){
                    $errorMsg.=$namearr[$i].":".$rtncd." ";
                } else{
                }
            }        
        } else {
            $errorMsg = "send_ok: ".$send_ok;
        }

        if($errorMsg == ""){
            $sql = "UPDATE sendSMS
                    SET
                        date_finstu=STR_TO_DATE('$finDate', '%Y-%m-%d')
                    WHERE
                        week='$week'
                ";
            $result = mysql_query($sql, $dbconn) or die(mysql_error());
        }

    } else{
        $errorMsg = "Already sent";

    }
    echo $errorMsg;
}

?>