<?php 

require_once('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
$mail->CharSet = 'utf-8';

$name = $_POST['user_name'];
$email = $_POST['user_email'];
$message =$_POST['user_message'];

$mail->isSMTP();                                    
$mail->Host = 'smtp.yandex.ru';  																					
$mail->SMTPAuth = true;                              
$mail->Username = 'info.ur-kabinet@yandex.ru'; 
$mail->Password = '3tn6!MTl'; 
$mail->SMTPSecure = 'ssl';                         
$mail->Port =  465; 
$mail->setFrom('info.ur-kabinet@yandex.ru'); 
$mail->addAddress('megnik@yandex.ru');    
$mail->isHTML(true); 

$mail->Subject = 'Заявка с сайта ur-kabinet.ru';
$mail->Body    = '' .$name . ' оставил заявку.<br>Почта этого пользователя: ' .$email.'<br> Сообщение пользоваетля: '.$message;
$mail->AltBody = '';

if(!$mail->send()) {
    echo 'Error';
} else {
    header('location: thank-you.html');
}
    // ваш секретный ключ
    $secret = '--------------------';
    // однократное включение файла autoload.php (клиентская библиотека reCAPTCHA PHP)
    require_once (dirname(__FILE__).'/recaptcha/autoload.php');
    // если в массиве $_POST существует ключ g-recaptcha-response, то...
    if (isset($_POST['g-recaptcha-response'])) {
      // создать экземпляр службы recaptcha, используя секретный ключ
      $recaptcha = new \ReCaptcha\ReCaptcha($secret);
      // получить результат проверки кода recaptcha
      $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
      // если результат положительный, то...
      if ($resp->isSuccess()){
        // действия, если код captcha прошёл проверку
        //...
      } else {
        // иначе передать ошибку
        $errors = $resp->getErrorCodes();
        $data['error-captcha']=$errors;
        $data['msg']='Код капчи не прошёл проверку на сервере';
        $data['result']='error';
      }
     
    } else {
      //ошибка, не существует ассоциативный массив $_POST["send-message"]
      $data['result']='error';
    }
?>

