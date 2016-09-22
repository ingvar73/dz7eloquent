<?php
//use Intervention\Image\ImageManagerStatic as Image;

$dir = $_SERVER['DOCUMENT_ROOT'].'/upload/';
$dir_base = 'http://dz7.loftschool/upload/';
$pattern_img = '/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/';
$pattern_gif = '/[.](GIF)|(gif)$/';
$pattern_jpg = '/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/';
$pattern_png = '/[.](PNG)|(png)$/';

//Image::configure(array('driver' => 'imagick'));

if (!empty($_POST['avatar'])) //проверяем, отправил    ли пользователь изображение
{
    $avatar = $_POST['avatar'];
    $avatar = trim($avatar);
    if ($avatar =='' or empty($avatar)) {
        unset($fupload);// если переменная пуста, то удаляем ее
    }
}


if    ($_FILES['avatar'] == '')
{
    //если переменной не существует (пользователь не отправил    изображение),то присваиваем ему заранее приготовленную картинку с надписью    "нет аватара"
    $avatar = "http://dz7.loftschool/upload/net-avatara.jpg"; //нарисовать net-avatara.jpg или взять в исходниках
} else {
    // загружаем изображение пользователя
    // проверяем загружен ли аватар, елси нет то грузим пустой аватар
    if(preg_match($pattern_img, $_FILES['avatar']['name'])){
        $filename = $_FILES['avatar']['name'];
        $source = $_FILES['avatar']['tmp_name'];
        $target = $dir.$filename;

//        $image = Image::make($filename)->resize(480, 480);
//        var_dump($image->filename);

        move_uploaded_file($source, $target);
        if(preg_match($pattern_gif, $filename)){
            $im = imagecreatefromgif($dir.$filename); //создаем в формате GIF
        }
        if(preg_match($pattern_png, $filename)){
            $im = imagecreatefrompng($dir.$filename); //создаем в формате PNG
        }
        if(preg_match($pattern_jpg, $filename)){
            $im = imagecreatefromjpeg($dir.$filename); //создаем в формате JPG
        }



        // Создание изображение "Взято с сайта www.codenet.ru"
        $w = 450;
        $w_src = imagesx($im); //вычисляем ширину
        $h_src = imagesy($im); //вычисляем высоту
        $dest = imagecreatetruecolor($w, $w);
        if($w_src > $h_src)
            imagecopyresampled($dest, $im, 0, 0, round((max($w_src, $h_src) - min($w_src, $h_src))/2), 0, $w, $w, min($w_src, $h_src), min($w_src, $h_src));
        if($w_src < $h_src)
            imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, min($w_src,$h_src), min($w_src,$h_src));
        if($w_src == $h_src)
            imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src);
        $date = time();
        imagejpeg($dest, $dir.$date.".jpg");
        $avatar = $dir_base.$date.".jpg";
        $delfull = $dir.$filename;
        unlink($delfull);
    } else {
        exit("Аватар или изображение должно быть в формате <strong>JPG, GIF или PNG</strong>");
    }
}