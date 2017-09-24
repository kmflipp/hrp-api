<?php
session_start();
define('IN_CFG', true);

include("mainfile.php");
include("language.php");

header('Access-Control-Allow-Origin: *');

function login($user_cn, $pwd) {
    global $db, $jwtKey;

    $sql=sprintf("SELECT * FROM isg_users INNER JOIN isg_users_details ON (isg_users_details.user_id=isg_users.id) WHERE `user_cn`='%s' and `status`=1 ",$user_cn);
    $rs=$db->sql_query($sql);
    $rc=$db->sql_numrows($rs);
    $res=$db->sql_fetchrow($rs);

    if (password_verify($pwd, $res['hash'])) {
        $tokenId    = base64_encode(random_bytes(32));
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;
        $expire     = $notBefore + 3600;

        $data = [
            'iat'  => $issuedAt,
            'jti'  => $tokenId,
            'nbf'  => $notBefore,
            'exp'  => $expire,
            'sig'  => $jwtKey,
            'data' => [
                'id'   => $res['isg_users.id'],
                'user_cn' => $user_cn,
                'user_name' => $res['user_name'],
                'user_surname' => $res['user_surname'],
            ]
        ];
        $secretKey = base64_decode($jwtKey);

        $jwt = JWT::encode(
            $data,
            $secretKey,
            'HS256'
        );

        $unencodedArray = ['jwt' => $jwt, 'user_name' => $res['user_name'], 'user_surname' => $res['user_surname'], 'user_cn' => $res['$user_cn']];
        return json_encode($unencodedArray);
    }else{
        $unencodedArray = ['jwt' => 'tokennotvalid'];
        return json_encode($unencodedArray);
    }
}


function logout($session,$param,$new_value) {
    global $db;

}


function send_email($subject,$to,$message){
    global $smtp, $smtp_port, $smtp_username, $smtp_password, $smtp_from;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPDebug = false;
        $mail->Debugoutput = 'html';
        $mail->Host = $smtp;
        $mail->Port = $smtp_port;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->setFrom($smtp_from, 'HR Personas Wizard');
        $mail->addAddress($to, 'Company');
        $mail->Subject = $subject;
        $mail->msgHTML("<b>" . $subject . "</b><br><br>" . $message);
        $mail->AltBody = $message;

        $mail->send();
        return "Message sent to ".$to;
    } catch (phpmailerException $e) {
        return $e->errorMessage();
    } catch (Exception $e) {
        return $e->getMessage();
    }
}


switch ($_POST[api]) {

    case "login":
        $json=login($_POST['username'],$_POST['password']);
        echo $json;
        break;

    default:
        echo "WSP API Support File: you don't need to be here. Attempt was logged!";
        break;
}
