<?php
//require_once ('./classe/log.php');
//session_start();

class Professor {
    private $id;
    private $siape;
    private $nome;
    private $telefone;
    private $email;
    private $coordenacao;
    private $mesativo;
    private $mesinativo;
    private $cargahoraria;
    
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
            ' SIAPE:'.$this->siape.
            ' Nome:'.$this->nome.
            ' Telefone:'.$this->telefone.
            ' E-Mail:'.$this->email.
            ' Coordenacao:'.$this->coordenacao.
            ' Mes Ativacao:'.FuncaoData::formatoData($this->mesativo).
            ' Mes Inativacao:'.FuncaoData::formatoData($this->mesinativo).
            ' Carga Horaria:'.$this->cargahoraria
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id_professor, siape, nome, telefone, email, id_coordenacao, mes_ativo, mes_inativo, carga_hr from professor where id_professor = :param_id";
            
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
            $cmd = "select id_professor, siape, nome, telefone, email, id_coordenacao, mes_ativo, mes_inativo, carga_hr from professor";
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
            $this->id = $dados['id_professor'];
            $this->siape = $dados['siape'];
            $this->nome = FuncaoBanco::removeAcento($dados['nome']);
            $this->telefone = $dados['telefone'];
            $this->email = $dados['email'];
            $this->coordenacao = $dados['id_coordenacao'];
            $this->mesativo = $dados['mes_ativo'];
            $this->mesinativo = $dados['mes_inativo'];
            $this->cargahoraria = $dados['carga_hr'];
            
            //validacao da data quando null
            if (empty($this->mesativo)) {
                $this->mesativo = FuncaoBanco::formataData('31/12/2099');
            }
            
            if (empty($this->mesinativo)) {
                $this->mesinativo = FuncaoBanco::formataData('31/12/2999');
            }
            
            $cmd = "insert into professor (siape, nome, telefone, email, id_coordenacao, mes_ativo, mes_inativo, carga_hr) ".
                " values (:param_siape, :param_nome, :param_telefone, :param_email, :param_coordenacao, :param_ativo, :param_inativo, :param_carga_hr)";
            
            //echo 'query:'.$cmd.'<br>';            
            $stm = $this->conexao->conectar()->prepare($cmd);
            //$stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_siape", $this->siape, PDO::PARAM_INT);
            $stm->bindParam(":param_nome", $this->nome, PDO::PARAM_STR);
            $stm->bindParam(":param_telefone", $this->telefone, PDO::PARAM_STR);
            $stm->bindParam(":param_email", $this->email, PDO::PARAM_STR);
            $stm->bindParam(":param_coordenacao", $this->coordenacao, PDO::PARAM_INT);
            $stm->bindParam(":param_ativo", $this->mesativo, PDO::PARAM_STR);
            $stm->bindParam(":param_inativo", $this->mesinativo, PDO::PARAM_STR);
            $stm->bindParam(":param_carga_hr", $this->cargahoraria, PDO::PARAM_INT);
            
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
            $this->id = $dados['id_professor'];
            $this->siape = $dados['siape'];
            $this->nome = FuncaoBanco::removeAcento($dados['nome']);
            $this->telefone = $dados['telefone'];
            $this->email = $dados['email'];
            $this->coordenacao = $dados['id_coordenacao'];
            $this->mesativo = $dados['mes_ativo'];
            $this->mesinativo = $dados['mes_inativo'];
            $this->cargahoraria = $dados['carga_hr'];
            
            //validacao da data quando null           
            if (empty($this->mesativo)) {
                $this->mesativo = FuncaoBanco::formataData('31/12/2099');
            }
            
            if (empty($this->mesinativo)) {
                $this->mesinativo = FuncaoBanco::formataData('31/12/2999');
            }
            
            $cmd = "update professor set siape=:param_siape, nome=:param_nome, telefone=:param_telefone, email=:param_email, id_coordenacao=:param_coordenacao, ".
                "        mes_ativo=:param_ativo, mes_inativo=:param_inativo, carga_hr=:param_carga_hr where id_professor = :param_id";
            
            //echo 'query:'.$cmd.'<br>';

            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_siape", $this->siape, PDO::PARAM_INT);
            $stm->bindParam(":param_nome", $this->nome, PDO::PARAM_STR);
            $stm->bindParam(":param_telefone", $this->telefone, PDO::PARAM_STR);
            $stm->bindParam(":param_email", $this->email, PDO::PARAM_STR);
            $stm->bindParam(":param_coordenacao", $this->coordenacao, PDO::PARAM_INT);
            $stm->bindParam(":param_ativo", $this->mesativo, PDO::PARAM_STR);
            $stm->bindParam(":param_inativo", $this->mesinativo, PDO::PARAM_STR);
            $stm->bindParam(":param_carga_hr", $this->cargahoraria, PDO::PARAM_INT);
            
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
            $cmd = "delete from professor where id_professor = :param_id";
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
            $cmd = "delete from professor";
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