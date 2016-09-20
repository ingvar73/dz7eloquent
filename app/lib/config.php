<?php 
$__smtp = array(
    "host" => 'smtp.mail.ru', // SMTP сервер
    "debug" => 0, // Уровень логирования
    "auth" => true, // Авторизация на сервере SMTP. Если ее нет - false
    "port" => '465', // Порт SMTP сервера
    "username" => 'loftschooltest@mail.ru', // Логин запрашиваемый при авторизации на SMTP сервере
    "password" => 'Gosha37', // Пароль
    "addreply" => 'ingvar73@yandex.ru', // Почта для ответа
    "secure" => 'ssl', // Тип шифрования. Например ssl или tls
    "mail_title" => 'Письмо с сайта http://dz06.loftschool/ о регистрации нового пользователя!', // Заголовок письма
    "mail_name" => 'Loftschool' // Имя отправителя
); 
?>