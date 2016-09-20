<?php

/**
 * Created by PhpStorm.
 * User: ingvar73
 * Date: 16.09.2016
 * Time: 23:23
 */
class User_Upload_Image
{
    public function upload_user_image($file_tmp, $file_name, $file_ext){
        $file_path = 'upload/'.$file_name.substr(md5(time()), 0, 10).'.'.$file_ext;
        if(is_uploaded_file($file_tmp)){
            if (! move_uploaded_file($file_tmp, $file_path)){
                exit("Невозможно переместить файл в каталог назначения!");
            }
            return $file_path;
        } else {
            exit("Возможна атака через загрузку файлов!");
        }
    }
}