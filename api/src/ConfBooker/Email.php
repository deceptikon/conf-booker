<?php
namespace ConfBooker;

use \PHPMailer\PHPMailer\PHPMailer;



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
    $this->mailer->Subject = 'Приглашение на конференцию';
    if ($isMember) {
      $this->mailer->Body    = <<<MAILBODY
Здравствуйте, $name
<h2>
Ваша регистрация прошла успешно.
</h2>
Пожалуйста распечатайте пригласительное для предъявления на стойке регистрации. 
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

И + код регистр Баркод или Qr код С ЭТИМ ПОКА ПРОБЛЕМА

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

И + код регистр Баркод или Qr код С ЭТИМ ПОКА ПРОБЛЕМА

MAILBODY;
    } else {
    
    }

    $this->mailer->AddAddress($email, $name);  // Add a recipient

    if(!$this->mailer->Send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
      exit;
    }
  }
}
