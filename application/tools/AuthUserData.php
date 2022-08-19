<?php

include(APPPATH."/controllers/User.php");

class AuthUserData{

    private static function getData($data){
        $propertie = null;
        if(isset($_SESSION[$data])){
            if($_SESSION[$data]!=null){
              $propertie = $_SESSION[$data];
            }
          }else{
            try {
                session_start();
                $propertie = $_SESSION[$data];
            } catch (Exception $e) {
                echo $e->getMessage().'\n';
            }
          }
        return $propertie;
    }


    public static function getId(){
        if(AuthUserData::getData('user_id') != null){
            return AuthUserData::getData('user_id');
        }else{
            $sesion = new User();
            $sesion->logout();
        }
    }

    public static function getFullName(){
        if(AuthUserData::getData('full_name') != null){
            return AuthUserData::getData('full_name');
        }else{
            $sesion = new User();
            $sesion->logout();
        }
    }

    public static function permission($probable_author_id){
        return $probable_author_id == AuthUserData::getData('user_id');
    }

}
