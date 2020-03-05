<?php
//require_once ('./classe/log.php');
//session_start();

class Atendimento {
    private $id;
    private $id_monitor;
    private $local;
    private $id_turno;
    private $horario_seg;
    private $horario_ter;
    private $horario_qua;
    private $horario_qui;
    private $horario_sex;
    private $carga_horario;
    
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
            ' Local:'.$this->local.
            ' Turno:'.$this->id_turno.
            ' Horario Segunda:'.$this->horario_seg.
            ' Horario Terca:'.$this->horario_ter.
            ' Horario Quarta:'.$this->horario_qua.
            ' Horario Quinta:'.$this->horario_qui.
            ' Horario Sexta:'.$this->horario_sex.
            ' Carga Horaria:'.$this->carga_horario
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id_atendimento, id_monitor, local, id_turno, horario_seg, horario_ter, ".
                "          horario_qua, horario_qui, horario_sex".
                "  from monitor_atendimento where id_atendimento = :param_id";
            
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
            $cmd = "select a.id_atendimento, a.id_monitor, m.nome, m.matricula, a.local, a.id_turno, a.horario_seg, a.horario_ter, ".
                "          a.horario_qua, a.horario_qui, a.horario_sex".
                "  from monitor_atendimento a, monitor m".
                " where a.id_monitor = m.id_monitor ";
            
            if (!is_null($filtro) || !empty($filtro)) {
                $cmd.=' and '.$filtro;
            }
            if ($limite_inicial>0 || $limite_final>0) {
                $cmd.=' order by m.nome LIMIT '.$limite_inicial.','.$limite_final;
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
            $this->id = $dados['id_atendimento'];
            $this->id_monitor = $dados['id_monitor'];
            $this->local = $dados['local'];
            $this->id_turno = $dados['id_turno'];
            $this->horario_seg = $dados['horario_seg'];
            $this->horario_ter = $dados['horario_ter'];
            $this->horario_qua = $dados['horario_qua'];
            $this->horario_qui = $dados['horario_qui'];
            $this->horario_sex = $dados['horario_sex'];
            
            $cmd = "insert into monitor_atendimento (id_monitor, local, id_turno, horario_seg, horario_ter, horario_qua, horario_qui, horario_sex) ".
                " values (:param_id_monitor, :param_local, :param_id_turno, :param_horario_seg, :param_horario_ter, :param_horario_qua, :param_horario_qui, :param_horario_sex)";
            
            echo 'query:'.$cmd.'<br>';
            $stm = $this->conexao->conectar()->prepare($cmd);
            //$stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_id_monitor", $this->id_monitor, PDO::PARAM_INT);
            $stm->bindParam(":param_local", $this->local, PDO::PARAM_STR);
            $stm->bindParam(":param_id_turno", $this->id_turno, PDO::PARAM_INT);
            $stm->bindParam(":param_horario_seg", $this->horario_seg, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_ter", $this->horario_ter, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_qua", $this->horario_qua, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_qui", $this->horario_qui, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_sex", $this->horario_sex, PDO::PARAM_STR);
            
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
            $this->id = $dados['id_atendimento'];
            $this->id_monitor = $dados['id_monitor'];
            $this->local = $dados['local'];
            $this->id_turno = $dados['id_turno'];
            $this->horario_seg = $dados['horario_seg'];
            $this->horario_ter = $dados['horario_ter'];
            $this->horario_qua = $dados['horario_qua'];
            $this->horario_qui = $dados['horario_qui'];
            $this->horario_sex = $dados['horario_sex'];
            
            $cmd = "update monitor_atendimento set id_monitor=:param_id_monitor, local=:param_local, id_turno=:param_id_turno, horario_seg=:param_horario_seg, ".
                " horario_ter=:param_horario_ter, horario_qua=:param_horario_qua, horario_qui=:param_horario_qui, horario_sex=:param_horario_sex ".
                " where id_atendimento = :param_id";
            
            echo 'query:'.$cmd.'<br>';
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_id_monitor", $this->id_monitor, PDO::PARAM_INT);
            $stm->bindParam(":param_local", $this->local, PDO::PARAM_STR);
            $stm->bindParam(":param_id_turno", $this->id_turno, PDO::PARAM_INT);
            $stm->bindParam(":param_horario_seg", $this->horario_seg, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_ter", $this->horario_ter, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_qua", $this->horario_qua, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_qui", $this->horario_qui, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_sex", $this->horario_sex, PDO::PARAM_STR);
            
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
            $cmd = "delete from monitor_atendimento where id_atendimento = :param_id";
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
            $cmd = "delete from monitor_atendimento";
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