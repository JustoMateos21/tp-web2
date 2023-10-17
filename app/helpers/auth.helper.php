<?php

class AuthHelper {

    public static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($user) {
        AuthHelper::init();
        $_SESSION['USER_ID'] = $user->id;
        $_SESSION['USER_USER_NAME'] = $user->user_name; 
    }

    public static function logout() {
        AuthHelper::init();
        session_destroy();
    }

    public static function verify($nameController) {
        AuthHelper::init();
        //CHEQUEO QUE EL CONTROLLER QUE INVOCA EL METODO VERIFY NO SEA 'HOME' PARA HACER EL CONTROL DE SI EXISTE LA SESION
        //SI EL CONTROLLER SI ES 'HOME' NO HAGO EL CHEQUEO, YA QUE, DEBE PODER INGRESAR IGUAL.
        //ESTO LO HAGO POR CONFLICTOS CON LA MUESTRA DEL BOTON LOGIN/LOGOUT EN HOME CUANDO SI EXISTE UNA SESION.
        if($nameController != 'HOME'){
            if (!isset($_SESSION['USER_ID'])) {
                header('Location: ' . BASE_URL . 'login');
                die();
            }
        }
    }
}