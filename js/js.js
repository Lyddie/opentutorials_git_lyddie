
// enter key pressed
function onKeyDown(url) {
    if (event.keyCode == 13) {
        if (url == 'mem_info') {
            // custom8.html
            kkdinfo();
        } else {
            // custom2.html & custom3.html
            stuinfo();
        }
    }
}

// ../pages/stat0.html 정보업데이트
function dbupdate() {
    var f = document.myform;
    f.mode.value = "update";
    $("form[name='myform']").submit();

}
// ../pages/stat0.html 수업연기요청
function createHolding() {
    var f = document.myform;
    var datestr = makeDateStr(f.holding_date.value);
    $.ajax({
        url: '../ajax/stuinfo.php?inc=holding_crt',
        async: false,
        type: 'POST',
        data: $(f).serialize(),
        success: function (data) {
            if (data == 'success_crt') {
                var msg = datestr + '의 수업연기 요청이 승인되셨습니다.';
                postponeSMS(-1, msg);
            } else {
                alert('수업연기를 실패하였습니다.\nERROR MSG: ' + data);
            }
        }
    });
}

// 미체험자 문자발송
function sendSMSchk0(idx, name, hp) {
    $.ajax({
        url: '../pages/trial_sms.php?inc=chk0',
        async: false,
        type: 'POST',
        data: {
            name: name
            , hp: hp
        },
        success: function (data) {
            console.log('data: ' + data);
            if (data == 0000 || data == '0000') {
                sendSMSsuccess(idx, 'chk0');
                alert('SMS가 성공적으로 발송되었습니다!');
                location.reload();
            } else {
                alert('SMS 발송이 실패하였습니다.\n에러코드: ' + data);
            }
        }
    });
}

// 실체험자(진체험자 제외) 문자발송
function sendSMSchk1(idx, name, hp) {
    $.ajax({
        url: '../pages/trial_sms.php?inc=chk1',
        async: false,
        type: 'POST',
        data: {
            name: name
            , hp: hp
        },
        success: function (data) {
            console.log('data: ' + data);
            if (data == 0000 || data == '0000') {
                sendSMSsuccess(idx, 'chk1');
                alert('SMS가 성공적으로 발송되었습니다!');
                location.reload();
            } else {
                alert('SMS 발송이 실패하였습니다.\n에러코드: ' + data);
            }
        }
    });
}

// 진체험자 문자발송
function sendSMSchk2(idx, name, hp) {
    $.ajax({
        url: '../pages/trial_sms.php?inc=chk2',
        async: false,
        type: 'POST',
        data: {
            name: name
            , hp: hp
        },
        success: function (data) {
            console.log('data: ' + data);
            if (data == 0000 || data == '0000') {
                sendSMSsuccess(idx, 'chk2');
                alert('SMS가 성공적으로 발송되었습니다!');
                location.reload();
            } else {
                alert('SMS 발송이 실패하였습니다.\n에러코드: ' + data);
            }
        }
    });
}

// 무료체험자 중 결제자정보 업데이트
function applyQuery() {
    var date = document.getElementById('search_date').value;
    $.ajax({
        url: '../ajax/stuinfo.php?inc=apply',
        async: false,
        type: 'POST',
        data: { date: date },
        success: function (data) {
            console.log('data: ' + data);
            if (data == 0 || data == '0000') {
                location.reload();
            } else {
                alert('체험자정보 업데이트에 실패하였습니다.\n에러코드: ' + data);
            }
        }
    });
}


