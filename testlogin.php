<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

    $(document).ready(function(){

        $.ajax({
            url: 'https://open.larksuite.com/open-apis/authen/v1/access_token',
            method: 'post',
            cors: true ,
            secure: true,
            headers: {
                'Authorization': 'Bearer t-g2051u9tE3MIER6LSWBDFH4UMWAOKZS5GFYN4LV7',
                'Access-Control-Allow-Origin': '*',
            },
            contentType: 'application/json',
            dataType : 'json',
            data: {
                        'code': '<?php echo $_REQUEST['code']; ?>',
                        'grant_type': 'authorization_code'
            },success : function(data){
                console.log(data);
            }
            }).done(function(response) {
                console.log(response);
            });
        })
    
</script>

<?php
// $code = $_REQUEST['code'];
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'https://open.larksuite.com/open-apis/authen/v1/access_token');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     'Content-Type: application/json',
//     'Authorization: Bearer t-g2051u9tE3MIER6LSWBDFH4UMWAOKZS5GFYN4LV7',
// ]);
// curl_setopt($ch, CURLOPT_POSTFIELDS, "{\n\t\"code\": ".$code."\",\n\t\"grant_type\": \"authorization_code\"\n}");

// $response = curl_exec($ch);

// curl_close($ch);
// $response =  json_encode($response); 
// var_dump($response);
// echo $response['msg'];
// echo $response['data']['en_name'];
// echo $code;
// echo '1';

// $curl = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL => 'https://open.larksuite.com/open-apis/authen/v1/access_token',//string ของ url ที่ต้องการ
//     CURLOPT_RETURNTRANSFER => true,//1,true ค่าเป็น 1 หมายถึง return ค่ากลับมาในรูป string
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,//เวลานานที่สุดที่ให้ curl ฟังก์ชันทำงาน
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'POST',
//     CURLOPT_POSTFIELDS => '{"grant_type": "authorization_code","code": "'.$_REQUEST['code'].'"}',//ข้อมูลที่จะส่งไป
//     CURLOPT_HTTPHEADER => array(
//         'Authorization: Bearer t-g2051u9tE3MIER6LSWBDFH4UMWAOKZS5GFYN4LV7',
//         'Content-Type: application/json'
//     ),//	array ที่เก็บค่า http header
// ));

// $response = curl_exec($curl);

// curl_close($curl);

// $data =  json_decode($response,true); 
