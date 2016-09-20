<?php 
// Читаем настройки config
require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/phpmailer/PHPMailerAutoload.php');

try{
    $mail = new PHPMailer(true); // Создаем экземпляр класса PHPMailer

    $mail->IsSMTP(); // Указываем режим работы с SMTP сервером
    $mail->Host       = $__smtp['host'];  // Host SMTP сервера: ip или доменное имя
    $mail->SMTPDebug  = $__smtp['debug'];  // Уровень журнализации работы SMTP клиента PHPMailer
    $mail->SMTPAuth   = $__smtp['auth'];  // Наличие авторизации на SMTP сервере
    $mail->Port       = $__smtp['port'];  // Порт SMTP сервера
    $mail->SMTPSecure = $__smtp['secure'];  // Тип шифрования. Например ssl или tls
    $mail->CharSet="UTF-8";  // Кодировка обмена сообщениями с SMTP сервером
    $mail->Username   = $__smtp['username'];  // Имя пользователя на SMTP сервере
    $mail->Password   = $__smtp['password'];  // Пароль от учетной записи на SMTP сервере
    $mail->AddAddress('ingvar73@gmail.com', 'John Doe');  // Адресат почтового сообщения
    $mail->AddReplyTo($__smtp['addreply'], 'First Last');  // Альтернативный адрес для ответа
    $mail->SetFrom($__smtp['username'], $__smtp['mail_title']);  // Адресант почтового сообщения
    $mail->Subject = htmlspecialchars($__smtp['mail_title']);  // Тема письма
    $mail->MsgHTML('Текст сообщения!'); // Текст сообщения
    $mail->Send();
    return 1;
  }
 catch (phpmailerException $e) {
    return $e->errorMessage();
}

?>