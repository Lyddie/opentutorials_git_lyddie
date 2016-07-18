<?

// 문자종류 분류
$inc = $_GET["inc"];
$name = $_POST["name"];
$banTime = $_POST["banTime"];
$regDate = $_POST["regDate"];
// SMS 필수 변수
$send_ok		= "y";
$phone			= $_POST["hp"];
$mtype			= $_POST["mtype"];
$msg			= $_POST["msg"];
$callback		= "070-5118-9565";
$upfile			= $_POST["upfile"];
$reservetime	= $_POST["reservetime"];
$reserve_chk	= $_POST["reservetime_chk"];
$etc1				= $_POST["etc1"];
$etc2				= $_POST["etc2"];
$subject			= $_POST["subject"];

// 무료체험 예약문자
if($inc == "rsv"){
    $reserve_chk	= "Y";
    // msg1 30분 전 예약문자
    $mtype1 = "sms";
    $msg1 = "[텔라] ".$name."님의 무료체험이 잠시 후 $banTime 에 시작합니다. 즐겁게 대화하세요!";
    $date = date_create($regDate." ".$banTime);
    $date_str = date_format($date, "Y-m-d H:i:s");
    $reservetime1 = date("Y-m-d H:i:s", strtotime($date_str."-30 minutes"));
    $subject1 = "";

    // msg2 10분 전 예약문자
    $mtype2 = "mms";
    $msg2 = $name."님, 10분 후 튜터에게 오는 카카오톡 메시지를 놓치지 마세요.
  
■ 일시 : $regDate $banTime

무료체험 결과확인부터 수강신청, 수업진행까지 텔라 홈페이지에서! http://tella.co.kr/ 
  
회화의 시작은, 텔라
    ";
    $date = date_create($regDate." ".$banTime);
    $date_str = date_format($date, "Y-m-d H:i:s");
    $reservetime2 = date("Y-m-d H:i:s", strtotime($date_str."-10 minutes"));
    $subject2 = "[텔라] 무료체험 안내";



    if($send_ok=="y")
    {
	    include_once($_SERVER['DOCUMENT_ROOT']."/home/sms/api.php");
	    /*****************************************************************
	    *사용자 정보 변수
	    *****************************************************************/
	    $smsid	= "tella";			// sms 아이디 입력
	    $pass		= "Pwhoza@2015";		// 비밀번호 입력
	    $host_ip = "agent1.kssms.kr";

	    /*****************************************************************
	    * 리턴값 - code:0000|msg:등록성공|count:1|type:sms|etc1:value1|etc2:value2
	    *****************************************************************/
	    $return_arr = smsSend($mtype1, $phone, $msg1, $callback, $upfile, $reservetime1, $subject1, $etc1, $etc2, $host_ip, $smsid, $pass, $reserve_chk);
        $rtnarr = explode("|", $return_arr);
        $rtnarr = explode(":", $rtnarr[0]);
        $rtncd = $rtnarr[1];
        if(!($rtncd == 0000 || $rtncd == "0000")){
            echo $rtncd;
            exit;
        } 
	    $return_arr = smsSend($mtype2, $phone, $msg2, $callback, $upfile, $reservetime2, $subject2, $etc1, $etc2, $host_ip, $smsid, $pass, $reserve_chk);
        $rtnarr = explode("|", $return_arr);
        $rtnarr = explode(":", $rtnarr[0]);
        $rtncd = $rtnarr[1];
        if(!($rtncd == 0000 || $rtncd == "0000")){
            echo $rtncd;
            exit;
        } 
    } else {
        echo 9999;
    }

// 카카오톡아이디 검색 안될 때 확인 문자
} else if($inc == "chk"){
    $reserve_chk	= "N";
    $mtype = "mms";
    $msg = "(발신전용)안녕하세요. ".$name."님. 무료체험을 위해 등록해주신 카카오톡 ID가 검색이 되지 않습니다. 검색 설정을 변경하시거나 새로운 ID를 생성하신 후 \"성함과 ID를 함께\" 아래의 링크로 회신해주세요 :) 

■ 성함과 ID 회신하는 곳
https://goo.gl/iNxzIG 
■ 카톡ID 설정하는법
http://goo.gl/uR8w6Z
";
    $subject = "[텔라]무료체험 안내";

    if($send_ok=="y")
    {
	    include_once($_SERVER['DOCUMENT_ROOT']."/home/sms/api.php");
	    /*****************************************************************
	    *사용자 정보 변수
	    *****************************************************************/
	    $smsid	= "tella";			// sms 아이디 입력
	    $pass		= "Pwhoza@2015";		// 비밀번호 입력
	    $host_ip = "agent1.kssms.kr";

	    /*****************************************************************
	    * 리턴값 - code:0000|msg:등록성공|count:1|type:sms|etc1:value1|etc2:value2
	    *****************************************************************/
	    $return_arr = smsSend($mtype, $phone, $msg, $callback, $upfile, $reservetime, $subject, $etc1, $etc2, $host_ip, $smsid, $pass, $reserve_chk);
        $rtnarr = explode("|", $return_arr);
        $rtnarr = explode(":", $rtnarr[0]);
        $rtncd = $rtnarr[1];
        if(!($rtncd == 0000 || $rtncd == "0000")){
            echo $rtncd;
            exit;
        } 
    } else {
        echo 9999;
    }

// 미체험자 문자발송
} else if($inc == "chk0"){
    $reserve_chk	= "N";
    $mtype = "mms";
    $msg = $name."님, 텔라입니다. 무료체험 진행이 어려우셨나봅니다. 혹 다른 시간에 무료체험을 다시 받기를 원하신다면 아래의 링크에서 무료 체험을 다시 받아보실 수 있도록 도와드리겠습니다.

■ 무료체험 재신청 바로가기
http://goo.gl/pCXOrt
■ 텔라와 실시간 상담하기
https://goo.gl/iNxzIG 
";
    $subject = "[텔라]무료체험 재신청안내";

    if($send_ok=="y")
    {
	    include_once($_SERVER['DOCUMENT_ROOT']."/home/sms/api.php");
	    /*****************************************************************
	    *사용자 정보 변수
	    *****************************************************************/
	    $smsid	= "tella";			// sms 아이디 입력
	    $pass		= "Pwhoza@2015";		// 비밀번호 입력
	    $host_ip = "agent1.kssms.kr";

	    /*****************************************************************
	    * 리턴값 - code:0000|msg:등록성공|count:1|type:sms|etc1:value1|etc2:value2
	    *****************************************************************/
	    $return_arr = smsSend($mtype, $phone, $msg, $callback, $upfile, $reservetime, $subject, $etc1, $etc2, $host_ip, $smsid, $pass, $reserve_chk);
        $rtnarr = explode("|", $return_arr);
        $rtnarr = explode(":", $rtnarr[0]);
        $rtncd = $rtnarr[1];
        if(!($rtncd == 0000 || $rtncd == "0000")){
            echo $rtncd;
            exit;
        } 
    } else {
        echo 9999;
    }

// 실체험자(진체험자 제외) 문자발송
} else if($inc == "chk1"){
    $reserve_chk	= "N";
    $mtype = "mms";
    $msg = $name."님, 텔라입니다. 무료체험 진행이 어려우셨나봅니다. 혹 다른 시간에 무료체험을 다시 받기를 원하신다면 아래의 링크에서 무료 체험을 다시 받아보실 수 있도록 도와드리겠습니다.

■ 무료체험 재신청 바로가기
http://goo.gl/pCXOrt
■ 텔라와 실시간 상담하기
https://goo.gl/iNxzIG 
";
    $subject = "[텔라]무료체험 재신청안내";

    if($send_ok=="y")
    {
	    include_once($_SERVER['DOCUMENT_ROOT']."/home/sms/api.php");
	    /*****************************************************************
	    *사용자 정보 변수
	    *****************************************************************/
	    $smsid	= "tella";			// sms 아이디 입력
	    $pass		= "Pwhoza@2015";		// 비밀번호 입력
	    $host_ip = "agent1.kssms.kr";

	    /*****************************************************************
	    * 리턴값 - code:0000|msg:등록성공|count:1|type:sms|etc1:value1|etc2:value2
	    *****************************************************************/
	    $return_arr = smsSend($mtype, $phone, $msg, $callback, $upfile, $reservetime, $subject, $etc1, $etc2, $host_ip, $smsid, $pass, $reserve_chk);
        $rtnarr = explode("|", $return_arr);
        $rtnarr = explode(":", $rtnarr[0]);
        $rtncd = $rtnarr[1];
        if(!($rtncd == 0000 || $rtncd == "0000")){
            echo $rtncd;
            exit;
        } 
    } else {
        echo 9999;
    }

// 진체험자 문자발송
} else if($inc == "chk2"){
    $reserve_chk	= "N";
    $mtype = "mms";
    $msg = $name."님, 텔라입니다. 무료체험은 잘 받아보셨나요? 지금 홈페이지(http://tella.co.kr )로 가시면, 회원가입 즉시 10%할인쿠폰이 지급됩니다! 
수업 관련하여 궁금하신 사항이 있으시면, 아래 링크를 통해 텔라 고객센터로 문의해주세요!  

■ 텔라와 실시간 상담하기
https://goo.gl/iNxzIG 
";
    $subject = "[텔라] 무료체험 잘 받아보셨나요?";

    if($send_ok=="y")
    {
	    include_once($_SERVER['DOCUMENT_ROOT']."/home/sms/api.php");
	    /*****************************************************************
	    *사용자 정보 변수
	    *****************************************************************/
	    $smsid	= "tella";			// sms 아이디 입력
	    $pass		= "Pwhoza@2015";		// 비밀번호 입력
	    $host_ip = "agent1.kssms.kr";

	    /*****************************************************************
	    * 리턴값 - code:0000|msg:등록성공|count:1|type:sms|etc1:value1|etc2:value2
	    *****************************************************************/
	    $return_arr = smsSend($mtype, $phone, $msg, $callback, $upfile, $reservetime, $subject, $etc1, $etc2, $host_ip, $smsid, $pass, $reserve_chk);
        $rtnarr = explode("|", $return_arr);
        $rtnarr = explode(":", $rtnarr[0]);
        $rtncd = $rtnarr[1];
        if(!($rtncd == 0000 || $rtncd == "0000")){
            echo $rtncd;
            exit;
        } 
    } else {
        echo 9999;
    }

} else{
    echo 9999;
}

?>