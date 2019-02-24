<?php
namespace ConfBooker;

use \PHPMailer\PHPMailer\PHPMailer;
use Endroid\QrCode\QrCode;



class Email {
  private $mailer = null;
  function __construct() {
    $this->mailer = new PHPMailer;
    $this->mailer->CharSet = 'utf-8';
    $this->mailer->IsSMTP();
    $this->mailer->Host = 'smtp.jino.ru';                 // Specify main and backup server
    $this->mailer->Port = 587;                                    // Set the SMTP port
    $this->mailer->SMTPAuth = true;                               // Enable SMTP authentication
    $this->mailer->Username = 'conference@arkr.kg';                // SMTP username
    $this->mailer->Password = '6Sh_?Y39F24K';                  // SMTP password
    $this->mailer->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

    $this->mailer->From = 'conference@arkr.kg';
    $this->mailer->FromName = 'Ассоциация Радиологов КР';

    $this->mailer->IsHTML(true);                                  // Set email format to HTML


  }
  function sendInvitation($email, $name, $id, $isMember = true) {
    if(!$email)
      return false;

    $this->mailer->Subject = 'Приглашение на конференцию';
    $prefix = $isMember ? '1' : '2';
    $code = $prefix.str_pad($id, 5, "0", STR_PAD_LEFT);
    $qrCode = new QrCode($code);

    $this->mailer->addStringEmbeddedImage(
      $qrCode->writeString(), 
      'qr',
      'qr-code.png',
      PHPMailer::ENCODING_BASE64,
      'image/png'
    ); 
    $nonmembers = $isMember ? '' : 'Если вы не являетесь активным членом АРКР, участие в конференции платное, стоимость участия 1000 сом ( оплату можно произвести на стойке регистрации).
      <br/> Либо же вы можете стать членом АРКР ( вступительный и членский взнос 1000 сом) и участвовать на этом и последующих конгрессах бесплатно.<br/>';

    $this->mailer->Body    = <<<MAILBODY
Здравствуйте, $name
<h2>
Ваша регистрация прошла успешно.
</h2>
$nonmembers<br/>
Пожалуйста распечатайте пригласительное для предъявления на стойке регистрации. 
<br/>
<br/>
<table width="400" border="1" style="border: 1px solid #EEE">
  <tr><td style="font-weight:bold;font-size:14px;padding:5px;text-align:center;">
Ежегодный Международный Конгресс Радиологов
</td></tr>
  <tr><td style="font-size:48px;text-align:center;">
    <img src="cid:qr" alt="" />
    <br/>$code
  </td></tr>
</table>
<hr/>
<br/>
<strong>
Важно! 
</strong>
<br/>
Для получения сертификата (ФУВ), необходимо предоставить документы: 
<br/>
копия паспорта; копия диплома;сертификат о первичной специализации; заполнить форму#1 ФУВ. 

<br/>
<br/>
<strong>
Примечание! 
</strong>
<br/>
На стойке регистрации вы можете оплатить членские взносы за 2019 год. 
<br/>
<br/>

MAILBODY;

    $this->mailer->AltBody    = <<<MAILBODY
$name
Ваша регистрация прошла успешно.

Пожалуйста распечатайте пригласительное для предъявления на стойке регистрации. 

Важно! 
Для получения сертификата (ФУВ), необходимо предоставить документы: 
копия паспорта; копия диплома;сертификат о первичной специализации; заполнить форму#1 ФУВ. 

Примечание! 
На стойке регистрации вы можете оплатить членские взносы за 2019 год. 

MAILBODY;

    $this->mailer->AddAddress($email, $name);  // Add a recipient

    if(!$this->mailer->Send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $this->mailer->ErrorInfo;
      exit;
    }
  }
}
