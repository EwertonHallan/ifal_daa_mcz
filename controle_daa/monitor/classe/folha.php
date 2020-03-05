<?php
include_once ('../../classe/folha_monitor.php');
include_once ('../../classe/enum/enumtipoturno.php');
//include_once ('./monitor/classe/enum/enumtipoturno.php');

Class Folha {
    private $id;
    private $nome;
    private $data_inicial;
    private $data_final;
    private $tot_dias;
    private $vlr_diaria;
    private $criterio_calculo;
    
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
        
        return $result['titulo'];
    }
    
    public function __toString() {
        return ('ID:'.$this->id.
            ' Nome:'.$this->nome.
            ' Data Inicial:'.FuncaoData::formatoData($this->data_inicial).
            ' Data Final:'.FuncaoData::formatoData($this->data_final).
            ' Total de Dias:'.$this->tot_dias.
            ' Valor Diaria:'.$this->vlr_diaria.
            ' Criterio de Calculo:'.$this->criterio_calculo      
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id_folha, nome, data_inicial, data_final, total_dias, valor_diaria, criterio from folha where id_folha = :param_id";
            
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
            $cmd = "select id_folha, nome, data_inicial, data_final, total_dias, valor_diaria, criterio from folha";
            if (!is_null($filtro) || !empty($filtro)) {
                $cmd.=' where '.$filtro;
            }
            if ($limite_inicial>0 || $limite_final>0) {
                $cmd.=' order by data_inicial desc LIMIT '.$limite_inicial.','.$limite_final;
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
            $this->id = $dados['id_folha'];
            $this->nome = FuncaoBanco::removeAcento($dados['nome']);
            $this->data_inicial = $dados['data_inicial'];
            $this->data_final = $dados['data_final'];
            $this->tot_dias = $dados['total_dias'];
            $this->vlr_diaria = $dados['valor_diaria'];
            $this->criterio_calculo = $dados['criterio'];
            
            $cmd = "insert into folha (nome, data_inicial, data_final, total_dias, valor_diaria, criterio) ".
            " values (:param_nome, :param_data_inicial, :param_data_final, :param_total_dias, :param_valor_diaria, :param_criterio)";
            
            //echo 'query:'.$cmd.'<br>';
            $stm = $this->conexao->conectar()->prepare($cmd);
            //$stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_nome", $this->nome, PDO::PARAM_STR);
            $stm->bindParam(":param_data_inicial", $this->data_inicial, PDO::PARAM_STR);
            $stm->bindParam(":param_data_final", $this->data_final, PDO::PARAM_STR);
            $stm->bindParam(":param_total_dias", $this->tot_dias, PDO::PARAM_INT);
            $stm->bindParam(":param_valor_diaria", $this->vlr_diaria, PDO::PARAM_STR);
            $stm->bindParam(":param_criterio", $this->criterio_calculo, PDO::PARAM_STR);
                        
            if ($stm->execute()) {
                $this->log_evento->queryInsert(
                    get_class($this),
                    'INSERT',
                    $cmd,
                    $this->__toString()
                    );
                
                $this->geraFolha_Fechamento();
                
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
            $this->id = $dados['id_folha'];
            $this->nome = FuncaoBanco::removeAcento($dados['nome']);
            $this->data_inicial = $dados['data_inicial'];
            $this->data_final = $dados['data_final'];
            $this->tot_dias = $dados['total_dias'];
            $this->vlr_diaria = $dados['valor_diaria'];
            $this->criterio_calculo = $dados['criterio'];
            
            $cmd = "update folha set nome=:param_nome, data_inicial=:param_data_inicial, data_final=:param_data_final,  ".
            " total_dias=:param_total_dias, valor_diaria=:param_valor_diaria, criterio=:param_criterio ".
            " where id_folha = :param_id";
            
            //echo 'query:'.$cmd.'<br>';
            
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_nome", $this->nome, PDO::PARAM_STR);
            $stm->bindParam(":param_data_inicial", $this->data_inicial, PDO::PARAM_STR);
            $stm->bindParam(":param_data_final", $this->data_final, PDO::PARAM_STR);
            $stm->bindParam(":param_total_dias", $this->tot_dias, PDO::PARAM_INT);
            $stm->bindParam(":param_valor_diaria", $this->vlr_diaria, PDO::PARAM_STR);
            $stm->bindParam(":param_criterio", $this->criterio_calculo, PDO::PARAM_STR);
            
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
            $folhaMon = new Folha_Monitor();
            $folhaMon->queryDelete($id);
            
            $cmd = "delete from folha where id_folha = :param_id";
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
            $cmd = "delete from folha";
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
    
    private function geraFolha_Fechamento () {
        try {
            $folhaMon = new Folha_Monitor();
            
            $cmd = "SELECT f.id_folha, m.id_monitor, m.nome as monitor, m.id_professor as id_orientador,". 
                 "         p.nome as orientador, m.id_curso, c.nome as curso, m.turma,".
                 "         m.id_turno, '' as turno, m.setor, m.horario_seg, m.horario_ter, m.horario_qua, m.horario_qui,".
                 "         m.horario_sex, 0 as qtde_faltas, 0 as qtde_justificada".
                 "    FROM monitor m, folha f, professor p, curso c".
                 "   where m.id_professor = p.id_professor and m.id_curso = c.id_curso".
                 "     and f.id_folha in (select max(id_folha) as id from folha)".
                 " order by m.id_monitor";
            
            //echo 'query:'.$cmd.'<br>';
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id_folha", $id_folha, PDO::PARAM_INT);
            
            $stm->execute();
            
            foreach ($stm->fetchAll() as $dados) {                
                $dados['turno'] = EnumTipoTurno::getDescricao($dados['id_turno']); 
                
                //var_dump($dados);
                
                $folhaMon->queryInsert($dados);
            }
            
            if ($stm->execute()) {
                $this->log_evento->queryInsert(
                    get_class($this),
                    'GERA FOLHA MONITOR',
                    $cmd,
                    $id_folha
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