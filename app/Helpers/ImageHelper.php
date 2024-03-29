<?php
namespace App\Helpers;
use App\User;
use App\Helpers\GravatarHelper;

class ImageHelper{

    public static function  getUserImage($id){
        $user = User::find($id);
        $avatar_url = "";
        if (!is_null($user)){
            if ($user->avatar == NULL){
                // return the gravatar image
                if (GravatarHelper::validate_gravatar($user->email)){
                    $avatar_url = Gravatarhelper::gravatar_image($user->email,50);
                }else{
//                    $avatar_url = url('images/defaults/user.png');
                }
            }else{

                //return that image
//                $avatar_url = url('images/users/'.$user->avatar);
            }
        }else{
//            return redirect('/');
        }

        return $avatar_url;
    }

}
