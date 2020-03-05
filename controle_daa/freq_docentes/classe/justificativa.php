<?php
//require_once ('./classe/log.php');
//session_start();

class Justificativa {
    private $id;
    private $professor;
    private $data_inicio;
    private $data_termino;
    private $turno;
    private $justificativa;
    
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
            ' Professor:'.$this->professor.
            ' Data Inicio:'.FuncaoData::formatoData($this->data_inicio).
            ' Data Termino:'.FuncaoData::formatoData($this->data_termino).
            ' Turno:'.$this->turno.
            ' Justificativa:'.$this->justificativa
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id_justificativa, id_professor, dt_inicio, dt_termino, id_turno, justificativa from justificativa where id_justificativa = :param_id";
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
            $cmd = "select id_justificativa, id_professor, dt_inicio, dt_termino, id_turno, justificativa from justificativa";
            if (!is_null($filtro) || !empty($filtro)) {
                $cmd.=' where '.$filtro;
            }
            if ($limite_inicial>0 || $limite_final>0) {
                $cmd.=' order by id_justificativa DESC LIMIT '.$limite_inicial.','.$limite_final;
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
            $this->id = $dados['id_justificativa'];
            $this->professor = $dados['id_professor'];
            $this->data_inicio = $dados['dt_inicio'];
            $this->data_termino = $dados['dt_termino'];
            $this->turno = $dados['id_turno'];
            $this->justificativa = FuncaoBanco::removeAcento($dados['justificativa']);
            
            $cmd = "insert into justificativa (id_professor, dt_inicio, dt_termino, id_turno, justificativa) ".
                " values (:param_id_professor, :param_dt_inicio, :param_dt_termino, :param_id_turno, :param_justificativa)";
            
            echo "COMANDO:".$cmd;
            $stm = $this->conexao->conectar()->prepare($cmd);
            //$stm->bindParam(":param_id_justificativa", $this->id_justificativa, PDO::PARAM_INT);
            $stm->bindParam(":param_id_professor", $this->professor, PDO::PARAM_INT);
            $stm->bindParam(":param_dt_inicio", $this->data_inicio, PDO::PARAM_STR);
            $stm->bindParam(":param_dt_termino", $this->data_termino, PDO::PARAM_STR);
            $stm->bindParam(":param_id_turno", $this->turno, PDO::PARAM_INT);
            $stm->bindParam(":param_justificativa", $this->justificativa, PDO::PARAM_STR);
            
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
            $this->id = $dados['id_justificativa'];
            $this->professor = $dados['id_professor'];
            $this->data_inicio = $dados['dt_inicio'];
            $this->data_termino = $dados['dt_termino'];
            $this->turno = $dados['id_turno'];
            $this->justificativa = FuncaoBanco::removeAcento($dados['justificativa']);
            
            $cmd = "update justificativa set id_professor=:param_id_professor, dt_inicio=:param_dt_inicio, dt_termino=:param_dt_termino, ".
                " id_turno=:param_id_turno, justificativa=:param_justificativa where id_justificativa = :param_id_justificativa";
            //echo "COMANDO:".$cmd;
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id_justificativa", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_id_professor", $this->professor, PDO::PARAM_INT);
            $stm->bindParam(":param_dt_inicio", $this->data_inicio, PDO::PARAM_STR);
            $stm->bindParam(":param_dt_termino", $this->data_termino, PDO::PARAM_STR);
            $stm->bindParam(":param_id_turno", $this->turno, PDO::PARAM_INT);
            $stm->bindParam(":param_justificativa", $this->justificativa, PDO::PARAM_STR);
            
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
            $cmd = "delete from justificativa where id_justificativa = :param_id";
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
            $cmd = "delete from justificativa";
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
    
    public function checkJustificativa ($id_professor, $id_turno, $dia) {
        try {
            $cmd =  "select dt_inicio, dt_termino, justificativa from justificativa ";
            $cmd .= " where id_professor = :param_id_professor ";
            $cmd .= "   and (id_turno = :param_id_turno or id_turno = 9)";                
            $cmd .= "   and dt_inicio <= :param_data and dt_termino >= :param_data ";
            
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id_professor", $id_professor, PDO::PARAM_INT);
            $stm->bindParam(":param_id_turno", $id_turno, PDO::PARAM_INT);
            $stm->bindParam(":param_data", $dia, PDO::PARAM_STR);
            $stm->execute();

            return $stm->fetch();
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
        
    }
}

?>