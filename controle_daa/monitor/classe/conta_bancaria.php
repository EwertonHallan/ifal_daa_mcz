<?php

Class Conta_Bancaria {
    private $id;
    private $id_monitor;
    private $banco;
    private $agencia;
    private $nome;
    private $conta;
    private $tipo;  // Poupanca ou Corrente 
    
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
    
    public function getNome($id) {
        $result = $this->querySelect($id);
        
        return $result['nome'];
    }
    
    public function __toString() {
        return ('ID:'.$this->id.
            ' Monitor:'.$this->id_monitor.
            ' Banco:'.$this->banco.
            ' Agencia:'.$this->agencia.
            ' Nome:'.$this->nome.
            ' Conta:'.$this->conta.
            ' Tipo:'.$this->tipo
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id, id_monitor, id_banco, agencia, nome, conta, tipo from conta_bancaria where id = :param_id";
            
            //echo 'query:'.$cmd.'<br>';
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
            $cmd = "select id, id_monitor, id_banco, agencia, nome, conta, tipo from conta_bancaria";
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
            $this->id = $dados['id'];
            $this->id_monitor = $dados['id_monitor'];
            $this->banco = $dados['id_banco'];
            $this->agencia = $dados['agencia'];
            $this->nome = FuncaoBanco::removeAcento($dados['nome']);
            $this->conta = $dados['conta'];
            $this->tipo = $dados['tipo'];
            
            $cmd = "insert into conta_bancaria (id_monitor, id_banco, agencia, nome, conta, tipo) ".
                   " values (:param_monitor, :param_banco, :param_agencia, :param_nome, :param_conta, :param_tipo)";
            
            //echo 'query:'.$cmd.'<br>';
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_monitor", $this->id_monitor, PDO::PARAM_INT);
            $stm->bindParam(":param_banco", $this->banco, PDO::PARAM_INT);
            $stm->bindParam(":param_agencia", $this->agencia, PDO::PARAM_STR);
            $stm->bindParam(":param_nome", $this->nome, PDO::PARAM_STR);
            $stm->bindParam(":param_conta", $this->conta, PDO::PARAM_STR);
            $stm->bindParam(":param_tipo", $this->tipo, PDO::PARAM_INT);
            
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
            $this->id = $dados['id'];
            $this->id_monitor = $dados['id_monitor'];
            $this->banco = $dados['id_banco'];
            $this->agencia = $dados['agencia'];
            $this->nome = FuncaoBanco::removeAcento($dados['nome']);
            $this->conta = $dados['conta'];
            $this->tipo = $dados['tipo'];
            
            $cmd = "update conta_bancaria set id_monitor = :param_monitor, id_banco=:param_banco, agencia=:param_agencia, ".
            " nome=:param_nome, conta=:param_conta, tipo=:param_tipo where id = :param_id";
            
            //echo 'query:'.$cmd.'<br>';
            
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_monitor", $this->id_monitor, PDO::PARAM_INT);
            $stm->bindParam(":param_banco", $this->banco, PDO::PARAM_INT);
            $stm->bindParam(":param_agencia", $this->agencia, PDO::PARAM_STR);
            $stm->bindParam(":param_nome", $this->nome, PDO::PARAM_STR);
            $stm->bindParam(":param_conta", $this->conta, PDO::PARAM_STR);
            $stm->bindParam(":param_tipo", $this->tipo, PDO::PARAM_INT);
            
            if ($stm->execute()) {
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
            $cmd = "delete from conta_bancaria where id = :param_id";
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
            $cmd = "delete from conta_bancaria";
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
    
    public function queryRelatorio ($comandoSQL) {
        try {
            if (!is_null($comandoSQL) || !empty($comandoSQL)) {
                $cmd = $comandoSQL;
                
                //echo 'query:'.$cmd.'<br>';
                $stm = $this->conexao->conectar()->prepare($cmd);
                $stm->execute();
                
                return $stm->fetchAll();
            } else {
                return FALSE;
            }
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
}

?>