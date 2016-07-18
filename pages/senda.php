<?
$send_ok		= $_POST["send_ok"];
$phone			= $_POST["phone"];
$mtype			= $_POST["mtype"];
$msg				= $_POST["msg"];
$callback		= $_POST["callback"];
$upfile			= $_POST["upfile"];
$reservetime	= $_POST["reservetime"];
$reserve_chk	= $_POST["reservetime_chk"];
$etc1				= $_POST["etc1"];
$etc2				= $_POST["etc2"];
$subject			= $_POST["subject"];

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
	//echo $return_arr;

    $rtnarr = explode("|", $return_arr);
    $rtnarr = explode(":", $rtnarr[0]);
    $rtncd = $rtnarr[1];
    //echo "<br/>rtncd: ".$rtncd;
    if(!($rtncd == 0000 || $rtncd == "0000")){
        echo "<script>alert('문자발송 실패<br/>에러코드: ".$rtncd."')</script>";

    } else{
        echo "<script>alert('문자발송 성공')</script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Morris Charts CSS -->

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
        <div class="col-lg-12">
            <h1 class="page-header" style="margin-top:20px;">미체험자 문자발송</h1>
        </div>                <!-- /.col-lg-12 -->
        <div class="col-lg-12" style="padding-bottom:10px;">
                    <!--
	        /*****************************************************************
	        * 전화번호 여러개를 보내려면 "," 를 사용 해서 전화번호를 등록 "-" 있어도 되고 없어도됨
	        * ex) <input name="phone" type="text" value="010-1234-5678,01012345678,01012345678" />

	        * <input name="mtype" type="text" value="sms" /> -> sms / mms 2가지로 보내야하며 sms 80byte, mms 2000byte 까지 보낼수 있고... 
	        * mms 타입에서 이미지가 없으면 자동으로 lms로 처리 이미지가 있으면 mms로 처리됨

	        * <textarea name="msg" rows="5"></textarea> -> 보낼 메세지
	        * <input name="callback" type="text" value="" /> -> 보낸사람 번호
	        * <input name="upfile" type="file" value="" /> -> 업로드 이미지(먼저 파일을 업로드 후 http://파일경로)

	        * <input name="reservetime" type="text" value="<?=date("Y-m-d H:i:s")?>" /> -> 빈값이면 예약없이 바로 등록
		        예약시간 설정 (2013-06-10 13:35:10) 형식으로 등록

	        * <input name="etc1" type="text" value="" /> -> 사용자 리턴 변수
	        * <input name="etc2" type="text" value="" /> -> 사용자 리턴 변수
	        * <input name="subject" type="text" value="" /> -> mms 타입으로 보낼때의 제목
	        *****************************************************************/
	        -->
	        <form name="form" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
		        <input name="send_ok" type="hidden" value="y" />
                <div class="form-group">
                    <label>발신번호</label>
                    <input name="callback" type="text" class="form-control" value="070-5118-9565" readonly />
                    <p class="help-block">발신번호 변경 요청은 개발단에 문의</p>
                </div>
		        <div class="form-group">
                            <label>수신번호</label>
                            <input name="phone" id="phone" type="text" class="form-control" value="" />
                            <p class="help-block">*전화번호 여러개를 보내려면 "," 를 사용 해서 전화번호를 등록 "-" 있어도 되고 없어도됨</p>
                        </div>
                        <div class="form-group">
                            <label>타입</label>
                            <select name="mtype" class="form-control">
                                <option value="sms">sms</option>
                                <option value="mms" selected>mms</option>
                            </select>
                            <p class="help-block">*sms 80byte, mms 2000byte</p>
                        </div>
                        <div class="form-group">
                            <label>lms 제목</label>
                            <input name="subject" type="text" class="form-control" value="[텔라]" />
                        </div>
                        <div class="form-group">
                            <label>내용</label>
                            <script>
                                function countlnt() {
                                    var string = document.form.msg.value; //테스트할 문자열
                                    // 문자열 초기화                                
                                    var stringLength = string.length;
                                    var stringByteLength = 0;


                                    // 일반적인 FOR문으로 문자열 BYTE 계산
                                    for (var i = 0; i < stringLength; i++) {
                                        if (escape(string.charAt(i)).length >= 4)
                                            stringByteLength += 3;
                                        else if (escape(string.charAt(i)) == "%A7")
                                            stringByteLength += 3;
                                        else
                                            if (escape(string.charAt(i)) != "%0D")
                                                stringByteLength++;
                                    }
                                    document.getElementById("cntlnt").innerHTML = stringByteLength;
                                }                                
                            </script>
                            <textarea name="msg" rows="10" class="form-control">

고객지원센터
■ 전화 : 070-5118-9565
■ 카톡 : tellakor
■ 메일 : tella@tella.co.kr

*회화의 시작은, 텔라 </textarea>
                        </div>
                        <div class="form-group">
                            <script type="text/javascript">
					    //<![CDATA[
						    function reserve_chk(obj)
						    {
							    var reserve = document.getElementById('reservetime');
							    if(obj.checked==true) reserve.disabled=false;
							    else reserve.disabled=true;
						    }
					    //]]>
                            </script>
                            <!--label>예약 <input name="reservetime_chk" id="reservetime_chk" type="checkbox" value="Y" onclick="reserve_chk(this)" /></label-->
                            <!--input name="reservetime" class="form-control" id="reservetime" type="text" value="" disabled="disabled" /-->
                        </div>
                        <input name="submit" type="submit" class="btn btn-default" value="메세지전송" />			        
	        </form>

        </div>  
    </div>
	<script>
        document.getElementById('phone').value = opener.document.getElementById('allHp').value;
    </script>
</body>
</html>