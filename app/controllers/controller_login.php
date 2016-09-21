<?php
require_once __DIR__.'/../components/Db.php';
require_once __DIR__.'/../models/model_redirect.php';
require_once __DIR__.'/../models/model_auth.php';
require __DIR__."/../components/init.php";
require __DIR__."/../lib/Session.php";

class Controller_Login extends Controller {
    public function action_index()
    {
        $this->view->generate('login_view.twig', array(
            "title"=> "Авторизация на сайте"
        ));
    }

    public function action_auth()
    {
//        $user = new User();

        if(isset($_POST['auth'])){
            Session::init();
            $secret = '6LceOQcUAAAAACNz7JEre1XXLMRzQGnBsUIMFqmD';
            $response = $_POST['g-recaptcha-response'];
            $remoteip = $_SERVER['REMOTE_ADDR'];
            $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
            $result_c = json_decode($url, TRUE);
//            var_dump($result_c['success']);

            $gump = new GUMP();

            $_POST = $gump->sanitize($_POST); // You don't have to sanitize, but it's safest to do so.

            $gump->validation_rules(array(
                'login'    => 'required|alpha_numeric|max_len,100|min_len,5',
                'password'    => 'required|max_len,100|min_len,6',
            ));

            $gump->filter_rules(array(
                'login' => 'trim|sanitize_string',
                'password' => 'trim',
            ));

            $validated_data = $gump->run($_POST);


                if ($validated_data === false and $result_c['success'] !== 1){
                    echo $gump->get_readable_errors(true);
                } else {
                    $login = $_POST['login'];
                    $password = md5($_POST['password']);

// Проверка логина и пароля на совпадение
                    $check = User::where('login', $login)->where('password', $password)->count();

                    if ($check){
                        $_SESSION['login'] = $login;
                        Model_Redirect::redirectToPage('user/');

                        //Все хорошо, переход на страницу пользователя
                    }

                }

        }
    }
}