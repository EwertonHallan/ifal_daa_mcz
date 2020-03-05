<?php

//$_SERVER['HTTP_HOST'].
//dirname($_SERVER['PHP_SELF'])
    
    function new_session () {
        session_start();
    }
    
    function destroy_session () {
        session_destroy();
    }
    
    function open_session ($nome) {
        session_start($nome);
    }
    
    function close_session ($nome) {
        session_unregister($nome);
    }
    
    function set_session ($nome,$valor) {
        $$nome = $valor;
        session_register($nome);
        return($valor);
    }
    
    function get_session ($nome) {
        return($$nome);
    }
    

?>