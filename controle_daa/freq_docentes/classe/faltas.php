<?php
//require_once ('./classe/log.php');
//session_start();

class Faltas {
    private $id;
    private $data;
    private $turno;
    private $professor;
    private $horario1;
    private $horario2;
    private $horario3;
    private $horario4;
    private $horario5;
    private $horario6;
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
            ' Data:'.FuncaoData::formatoData($this->data).
            ' Turno:'.$this->turno.
            ' Professor:'.$this->professor.
            ' Horario 1:'.$this->horario1.
            ' Horario 2:'.$this->horario2.
            ' Horario 3:'.$this->horario3.
            ' Horario 4:'.$this->horario4.
            ' Horario 5:'.$this->horario5.
            ' Horario 6:'.$this->horario6.
            ' Observacao:'.$this->observacao
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id_faltas, data, turno, id_professor, horario_1, horario_2, horario_3, horario_4, horario_5, horario_6, observacao from faltas where id_faltas = :param_id";
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
            $cmd = "select f.id_faltas, f.data, f.turno, f.id_professor, p.nome as procfessor, ".
                   "       f.horario_1, f.horario_2, f.horario_3, f.horario_4, ".
                   "       f.horario_5, f.horario_6, f.observacao ".
                   "  from faltas f, professor p".
                   "  where f.id_professor = p.id_professor ".
                   "    and data > (select max(data_final) from fechamento where tipo in (1,9)) ";
            
            if (!is_null($filtro) || !empty($filtro)) {
                $cmd.=' and '.$filtro;
            }
            if ($limite_inicial>0 || $limite_final>0) {
                $cmd.=' order by f.data DESC, p.nome, f.id_faltas desc LIMIT '.$limite_inicial.','.$limite_final;
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
            $this->id = $dados['id_faltas'];
            $this->data = $dados['data'];
            $this->turno = $dados['turno'];
            $this->professor = $dados['id_professor'];
            $this->horario1 = $dados['horario_1'];
            $this->horario2 = $dados['horario_2'];
            $this->horario3 = $dados['horario_3'];
            $this->horario4 = $dados['horario_4'];
            $this->horario5 = $dados['horario_5'];
            $this->horario6 = $dados['horario_6'];
            $this->observacao = FuncaoBanco::removeAcento($dados['observacao']);
            
            $cmd = "insert into faltas (data, turno, id_professor, horario_1, horario_2, ".
                            " horario_3, horario_4, horario_5, horario_6, observacao) ".
                   " values (:param_data, :param_turno, :param_id_professor, :param_horario_1, :param_horario_2, ".
                           " :param_horario_3, :param_horario_4, :param_horario_5, :param_horario_6, :param_observacao)";
            
            echo "COMANDO:".$cmd;
            $stm = $this->conexao->conectar()->prepare($cmd);
            //$stm->bindParam(":param_id_faltas", 2019091983, PDO::PARAM_INT);
            $stm->bindParam(":param_data", $this->data, PDO::PARAM_STR);
            $stm->bindParam(":param_turno", $this->turno, PDO::PARAM_INT);
            $stm->bindParam(":param_id_professor", $this->professor, PDO::PARAM_INT);
            $stm->bindParam(":param_horario_1", $this->horario1, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_2", $this->horario2, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_3", $this->horario3, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_4", $this->horario4, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_5", $this->horario5, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_6", $this->horario6, PDO::PARAM_STR);
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
            $this->id = $dados['id_faltas'];
            $this->data = $dados['data'];
            $this->turno = $dados['turno'];
            $this->professor = $dados['id_professor'];
            $this->horario1 = $dados['horario_1'];
            $this->horario2 = $dados['horario_2'];
            $this->horario3 = $dados['horario_3'];
            $this->horario4 = $dados['horario_4'];
            $this->horario5 = $dados['horario_5'];
            $this->horario6 = $dados['horario_6'];
            $this->observacao = FuncaoBanco::removeAcento($dados['observacao']);
            
            $cmd = "update faltas set data=:param_data, turno=:param_turno, id_professor=:param_id_professor, horario_1=:param_horario_1, horario_2=:param_horario_2, ".
                   " horario_3=:param_horario_3, horario_4=:param_horario_4, horario_5=:param_horario_5, horario_6=:param_horario_6, observacao=:param_observacao ".
                   " where id_faltas = :param_id_faltas";
            //echo "COMANDO:".$cmd;
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id_faltas", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_data", $this->data, PDO::PARAM_STR);
            $stm->bindParam(":param_turno", $this->turno, PDO::PARAM_INT);
            $stm->bindParam(":param_id_professor", $this->professor, PDO::PARAM_INT);
            $stm->bindParam(":param_horario_1", $this->horario1, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_2", $this->horario2, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_3", $this->horario3, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_4", $this->horario4, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_5", $this->horario5, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_6", $this->horario6, PDO::PARAM_STR);
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
            $cmd = "delete from faltas where id_faltas = :param_id";
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
            $cmd = "delete from faltas";
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