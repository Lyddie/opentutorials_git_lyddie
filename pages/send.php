우<?
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
	echo $return_arr;
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>sms api</title>
	<style>
		dl,dt,dd,input { font:9pt '돋움'; }
	</style>
</head>
<body>

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
		<dl>
			<dt>
				<dd>보내는사람 전화번호</dd>
				<dd><input name="callback" type="text" value="010-8936-2386" /></dd>
			</dt>
			<dt>
				<dd>받는사람 전화번호</dd>
				<dd><input name="phone" type="text" value="" /></dd>
			</dt>
			<dt>
				<dd>타입</dd>
				<dd>
					<select name="mtype">
						<option value="sms">sms</option>
						<option value="mms">mms</option>
					</select>
				</dd>
			</dt>
			<dt>
				<dd>lms 제목</dd>
				<dd><input name="subject" type="text" value="" /></dd>
			</dt>
			<dt>
				<dd>내용</dd>
				<dd><textarea name="msg" rows="5"></textarea></dd>
			</dt>
			<dt>
				<dd>이미지첨부</dd>
				<dd><input name="upfile" type="file" value="" /></dd>
			</dt>
			<dt>
				<dd>예약시간</dd>
				<dd>
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
					예약:<input name="reservetime_chk" id="reservetime_chk" type="checkbox" value="Y" onclick="reserve_chk(this)" />
					<input name="reservetime" id="reservetime" type="text" value="2013-07-22 13:40:00" disabled="disabled" />
				</dd>
			</dt>
			<dt>
				<dd>사용자변수1</dd>
				<dd><input name="etc1" type="text" value="" /></dd>
			</dt>
			<dt>
				<dd>사용자변수2</dd>
				<dd><input name="etc2" type="text" value="" /></dd>
			</dt>
			<dt>
				<dd><input name="submit" type="submit" value="메세지전송" style="border:0px solid #ff6600; background-color:#ff6600; color:#fff; padding:5px 10px;" /></dd>
			</dt>
		</dl>
	</form>

</body>
</html>
<?
}
?>