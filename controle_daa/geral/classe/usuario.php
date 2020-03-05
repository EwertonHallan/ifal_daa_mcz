<?php
//require_once ('log.php');
//session_start();

class Usuario {
    private $id;
    private $login;
    private $nome;
    private $senha;
    private $telefone;
    private $email;
    private $ativo;
    private $tipo;
    private $ultimo_acesso;
    
    private $log_evento;
    private $conexao;
    
    public function __construct() {
        $this->conexao = new Conexao();
        $this->log_evento = new Log();
    }
    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function __toString() {
        return ('ID:'.$this->id.
            ' LOGIN:'.$this->login.
            ' Nome:'.$this->nome.
            ' Senha:'.$this->senha.
            ' Telefone:'.$this->telefone.
            ' E-Mail:'.$this->email.
            ' Ativo:'.$this->ativo.
            ' Tipo:'.$this->tipo.
            ' Ultimo Acesso:'.$this->ultimo_acesso
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id_usuario, nome, login, senha, telefone, email, ativo, tipo, ultacesso from usuario where id_usuario = :param_id";
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $id, PDO::PARAM_INT);
            $stm->execute();
            
            return $stm->fetch();
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    public function querySelectAll ($filtro=NULL,$limite_inicial=0, $limite_final=0) {
        try {
            $cmd = "select id_usuario, nome, login, senha, telefone, email, ativo, tipo, ultacesso from usuario";
            if (!is_null($filtro) || !empty($filtro)) {
                $cmd.=' where '.$filtro;
            }
            if ($limite_inicial>0 || $limite_final>0) {
                $cmd.=' order by nome LIMIT '.$limite_inicial.','.$limite_final;
            }
            //echo 'query:'.$cmd.'<br>';
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->execute();
            
            return $stm->fetchAll();
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    public function queryInsert ($dados) {
        try {
            $this->id = $dados['id_usuario'];
            $this->nome = FuncaoBanco::removeAcento($dados['nome']);
            $this->login = FuncaoBanco::removeAcento($dados['login']);
            $this->senha = FuncaoBanco::encriptaMD5($dados['senha']);
            $this->telefone = $dados['telefone'];
            $this->email = $dados['email'];
            $this->ativo = $dados['ativo'];
            $this->tipo = $dados['tipo'];
            $this->ultimo_acesso = FuncaoBanco::dataAtual();
            
            $cmd = "insert into usuario (nome, login, senha, telefone, email, ativo, tipo, ultacesso) ".
                " values (:param_nome, :param_login, :param_senha, :param_telefone, :param_email, :param_ativo, :param_tipo, :param_ultacesso)";
            
            //echo "COMANDO:".$cmd;
            $stm = $this->conexao->conectar()->prepare($cmd);
            //$stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_nome", $this->nome, PDO::PARAM_STR);
            $stm->bindParam(":param_login", $this->login, PDO::PARAM_STR);
            $stm->bindParam(":param_senha", $this->senha, PDO::PARAM_STR);
            $stm->bindParam(":param_telefone", $this->telefone, PDO::PARAM_STR);
            $stm->bindParam(":param_email", $this->email, PDO::PARAM_STR);
            $stm->bindParam(":param_ativo", $this->ativo, PDO::PARAM_STR);
            $stm->bindParam(":param_tipo", $this->tipo, PDO::PARAM_INT);
            $stm->bindParam(":param_ultacesso", $this->ultimo_acesso, PDO::PARAM_STR);
            
            if ($stm->execute()) {
                $this->log_evento->queryInsert(
                    get_class($this),
                    'INSERT',
                    $cmd,
                    $this->__toString()
                    );
                return True;
            } else {
                return False;
            }
            
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    public function queryUpdate ($dados) {
        try {
            $this->id = $dados['id_usuario'];
            $this->nome = FuncaoBanco::removeAcento($dados['nome']);
            $this->login = FuncaoBanco::removeAcento($dados['login']);
            //$this->senha = FuncaoBanco::encriptaMD5($dados['senha']);
            $this->telefone = $dados['telefone'];
            $this->email = $dados['email'];
            $this->ativo = $dados['ativo'];
            $this->tipo = $dados['tipo'];
            $this->ultimo_acesso = FuncaoBanco::dataAtual();
            
            var_dump($dados);
            
            $cmd = "update usuario set nome=:param_nome, login=:param_login, telefone=:param_telefone, ".
                "      email=:param_email, ativo=:param_ativo, tipo=:param_tipo where id_usuario = :param_id";

            //echo "<br>COMANDO:".$cmd.'<br>';
            
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_nome", $this->nome, PDO::PARAM_STR);
            $stm->bindParam(":param_login", $this->login, PDO::PARAM_STR);
            //$stm->bindParam(":param_senha", $this->senha, PDO::PARAM_STR);
            $stm->bindParam(":param_telefone", $this->telefone, PDO::PARAM_STR);
            $stm->bindParam(":param_email", $this->email, PDO::PARAM_STR);
            $stm->bindParam(":param_ativo", $this->ativo, PDO::PARAM_STR);
            $stm->bindParam(":param_tipo", $this->tipo, PDO::PARAM_INT);
            
            if ($stm->execute()) {
                //echo "execotou...";
                $this->log_evento->queryInsert(
                    get_class($this),
                    'UPDATE',
                    $cmd,
                    $this->__toString()
                    );
                return True;
            } else {
                return False;
            }
            
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    public function queryDelete ($id) {
        try {
            $cmd = "delete from usuario where id_usuario = :param_id";
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $id, PDO::PARAM_INT);
            
            if ($stm->execute()) {
                $this->log_evento->queryInsert(
                    get_class($this),
                    'DELETE',
                    $cmd,
                    'ID:'.$id
                    );
                return True;
            } else {
                return False;
            }
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    public function queryDeleteAll () {
        try {
            $cmd = "delete from usuario";
            $stm = $this->conexao->conectar()->prepare($cmd);
            
            if ($stm->execute()) {
                $this->log_evento->queryInsert(
                    get_class($this),
                    'DELETE',
                    $cmd,
                    NULL
                    );
                return True;
            } else {
                return False;
            }
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    public function loginUsuario ($login, $senha) {
        try {
            $cmd = "select id_usuario, nome, email, ativo, tipo, ultacesso from usuario where login= :param_login and senha= :param_senha";
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_login", $login, PDO::PARAM_STR);
            $stm->bindParam(":param_senha", $senha, PDO::PARAM_STR);

            if ($stm->execute()) {                
                $this->log_evento->queryInsert(
                    get_class($this),
                    'LOGIN',
                    $cmd,
                    'Acesso ao sistema em '.FuncaoBanco::data_horaAtual().'.'
                    );
            }
            //echo 'resultado:'.strlen(trim($array_tst['nome'])).'<br>';
            return $stm->fetch();
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    public function UltimoAcesso ($id) {
        try {
            $this->id = $id;
            $this->ultimo_acesso = FuncaoBanco::data_horaAtual();
            
            $cmd = "update usuario set ultacesso=:param_ultacesso where id_usuario = :param_id";
            
            //echo "COMANDO:".$cmd;
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_ultacesso", $this->ultimo_acesso, PDO::PARAM_STR);
            
            if ($stm->execute()) {
                $this->log_evento->queryInsert(
                    get_class($this),
                    'ULTIMO ACESSO',
                    $cmd,
                    'ACESSO:'.$this->ultimo_acesso
                    );
                return True;
            } else {
                return False;
            }
            
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
}

?>