// 체험예약문자
function sendSMS(idx, name, hp, banTime, regDate) {
    $.ajax({
        url: '../pages/trial_sms.php?inc=rsv',
        async: false,
        type: 'POST',
        data: {
            name: name
            , hp: hp
            , banTime: banTime
            , regDate: regDate
        },
        success: function (data) {
            console.log('data: ' + data);
            if (data == 0000 || data == '0000') {
                sendSMSsuccess(idx, 'rsv');
                alert('SMS 발송이 성공적으로 예약되었습니다!');
                location.reload();
            } else {
                alert('SMS 발송예약이 실패하였습니다.\n에러코드: ' + data);
            }
        }
    });
}
// 카카오아이디 확인문자
function sendSMS_kkd(idx, name, hp) {
    var r = confirm('카톡아이디 확인 문자를 보내시겠습니까?');
    if (r == true) {
        $.ajax({
            url: '../pages/trial_sms.php?inc=chk',
            async: false,
            type: 'POST',
            data: {
                name: name
                , hp: hp
            },
            success: function (data) {
                console.log('data: ' + data);
                if (data == 0000 || data == '0000') {
                    sendSMSsuccess(idx, 'chk');
                    alert('SMS가 성공적으로 발송되었습니다!');
                    location.reload();
                } else {
                    alert('SMS 발송이 실패하였습니다.\n에러코드: ' + data);
                }
            }
        });
    } else {
        alert('문자 발송이 취소되었습니다.');
    }
}
// SMS 발송 성공
function sendSMSsuccess(idx, inc) {
    $.ajax({
        url: '../pages/trial_sms_success.php?inc=' + inc,
        async: false,
        type: 'POST',
        data: { idx: idx },
        success: function (data) {
            if (data == 0 || data == '0') {
            } else {
                alert('DB 저장 실패');
            }
        }
    });

}

// 캘린더등록 확인 버튼
function cal_chk(idx, inc) {
    $.ajax({
        url: '../ajax/stuinfo.php?inc=' + inc,
        async: false,
        type: 'POST',
        data: { idx: idx },
        success: function (data) {
            if (data == 0 || data == '0') {
                location.reload();
            } else {
                alert('DB 저장 실패');
            }
        }
    });
}

// custom2.html & custom3.html: 무료체험자 정보변경  
// custom8.html : 회원 카카오ID 변경
function openModal(idx, StuName, KakaoId, PhoneNo, RegDate_f, classtype, ApplyTime) {
    $('#idx').val(idx);
    $('#name').val(StuName);
    $('#kakaoid').val(KakaoId);
    $('#hp').val(PhoneNo);
    $('#trialdate').val(RegDate_f);
    $('#applytime').val(ApplyTime);
    if (classtype) document.getElementById('category' + classtype).checked = true;

    if (PhoneNo == 'MEM') {
        document.getElementById('myModalLabel').innerHTML = '회원 카톡ID 변경';

    } else if (PhoneNo == 'TL') {
        document.getElementById('myModalLabel').innerHTML = '튜터링 카톡ID 변경';
    }

    $('#myModal').modal('show');
}
// custom2.html & custom3.html: 무료체험자 정보변경  
function stuinfo() {
    var applytime = document.getElementById('applytime').value;
    var regex_time = /[0-9]{2}:[0-9]{2}/;

    if (regex_time.test(applytime) === true) {
        $.ajax({
            url: '../ajax/stuinfo.php?inc=trial',
            async: false,
            type: 'POST',
            data: $('form').serialize(),
            success: function (data) {
                console.log(data);
                if (data == 0 || data == '0') {
                    alert('Success!')
                    location.reload();

                } else {
                    alert('Faild');
                }
            }
        });

    } else {
        alert('시간을 00:00 형태로 입력해주세요.');
        $('#applytime').focus();
        return;
    }
}
// custom8.html : 회원 카카오ID 변경
function kkdinfo() {
    var newkakaoid = document.getElementById('newkakaoid').value;
    newkakaoid = newkakaoid.trim();
    if (newkakaoid != '') {
        $.ajax({
            url: '../ajax/stuinfo.php?inc=kkd',
            async: false,
            type: 'POST',
            data: $('form').serialize(),
            success: function (data) {
                console.log(data);
                if (data == 0 || data == '0') {
                    alert('Success!')
                    location.reload();

                } else {
                    alert('Faild!' + data);
                }
            }
        });

    } else {
        alert('변경할 카톡ID를 입력해주세요.');
        $('#newkakaoid').focus();
    }
}

