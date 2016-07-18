<?
    if($_SESSION["SESSION_MemberID"] > "" ){
    }  else{
        $urlenc = urlencode($_SERVER['PHP_SELF']);
        echo "
            <script>
                alert('관리자로 로그인 후 이용해주시기 바랍니다.');
                location.href='/bizadmin/login.php?path=$urlenc';
            </script>
            ";
    }
?>