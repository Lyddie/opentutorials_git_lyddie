<?
function smsSend($mtype, $phone, $msg, $callback, $upfile, $reservetime, $subject, $etc1, $etc2, $host, $smsid, $pass, $reserve_chk)
{
	$find_str = '&';
	if(strpos($msg, $find_str) !== false) $msg = urlencode($msg);
	if(strpos($subject, $find_str) !== false) $subject = urlencode($subject);

	$param[] = "id=".$smsid;
	$param[] = "pass=".$pass;
	$param[] = "type=".$mtype;
	$param[] = "reservetime=".$reservetime;
	$param[] = "reserve_chk=".$reserve_chk;
	$param[] = "phone=".$phone;
	$param[] = "callback=".$callback;
	$param[] = "msg=".$msg;
	$param[] = "upfile=".$upfile;
	$param[] = "subject=".$subject;
	$param[] = "etc1=".$etc1;
	$param[] = "etc2=".$etc2;
	$str_param = implode("&", $param);

	$path = ($mtype == "mms")? "/proc/RemoteMms.html": "/proc/RemoteSms.html";

	$fp = @fsockopen($host,80,$errno,$errstr,30);
	$return = "";

	if(!$fp) die($_err.$errstr.$errno);
	else
	{
		fputs($fp, "POST ".$path." HTTP/1.1\r\n");
		fputs($fp, "Host: ".$host."\r\n");
		fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		fputs($fp, "Content-length: ".strlen($str_param)."\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $str_param."\r\n\r\n");
		while(!feof($fp)) $return .= fgets($fp, 4096);
	}
	fclose ($fp);

	$temp_array = explode("\r\n\r\n", $return);
	$sms_data = $temp_array[1];

	return $sms_data;
}
?>