// custom7.html - 종료학생 SMS
function finstuSMS(w, finDate) {
    // 문자보낼 Hp, Ban, name 값 가져오기
    var idobj = document.getElementsByClassName('id' + w);
    var hpobj = document.getElementsByClassName('hp' + w);
    var banobj = document.getElementsByClassName('ban' + w);
    var nameobj = document.getElementsByClassName('name' + w);
    var idarr = new Array();
    var hparr = new Array();
    var banarr = new Array();
    var namearr = new Array();
    for (var i = 0; i < hpobj.length; i++) {
        idarr.push(idobj[i].value);
        hparr.push(hpobj[i].value);
        banarr.push(banobj[i].value);
        namearr.push(nameobj[i].value);
    }
    // mms 전달값
    var send_ok = 'n';
    if (hpobj.length == banobj.length) send_ok = 'y';
    var mtype = 'mms';
    var subject = '[텔라] 수업 종료 안내';
    var reservetime = '';
    var reservetime_chk = 'N';
    var week = w[0];
    
    var r = confirm('종료예정 문자를 보내시겠습니까?');
    if (r == true) {
        // 쿠폰발송
        $.ajax({
            url: '../ajax/coupon.php?inc=fin',
            async: false,
            type: 'POST',
            data: {
                member_id: idarr
                , coupon_from: finDate
            },
            success: function (data) {
                console.log(data);
                if (data == 'success') {
                    // 문자보낼 함수에 값 전달
                    $.ajax({
                        url: '../ajax/sendSMS.php?inc=finstu',
                        async: false,
                        type: 'POST',
                        data: {
                            send_ok: send_ok
                            , mtype: mtype
                            , subject: subject
                            , reservetime: reservetime
                            , reservetime_chk: reservetime_chk
                            , namearr: namearr
                            , hparr: hparr
                            , banarr: banarr
                            , finDate: finDate
                            , week: week
                        },
                        success: function (data) {
                            console.log(data);
                            if (data == '') {
                                alert('Success!')
                                location.reload();

                            } else {
                                alert('Error!\n' + data);
                            }
                        }
                    });
                } else {
                    alert('Error: COUPON!\n' + data);
                }
            }
        });

        
    } else {
        alert('문자전송이 취소되었습니다.');
    }

}

// custom9.html 연기 요청 리스트
function postponeChk(mode, row) {
    var idx = document.getElementById('idx' + row).value;
    var date = document.getElementById('date' + row).value;
    var datestr = makeDateStr(date);
    $.ajax({
        url: '../ajax/stuinfo.php?inc=' + mode,
        async: false,
        type: 'POST',
        data: {idx: idx},
        success: function (data) {
            var msg = '';
            if (data == 'success_cfm') {
                msg = datestr + '의 수업연기 요청이 승인되셨습니다.';
                postponeSMS(row, msg);
            } else if (data == 'success_cancle') {
                msg = datestr + '의 수업연기 요청이 취소되셨습니다.';
                postponeSMS(row, msg);
            } else {
                alert('DB update error!');
                return false;
            }
        }
    });
}

// 연기 요청 답장 문자(sms)
function postponeSMS(row, msg) {
    var phone;
    if (row < 0) phone = $('#holdingHp').val();
    else phone = document.getElementById('hp' + row).value;

    $.ajax({
        url: '../ajax/sendSMS.php?inc=once',
        async: false,
        type: 'POST',
        data: {
            send_ok: 'y',
            phone: phone, 
            mtype: 'sms',
            msg: msg
        },
        success: function (data) {
            if (data == 0000 || data == '0000') {
                var href = window.location.href;
                var res = encodeURI(href);
                alert('Success!');
                location.href = res;
                
            } else {
                var href = window.location.href;
                var res = encodeURI(href);
                alert('SMS seding error!');
                location.href = res;
            }
        }
    });
}


// datestr
function makeDateStr(date) {
    var week = ['일', '월', '화', '수', '목', '금', '토'];
    var d = new Date(date);
    var datestr = d.getFullYear() + '년 ' + (d.getMonth() + 1) + '월 ' + d.getDate() + '일(' + week[d.getDay()] + ')';
    return datestr;
}