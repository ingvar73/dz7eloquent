<?php

/**
 * Created by PhpStorm.
 * User: ingvar73
 * Date: 10.09.2016
 * Time: 12:22
 */
class Model_Signup extends Model
{
    public $confirm_password;
    private $err=[];

    const H_PASSWORD_PATTERN = '/(?=^.{8,32}$)((?=.*\d)|(?=.*\W+))(?|[.\n])(?=.*[A-Z])(?=.[a-z]).*S/';
    const M_PASSWORD_PATTERN = '/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,30}/';
    const LOGIN_PATTERN = '/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/';
    const EMAIL_PATTERN = '/@/';
//    const AGE_PATTERN = '/^[0-9]{10,100}/';

    public function __construct($login, $email, $password, $confirm_password, $name, $age, $about)
    {
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
        $this->name = $name;
        $this->age = $age;
        $this->about = $about;
//        $this->avatar = $avatar;
        $this->date = date('d:m:y');
    }

    public function regex ($pattern, $field, $err){
        preg_match($pattern, $field) ? : $this->err[] = $err;
    }

    public function len ($min, $max, $variable, $err){
        !(mb_strlen($variable) > $max || mb_strlen($variable) < $min) ? : $this->err[] = $err;
    }

    public function min_max ($min, $max, $variable, $err){
        !($variable > $max || $variable < $min) ? : $this->err[] = $err;
    }

    public function quality ($one, $two, $err){
        $one == $two ? : $this->err[] = $err;
    }

    public function unique(array $row, $err){
        array_shift($row) == 0 ? : $this->err[] = $err;
    }

    public function getErrors (){
        return $this->err;
    }

    public function generateHash ($algo = PASSWORD_BCRYPT) {
        $this->password = password_hash($this->password, $algo);
    }

    public function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

//    public function verify_file($file, $err)
//    {
//        if    (!empty($file)) //проверяем, отправил    ли пользователь изображение
//        {
//            $file = trim($file);
//            return $file;
//        }
//        $file = 'upload/net-avatara.jpg';
//        $this->err[] = $err;
//        return $file;
//    }
}