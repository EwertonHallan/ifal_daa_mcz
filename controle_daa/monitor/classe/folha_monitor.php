<?php

Class Folha_Monitor {
    private $id;
    private $id_folha;
    private $id_monitor;
    private $monitor;
    private $id_orientador;
    private $orientador;
    private $id_curso;
    private $curso;
    private $turma;
    private $id_turno;
    private $turno;
    private $setor;
    private $horario_seg;
    private $horario_ter;
    private $horario_qua;
    private $horario_qui;
    private $horario_sex;
    private $qtde_faltas;
    private $qtde_justificada;
    
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
        
        return $result['monitor'];
    }
    
    public function __toString() {
        return ('ID:'.$this->id.
            ' Folha:'.$this->id_folha.
            ' Monitor:'.$this->id_monitor.'-'.$this->monitor.
            ' Orientador:'.$this->id_orientador.'-'.$this->orientador.
            ' Curso:'.$this->id_curso.'-'.$this->curso.
            ' Turma:'.$this->turma.
            ' Turno:'.$this->id_turno.'-'.$this->turno.         
            ' Setor:'.$this->setor.
            ' Hor. Segunda:'.$this->horario_seg.
            ' Hor. Terca:'.$this->horario_ter.
            ' Hor. Quarta:'.$this->horario_qua.
            ' Hor. Quinta:'.$this->horario_qui.
            ' Hor. Sexta:'.$this->horario_sex.
            ' Total de Faltas:'.$this->qtde_faltas.
            ' Total Justificada:'.$this->qtde_justificada
            );
    }
    
    public function querySelect ($id) {
        try {
            
            $cmd = "SELECT id, id_folha, id_monitor, monitor, id_orientador, orientador, id_curso, curso, turma,".
                "          id_turno, turno, setor, horario_seg, horario_ter, horario_qua, horario_qui,".
                "          horario_sex, qtde_faltas, qtde_justificada".
                "     FROM folha_monitor  where id = :param_id ";
            
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
            $cmd = "SELECT id, id_folha, id_monitor, monitor, id_orientador, orientador, id_curso, curso, turma,".
                "          qtde_faltas, qtde_justificada".
                "     FROM folha_monitor  ";
            if (!is_null($filtro) || !empty($filtro)) {
                $cmd.=' where '.$filtro;
            }
            if ($limite_inicial>0 || $limite_final>0) {
                $cmd.=' order by monitor LIMIT '.$limite_inicial.','.$limite_final;
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
            //$this->id = $dados['id'];
            $this->id_folha = $dados['id_folha'];
            $this->id_monitor = $dados['id_monitor'];
            $this->monitor = FuncaoBanco::removeAcento($dados['monitor']);
            $this->id_orientador = $dados['id_orientador'];
            $this->orientador = FuncaoBanco::removeAcento($dados['orientador']);
            $this->id_curso = $dados['id_curso'];
            $this->curso = FuncaoBanco::removeAcento($dados['curso']);
            $this->turma = FuncaoBanco::removeAcento($dados['turma']);
            $this->id_turno = $dados['id_turno'];
            $this->turno = FuncaoBanco::removeAcento($dados['turno']);
            $this->setor = FuncaoBanco::removeAcento($dados['setor']);
            $this->horario_seg = FuncaoBanco::removeAcento($dados['horario_seg']);
            $this->horario_ter = FuncaoBanco::removeAcento($dados['horario_ter']);
            $this->horario_qua = FuncaoBanco::removeAcento($dados['horario_qua']);
            $this->horario_qui = FuncaoBanco::removeAcento($dados['horario_qui']);
            $this->horario_sex = FuncaoBanco::removeAcento($dados['horario_sex']);           
            $this->qtde_faltas = $dados['qtde_faltas'];
            $this->qtde_justificada = $dados['qtde_justificada'];
            
            $cmd = "insert into folha_monitor (id_folha, id_monitor, monitor, id_orientador, orientador, id_curso, ".
                "          curso, turma, id_turno, turno, setor, horario_seg, horario_ter, horario_qua, ".
                "          horario_qui, horario_sex, qtde_faltas, qtde_justificada) ".
                " values (:param_id_folha, :param_id_monitor, :param_monitor, :param_id_orientador, :param_orientador, :param_id_curso,".
                "         :param_curso, :param_turma, :param_id_turno, :param_turno, :param_setor, :param_horario_seg, :param_horario_ter, ".
                "         :param_horario_qua, :param_horario_qui, :param_horario_sex, :param_qtde_faltas, :param_qtde_justificada)";
            
            //echo 'query:'.$cmd.'<br>';
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id_folha", $this->id_folha, PDO::PARAM_INT);
            $stm->bindParam(":param_id_monitor", $this->id_monitor, PDO::PARAM_INT);
            $stm->bindParam(":param_monitor", $this->monitor, PDO::PARAM_STR);
            $stm->bindParam(":param_id_orientador", $this->id_orientador, PDO::PARAM_INT);
            $stm->bindParam(":param_orientador", $this->orientador, PDO::PARAM_STR);
            $stm->bindParam(":param_id_curso", $this->id_curso, PDO::PARAM_INT);
            $stm->bindParam(":param_curso", $this->curso, PDO::PARAM_STR);
            $stm->bindParam(":param_turma", $this->turma, PDO::PARAM_STR);
            $stm->bindParam(":param_id_turno", $this->id_turno, PDO::PARAM_INT);
            $stm->bindParam(":param_turno", $this->turno, PDO::PARAM_STR);
            $stm->bindParam(":param_setor", $this->setor, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_seg", $this->horario_seg, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_ter", $this->horario_ter, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_qua", $this->horario_qua, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_qui", $this->horario_qui, PDO::PARAM_STR);
            $stm->bindParam(":param_horario_sex", $this->horario_sex, PDO::PARAM_STR);
            $stm->bindParam(":param_qtde_faltas", $this->qtde_faltas, PDO::PARAM_INT);
            $stm->bindParam(":param_qtde_justificada", $this->qtde_justificada, PDO::PARAM_INT);
            
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
            $this->qtde_faltas = $dados['qtde_faltas'];
            $this->qtde_justificada = $dados['qtde_justificada'];
            
            $cmd = "update folha_monitor set qtde_faltas=:param_qtde_faltas, qtde_justificada=:param_qtde_justificada ".
                "    where id = :param_id";
            
            //echo 'query:'.$cmd.'<br>';
            
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_qtde_faltas", $this->qtde_faltas, PDO::PARAM_INT);
            $stm->bindParam(":param_qtde_justificada", $this->qtde_justificada, PDO::PARAM_INT);
            
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
            $cmd = "delete from folha_monitor where id_folha = :param_id";
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
            $cmd = "delete from folha_monitor";
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