<?php

Class Folha_Fechamento {
    private $id;
    private $id_folha;
    private $usuario;
    private $data;
    
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
        
        return $result['id_folha'];
    }
    
    public function __toString() {
        return ('ID:'.$this->id.
            ' Folha:'.$this->id_folha.
            ' Data:'.FuncaoData::formatoDataHora($this->data).
            ' Usuario:'.$this->usuario
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id, id_folha, usuario, data from folha_fechamento where id = :param_id";
            
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
            $cmd = "select id, id_folha, usuario, data from folha_fechamento";
            if (!is_null($filtro) || !empty($filtro)) {
                $cmd.=' where '.$filtro;
            }
            if ($limite_inicial>0 || $limite_final>0) {
                $cmd.=' order by id_folha desc LIMIT '.$limite_inicial.','.$limite_final;
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
            $this->id_folha = $dados['id_folha'];
            $this->usuario = FuncaoBanco::removeAcento($_SESSION['login']);
            $this->data = FuncaoBanco::data_horaAtual();
            
            $cmd = "insert into folha_fechamento (id_folha, usuario, data) ".
                " values (:param_id_folha, :param_usuario, :param_data)";
            
            //echo 'query:'.$cmd.'<br>'.$this->__toString();
            $stm = $this->conexao->conectar()->prepare($cmd);
            //$stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_id_folha", $this->id_folha, PDO::PARAM_INT);
            $stm->bindParam(":param_usuario", $this->usuario, PDO::PARAM_STR);
            $stm->bindParam(":param_data", $this->data, PDO::PARAM_STR);
            
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
            $this->id_folha = $dados['id_folha'];
            $this->usuario = FuncaoBanco::removeAcento($_SESSION['login']);
            $this->data = FuncaoBanco::data_horaAtual();
            
            $cmd = "update folha_fechamento set id_folha=:param_id_folha, usuario=:param_usuario, data=:param_data  ".
                "    where id = :param_id";
            
            //echo 'query:'.$cmd.'<br>';
            
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_id_folha", $this->id_folha, PDO::PARAM_INT);
            $stm->bindParam(":param_usuario", $this->usuario, PDO::PARAM_STR);
            $stm->bindParam(":param_data", $this->data, PDO::PARAM_STR);
            
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
            $cmd = "delete from folha_fechamento where id = :param_id";
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
            $cmd = "delete from folha_fechamento";
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