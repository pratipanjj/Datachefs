<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="../assets/js/config.js"></script>

<?php
// $proxy = 'https://cors-anywhere.herokuapp.com/';
$proxy = 'https://corsproxy.io/?';

if(isset($_GET['code'])){ ?>
<script>
$(document).ready(function() {
    token();
})
</script>
<?php } ?>

<script>
function token() {
    // groupList("t-g205746sAQU5PEIIHEHPSAHQIRXL3PTDPFZ4ZHLW");
    $.ajax({
        url: 'https://corsproxy.io/?https://open.larksuite.com/open-apis/auth/v3/app_access_token/internal',
        type: "POST",
        data: {
            app_id: 'cli_a53226bbc6f8d00a',
            app_secret: '2JEEg4Yl5eFxoXvW4gXitcPj7zeMVwMj'
        },
        dataType: 'json',
        success: function(res) {
            getUID(res.app_access_token);
        }
    })

}

function getUID(token) {
    var code = '<?php echo $_GET['code'] ?>';

    var settings = {
        "url": "https://cors.eu.org/https://open.larksuite.com/open-apis/mina/v2/tokenLoginValidate",
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": "Bearer " + token, // a-$token
        },
        "data": "\r\n{\r\n     \"code\": \"" + code + "\"\r\n}", // get code on GET Url
    };

    $.ajax(settings).done(function(response) {
        getUserinfo(response.data.access_token);
    });
}

function getUserinfo(access_token) {
    var settings = {
        "url": "https://cors.eu.org/https://open.larksuite.com/open-apis/authen/v1/user_info",
        "method": "GET",
        "timeout": 0,
        "headers": {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": "Bearer " + access_token,
        }
    };

    $.ajax(settings).done(function(response) {
        console.log(response.data.employee_no);
        loginLark(response.data.employee_no);
    });
}

function loginLark(uid) {
    $.ajax({
        url: "../controller/auth.php",
        type: "POST",
        data: {
            code: uid,
        },
        dataType: "json",
        success: function(data) {
            if (data == 1) {
                location.href = 'index.php';
            } else {
                $("#std-login-error").html(' Username หรือ Password ผิดพลาด')
            }
        },
        error: function(data) {
            $("#std-login-error").html(data.fail);
        }
    });
}
</script>

<script src="../assets/vendor/libs/jquery/jquery.js">
</script>