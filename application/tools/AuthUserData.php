<?php

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
        return AuthUserData::getData('user_id');
    }

    public static function getFullName(){
        return AuthUserData::getData('full_name');
    }

}
