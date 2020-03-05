<?php
//require_once ('./classe/log.php');
//require_once ('./classe/enum/enumtipoturno.php');
//session_start();

class Fechamento {
    private $id;
    private $data_inicial;
    private $data_final;
    private $turno;
    private $tipo;
    private $observacao;
    
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
            ' Data Inicial:'.FuncaoData::formatoData($this->data_inicial).
            ' Data Final:'.FuncaoData::formatoData($this->data_final).
            ' Turno:'.$this->turno.
            ' Observacao:'.$this->observacao
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id_fechamento, data_inicial, data_final, turno, tipo, observacao from fechamento where id_fechamento = :param_id";
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
            $cmd = "select id_fechamento, data_inicial, data_final, turno, tipo, observacao from fechamento";
            if (!is_null($filtro) || !empty($filtro)) {
                $cmd.=' where '.$filtro;
            }
            if ($limite_inicial>0 || $limite_final>0) {
                $cmd.=' order by id_fechamento DESC LIMIT '.$limite_inicial.','.$limite_final;
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
            $this->id = $dados['id_fechamento'];
            $this->data_inicial = $dados['data_inicial'];
            $this->data_final = $dados['data_final'];
            $this->turno = $dados['turno'];
            $this->tipo = $dados['tipo'];
            $this->observacao = FuncaoBanco::removeAcento($dados['observacao']);
            
            $cmd = "insert into fechamento (data_inicial, data_final, turno, tipo, observacao) ".
                " values (:param_data_inicial, :param_data_final, :param_turno, :param_tipo, :param_observacao)";
            
            //echo "COMANDO:".$cmd;
            $stm = $this->conexao->conectar()->prepare($cmd);
            //$stm->bindParam(":param_id_faltas", 2019091983, PDO::PARAM_INT);
            $stm->bindParam(":param_data_inicial", $this->data_inicial, PDO::PARAM_STR);
            $stm->bindParam(":param_data_final", $this->data_final, PDO::PARAM_STR);
            $stm->bindParam(":param_turno", $this->turno, PDO::PARAM_INT);
            $stm->bindParam(":param_tipo", $this->tipo, PDO::PARAM_INT);
            $stm->bindParam(":param_observacao", $this->observacao, PDO::PARAM_STR);
            
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
            $this->id = $dados['id_fechamento'];
            $this->data_inicial = $dados['data_inicial'];
            $this->data_final = $dados['data_final'];
            $this->turno = $dados['turno'];
            $this->tipo = $dados['tipo'];
            $this->observacao = FuncaoBanco::removeAcento($dados['observacao']);
            
            $cmd = "update fechamento set data_inicial=:param_data_inicial, data_final=:param_data_final, ".
                " turno=:param_turno, tipo=:param_tipo, observacao=:param_observacao where id_fechamento = :param_id_fechamento";
            //echo "COMANDO:".$cmd;
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id_fechamento", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_data_inicial", $this->data_inicial, PDO::PARAM_STR);
            $stm->bindParam(":param_data_final", $this->data_final, PDO::PARAM_STR);
            $stm->bindParam(":param_turno", $this->turno, PDO::PARAM_INT);
            $stm->bindParam(":param_tipo", $this->tipo, PDO::PARAM_INT);
            $stm->bindParam(":param_observacao", $this->observacao, PDO::PARAM_STR);
            
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
            $cmd = "delete from fechamento where id_fechamento = :param_id";
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
            $cmd = "delete from fechamento";
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
    
    public function getValidaApont ($data, int $turno) {
        try {
            $cmd = "select data_inicial, data_final, turno from fechamento ".
                   " where :param_data between data_inicial and data_final".
                   "   and (tipo = 1 or tipo = 9)".
                   "   and (turno = :param_turno or turno = 9)";

            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_data", $data, PDO::PARAM_STR);
            $stm->bindParam(":param_turno", $turno, PDO::PARAM_INT);
            $stm->execute();
            
            return $stm->fetch();
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    public function getValidaJustif ($data_inicial, $data_final, int $turno) {
        try {
            $cmd = "select data_inicial, data_final, turno from fechamento ".
                " where ((:param_data_inicial >= data_inicial and :param_data_inicial <= data_final) ".
                "    or (:param_data_final >= data_inicial and :param_data_final <= data_final)) ".
                "   and (tipo = 2 or tipo = 9)".
                "   and (turno = :param_turno or turno = 9)";
            
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_data_inicial", $data_inicial, PDO::PARAM_STR);
            $stm->bindParam(":param_data_final", $data_final, PDO::PARAM_STR);
            $stm->bindParam(":param_turno", $turno, PDO::PARAM_INT);
            $stm->execute();
            
            return $stm->fetch();
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
}

?>