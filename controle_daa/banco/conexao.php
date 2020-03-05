<?php
class Conexao {
    private $user = "root";
    private $senha = "";
    private $banco = "controle_daa";
    private $servidor = "localhost";  
    //private $servidor = "172.16.5.244";  // claudia
    //private $servidor = "172.16.26.146";  // ewerton
    private static $pdo;
    
    public function __contruct() {
        
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8; SET CHARACTER SET UTF8;
                                                SET character_set_connection=UTF8;
                                                SET character_set_client=UTF8;',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
    }
    
    public function teste_conectar() {
        try {
            if (is_null(self::$pdo)) {
                echo 'criando uma instancia<br>';
                self::$pdo = new PDO("mysql:host=".$this->servidor.";dbname=".$this->banco."", $this->user, $this->senha);
                echo 'instancia criada<br>';
                //self::$pdo = new PDO("mysql:host=localhost;dbname=biblioteca", $this->user, $this->senha);
            }
            return self::$pdo;
        } catch (PDOException $ex) {
            //throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            return 'Error:'.$ex->getCode()."-".$ex->getMessage();
        }
    }
    
    public function conectar () {
        try {
            if (!isset(self::$pdo)) {
                
                self::$pdo = new PDO('mysql:host='.$this->servidor.';
                    dbname='.$this->banco.'',
                    $this->user, 
                    $this->senha, 
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                self::$pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            }
            
            return self::$pdo;
        } catch (PDOException $ex) {
            //throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
            return 'Error:'.$ex->getCode()."-".$ex->getMessage();
        }
    }
}

 
/*
 https://www.youtube.com/watch?v=6HOodAa05ZE
 */

?>