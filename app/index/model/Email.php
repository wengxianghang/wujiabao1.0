<?php
 namespace app\index\Model;

 use PHPMailer\PHPMailer\Exception;
 use think\Model;
 use PHPMailer\PHPMailer\PHPMailer;

 require_once '../extend/PHPMailer/src/PHPMailer.php';
 require_once '../extend/PHPMailer/src/Exception.php';
 require_once '../extend/PHPMailer/src/SMTP.php';
/**
 * Email 发送邮件类
 * sendEmail 发送方法
 * $email 收件邮箱号
*/
 class Email extends Model
 {
    public function sendEmail($email){

        require_once '../extend/PHPMailer/src/PHPMailer.php';
        require_once '../extend/PHPMailer/src/Exception.php';
        require_once '../extend/PHPMailer/src/SMTP.php';
        $mail=new PHPMailer();

        try {
            $mail->isSMTP();
            //开启阿里云的stmp服务做为发送验证码的服务端
            $mail->Host       = 'smtp.aliyun.com';
           // $mail->Port       = config('465');
            $mail->SMTPAuth   = true;
            $mail->CharSet = "UTF-8";
            $mail->Username   = 'cainiao_123456@aliyun.com';
            $mail->Password   = 'wxh123456';
            $mail->setFrom('cainiao_123456@aliyun.com', 'aliyun');

            //用户填写的Email的传到哪里作为客户端接收验证码
            $mail->addAddress($email, '1111');
            $mail->addReplyTo('cainiao_123456@aliyun.com', 'aliyun');

            $mail->isHTML(true);
            $mail->Subject = '无价宝注册账号验证码';
            $code=mt_rand(999,9999);
            $mail->Body   =$code ;

            $mail->send();
            return $code;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
 }