<?php
require_once __DIR__.'/../components/Db.php';
class Model_User extends Model {

    public function get_data()
    {
        session_start();
        $db = Db::getInstance();


        if (!empty($_SESSION['login']) and !empty($_SESSION['password'])) {
            //если существует логин и пароль в сессиях, то проверяем их
            $login = $_SESSION['login'];
            $result = $db->query("SELECT id, login, email, name, age, about, avatar FROM users WHERE login='$login'");
            $myrow = $result->fetch_assoc();

        return array(
            array(
                "login" => $myrow['login'],
                "email" => $myrow['email'],
                "name" => $myrow['name'],
                "age" => $myrow['age'],
                "about" => $myrow['about'],
                "avatar" => $myrow['avatar'],
                )
            );
        }


    }

//    public function get_ajax()
//    {
//        ob_start();
//        if (isset($_POST) AND $_SERVER['REQUEST_METHOD'] == 'POST'){
//            $formats = array("jpg", "gif", "png");
//            $format = @end(explode(".", $_FILES['image']['name']));
//            if(in_array($format, $formats)){
//                if(is_uploaded_file($_FILES['image']['tmp_name'])){
//                    $dir = __DIR__."/../assets/template/js/upload/".$_FILES['image']['name']."_".rand(0, 99999).time().".".$format;
//                    if(move_uploaded_file($_FILES['image']['tmp_name'], $dir)){
//                        var_dump($dir);
//                        return $dir;
//                    } else {
//                        echo "Файл не загрузился ".$_FILES['image']['error'];
//                    }
//                }
//            } else {
//                echo "Выберите правильный формат файла";
//            }
//
//        }
//        ob_end_flush();
//    }

}