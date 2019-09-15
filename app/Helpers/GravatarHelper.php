<?php
namespace App\Helpers;




class GravatarHelper{

//    public function getGratavar()
//    {
//
//    }

public static function  validate_gravatar($email){
    $hash = md5($email);
    $url = 'http://gravatar.com/avatar/'.$hash.'?id_404';
    $headers = @get_headers($url);
 if (!preg_match("|200|",$headers[0])){
     $has_valid_avatar = FALSE;
 }else{
     $has_valid_avatar = TRUE;
 }
 return $has_valid_avatar;
}

public static function  gravatar_image($email, $size,$d=""){
    $hash = md5($email);
    $image_url = 'http://gravatar.com/avatar/' .$hash. '?s='.$size.'&d='.$d;
    return $image_url;
}
}
