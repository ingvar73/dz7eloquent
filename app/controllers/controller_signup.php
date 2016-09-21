<?php
//error_reporting(E_ALL);
require_once __DIR__.'/../components/Db.php';
//require_once __DIR__.'/../components/Upload.php';
//require_once __DIR__.'/../components/User_Upload_Image.php';
//require_once __DIR__.'/../components/class.upload.php';
//require_once 'vendor/verot/class.upload.php/src/class.upload.php';
require_once __DIR__.'/../models/model_redirect.php';
// Читаем настройки config для отправки письма
require_once(__DIR__.'/../lib/phpmailer/PHPMailerAutoload.php');
require_once (__DIR__.'/../lib/Session.php');
$dir_name = str_replace('\\', '/', dirname(__FILE__));
define ('ROOT', $dir_name);

require __DIR__."/../components/init.php";

class Controller_Signup extends Controller {
    //    function __construct()
//    {
//        $this->basePath = $_SERVER[ 'DOCUMENT_ROOT' ];
//    }

    public function action_index()
    {
        $this->view->generate('signup_view.twig', array(
            "title"=> "Регистрация на сайте"
        ));
    }

    public function action_register()
    {
//        $db = Db::getInstance();
        $user = new User();
        Session::init();
        if(isset($_POST['register'])){

            $secret = '6LceOQcUAAAAACNz7JEre1XXLMRzQGnBsUIMFqmD';
            $response = $_POST['g-recaptcha-response'];
            $remoteip = $_SERVER['REMOTE_ADDR'];
            $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
            $result_c = json_decode($url, TRUE);

            $gump = new GUMP();

            $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

            $gump->validation_rules(array(
                'login'    => 'required|alpha_numeric|max_len,100|min_len,5',
                'name'    => 'required|max_len,100|min_len,5',
                'age'    => 'required|max_numeric, 100|min_numeric, 10',
                'about'    => 'required|max_len,300|min_len,50',
                'password'    => 'required|max_len,100|min_len,6',
                'cpassword'    => 'required|max_len,100|min_len,6',
                'email'       => 'required|valid_email',
                'url' => 'valid_ip'
            ));

            $gump->filter_rules(array(
                'login' => 'trim|sanitize_string',
                'name' => 'trim|sanitize_string',
                'about' => 'trim|sanitize_string',
                'email'    => 'trim|sanitize_email',
                'age'   => 'trim|sanitize_numbers',
                'password' => 'trim',
                'cpassword' => 'trim',
                'url' => 'valid_ip'
            ));

            $validated_data = $gump->run($_POST);

            if($validated_data === false and $result_c['success'] !== 1) {
                echo $gump->get_readable_errors(true);
            } else {
                echo "<pre>";
                print_r($validated_data);
                $user->login = $_POST['login'];
                $user->email = $_POST['email'];
                $user->name = $_POST['name'];
                $user->age = $_POST['age'];
                $user->about = $_POST['about'];
                $user->password = $_POST['password'];
                $user->hash = md5(15);
                $user->url = $_SERVER['SERVER_NAME'];
                $cpassword = $_POST['cpassword'];
//            }
                if($user->password !== $cpassword){
                    exit('Пароли не совпадают!');
                } else
                {
                    $user->password = md5($user->password);
                }
                require_once __DIR__.'/../components/Upload.php';
                $user->avatar = $avatar;

                $check = User::where('login', $user->login)->count();

                if(!$check){
                    $user->save();
                }



//                Session::set($login, $user->login);
// отправка письма о регистрации
                try{
                    $mail = new PHPMailer(true); // Создаем экземпляр класса PHPMailer
                    require_once(__DIR__.'/../lib/config.php');
                    $mail->IsSMTP(); // Указываем режим работы с SMTP сервером
                    $mail->Host       = $__smtp['host'];  // Host SMTP сервера: ip или доменное имя
                    $mail->SMTPDebug  = $__smtp['debug'];  // Уровень журнализации работы SMTP клиента PHPMailer
                    $mail->SMTPAuth   = $__smtp['auth'];  // Наличие авторизации на SMTP сервере
                    $mail->Port       = $__smtp['port'];  // Порт SMTP сервера
                    $mail->SMTPSecure = $__smtp['secure'];  // Тип шифрования. Например ssl или tls
                    $mail->CharSet="UTF-8";  // Кодировка обмена сообщениями с SMTP сервером
                    $mail->Username   = $__smtp['username'];  // Имя пользователя на SMTP сервере
                    $mail->Password   = $__smtp['password'];  // Пароль от учетной записи на SMTP сервере
                    $mail->AddAddress($user->email, $user->login);  // Адресат почтового сообщения
                    $mail->AddReplyTo($__smtp['addreply'], 'First Last');  // Альтернативный адрес для ответа
                    $mail->SetFrom($__smtp['username'], $__smtp['mail_title']);  // Адресант почтового сообщения
                    $mail->Subject = htmlspecialchars($__smtp['mail_title']);  // Тема письма
                    $mail->MsgHTML('Спасибо за регистрацию на нашем сайте DZ7.LOFTSCHOOL. Ваш логин: '.$user->login.'  Для того чтобы войти в свой аккуант его нужно активировать.\n
Чтобы активировать ваш аккаунт, перейдите по ссылке:\n
http://dz7.loftschool/signup/activation/?id='.$user->id.'&hash='.$user->hash.'   С уважением, Администрация сайта'); // Текст сообщения
                    $mail->Send();
//                    return 1;
                    echo "<br>На Ваш E-mail выслано письмо с cсылкой, для активации вашего аккуанта. <br><a href='/'>Главная страница</a></p>";
                    return 1;
                }
                catch (phpmailerException $e) {
                    return $e->errorMessage();
                }


            }
        }
    }

    public function action_activation()
    {
        $id = $_GET['id'];
        $hash = $_GET['hash'];

        if ($id and $hash){
            $user = User::where('id', $id)->where('hash', $hash)->first();
            if ($user){
            $user->activate = true;
            $user->save();
            Model_Redirect::redirectToPage('login/');
            }
        } else
        {
            echo "Неверный код активации";
//            var_dump($_SESSION['id']);
//            Model_Redirect::redirectToPage('login/');
        }
    }
}