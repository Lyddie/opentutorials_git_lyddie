<?
    include "{$_SERVER[DOCUMENT_ROOT]}/include/config.php";
    mysql_query("SET NAMES 'utf8'");

    // for random coupon number
	$arr_no=array("1","2","3","4","5","6","7","8","9","0");
	$arr_alphabet=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

    $inc = $_REQUEST['inc'];

    if($inc == "fin"){
        $idx = 0;   // COUPON[idx]
        $MemberId = $_POST[member_id];          // 쿠폰을 발급할 ID 들
        $COUPON_FROM = $_POST[coupon_from];     // 해당 종료일
        $COUPON_TO = date("Y-m-d", strtotime("+7 day $COUPON_FROM"));

        // 해당 날짜(d)의 쿠폰 조회
        $date = date_format(date_create($COUPON_FROM), "d");
        $sql = "SELECT idx FROM COUPON
                WHERE 
                    COUPON_NAME='재구매 할인쿠폰'
                    AND DATE_FORMAT(COUPON_FROM, '%d')='$date'
                ;";
        $result = mysql_query($sql, $dbconn) or die(mysql_error());
        $row = mysql_fetch_array($result);
        $idx = $row[idx];


        // proc: /bizadmin/coupon_write_ok.php 
        $query="UPDATE COUPON
				SET
					COUPON_FROM = '$COUPON_FROM'
					,COUPON_TO = '$COUPON_TO'
			  WHERE 
                    idx=$idx
				";
		$result=mysql_query($query,$dbconn) or die(msg_back("수정 쿼리문 오류"));	

		//쿠폰회원적용시( Gubun : special(지정회원), normal(미지정회원) )
		$query="DELETE FROM COUPON_MEMBER WHERE COUPON_idx IN ('$idx') ";
		$result=mysql_query($query,$dbconn) or die(msg_back("삭제 쿼리문 오류"));		

		$query="DELETE FROM COUPON_PUBLISH WHERE COUPON_idx IN ('$idx') ";
		$result=mysql_query($query,$dbconn) or die(msg_back("삭제 쿼리문 오류"));		

		for ( $i=0; $i<count($MemberId); $i++){

			 $str="";
			 // 쿠폰번호의 길이는 숫자+알파벳으로 16자
			 for ($Cnt=0; $Cnt<16; $Cnt++){

				  // 랜덤을 돌려 0 이면 숫자, 1 이면 알파벳 부여
				  if (rand(0,1)==0) $str.=$arr_no[rand(0,(count($arr_no)-1))];
				  else              $str.=$arr_alphabet[rand(0,(count($arr_alphabet)-1))];
			 }
			 
			 // 해당 번호가 DB 있는 중복번호인가 체크 
			 $query = "select count(idx) from COUPON_PUBLISH  where couponNO='".$str."'";
			 $result = mysql_query($query, $dbconn);
			 $col = mysql_fetch_row($result);

			 // 중복번호가 아니라면 DB 에 넣음 
			 if ($col[0]==0) {
				  $query = "insert into COUPON_PUBLISH  VALUES ('', '".$idx."', '".$str."' )"; 
				  $result = mysql_query($query,$dbconn) or die(msg_back("입력 쿼리문 오류"));
				  //echo $str."<br>";
				  $x++;
			 }
			 // 중복번호라면 다시
			 else continue;

			$query="INSERT INTO COUPON_MEMBER 
					   SET
						COUPON_idx='$idx'
						,MEMBER_ID = '$MemberId[$i]'
						,Gubun = 'special'
						,couponNO = '$str'
						,USE1 = 'N'
						,RegDate = now()
						,RegIP = '$_SERVER[REMOTE_ADDR]'
					  ";
			$result=mysql_query($query,$dbconn) or die(msg_back("입력 쿼리문 오류"));
		}

		if($result) echo "success";
		exit;


    } else{
        echo "fail";
        exit;
    }

?>