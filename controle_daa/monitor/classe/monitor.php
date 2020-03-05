<?php
//require_once ('./classe/log.php');
//session_start();

class Monitor {
    private $id;
    private $matricula;
    private $nome;
    private $telefone;
    private $email;
    private $curso;
    private $turma;
    private $turno;
    private $setor;
    private $professor;
    
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
            ' Matricula:'.$this->matricula.
            ' Nome:'.$this->nome.
            ' Telefone:'.$this->telefone.
            ' E-Mail:'.$this->email.
            ' Curso:'.$this->curso.
            ' Turma:'.$this->turma.
            ' Turno:'.$this->turno.
            ' Setor:'.$this->setor.
            ' Orientador:'.$this->professor
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id_monitor, matricula, nome, telefone, email, id_curso, ".
                   "       turma, id_turno, setor, id_professor".
                   "  from monitor where id_monitor = :param_id";
            
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
            $cmd = "select id_monitor, matricula, nome, telefone, email, id_curso, ".
                "       turma, id_turno, setor, id_professor".
                "  from monitor ";
            
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
            $this->id = $dados['id_monitor'];
            $this->matricula = $dados['matricula'];
            $this->nome = FuncaoBanco::removeAcento($dados['nome']);
            $this->telefone = $dados['telefone'];
            $this->email = $dados['email'];
            $this->curso = $dados['id_curso'];
            $this->turma = FuncaoBanco::removeAcento($dados['turma']);
            $this->turno = $dados['id_turno'];
            $this->setor = FuncaoBanco::removeAcento($dados['setor']);
            $this->professor = $dados['id_professor'];
                        
            $cmd = "insert into monitor (matricula, nome, telefone, email, id_curso, turma, id_turno, setor, id_professor) ".
                " values (:param_matricula, :param_nome, :param_telefone, :param_email, :param_id_curso, :param_turma, :param_id_turno, :param_setor, :param_id_professor)";
            
            echo 'query:'.$cmd.'<br>';            
            $stm = $this->conexao->conectar()->prepare($cmd);
            //$stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_matricula", $this->matricula, PDO::PARAM_INT);
            $stm->bindParam(":param_nome", $this->nome, PDO::PARAM_STR);
            $stm->bindParam(":param_telefone", $this->telefone, PDO::PARAM_STR);
            $stm->bindParam(":param_email", $this->email, PDO::PARAM_STR);
            $stm->bindParam(":param_id_curso", $this->curso, PDO::PARAM_INT);
            $stm->bindParam(":param_turma", $this->turma, PDO::PARAM_STR);
            $stm->bindParam(":param_id_turno", $this->turno, PDO::PARAM_INT);
            $stm->bindParam(":param_setor", $this->setor, PDO::PARAM_STR);
            $stm->bindParam(":param_id_professor", $this->professor, PDO::PARAM_INT);
            
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
            $this->id = $dados['id_monitor'];
            $this->matricula = $dados['matricula'];
            $this->nome = FuncaoBanco::removeAcento($dados['nome']);
            $this->telefone = $dados['telefone'];
            $this->email = $dados['email'];
            $this->curso = $dados['id_curso'];
            $this->turma = FuncaoBanco::removeAcento($dados['turma']);
            $this->turno = $dados['id_turno'];
            $this->setor = FuncaoBanco::removeAcento($dados['setor']);
            $this->professor = $dados['id_professor'];
                        
            $cmd = "update monitor set matricula=:param_matricula, nome=:param_nome, telefone=:param_telefone, email=:param_email, ".
                " id_curso=:param_id_curso, turma=:param_turma, id_turno=:param_id_turno, setor=:param_setor, id_professor=:param_id_professor ".
                " where id_monitor = :param_id";
            
            echo 'query:'.$cmd.'<br>';
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_matricula", $this->matricula, PDO::PARAM_INT);
            $stm->bindParam(":param_nome", $this->nome, PDO::PARAM_STR);
            $stm->bindParam(":param_telefone", $this->telefone, PDO::PARAM_STR);
            $stm->bindParam(":param_email", $this->email, PDO::PARAM_STR);
            $stm->bindParam(":param_id_curso", $this->curso, PDO::PARAM_INT);
            $stm->bindParam(":param_turma", $this->turma, PDO::PARAM_STR);
            $stm->bindParam(":param_id_turno", $this->turno, PDO::PARAM_INT);
            $stm->bindParam(":param_setor", $this->setor, PDO::PARAM_STR);
            $stm->bindParam(":param_id_professor", $this->professor, PDO::PARAM_INT);
            
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
            $cmd = "delete from monitor where id_monitor = :param_id";
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
            $cmd = "delete from monitor";
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