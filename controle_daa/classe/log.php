<?php
session_start();

class Log {
    private $id;
    private $usuario;
    private $tela;
    private $opcao;
    private $comando;
    private $observacao;
    private $data;
    private $hora;
    
    private $conexao;
    
    public function __construct() {
        $this->conexao = new Conexao();
    }
    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function __toString() {
        return ('ID:'.$this->id.
            ' Usuario:'.$this->usuario.
            ' Tela:'.$this->tela.
            ' Opcao:'.$this->opcao.
            ' Comando:'.$this->comando.
            ' Observacao:'.$this->observacao.
            ' Data:'.FuncaoData::formatoData($this->data).
            ' Hora:'.$this->hora
            );
    }
    
    public function querySelect ($id) {
        try {
            $cmd = "select id, id_usuario, tela, opcao, comando, observacao, data, hora from log where id = :param_id";
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
            $cmd = "select id, id_usuario, tela, opcao, comando, observacao, data, hora from log";
            if (!is_null($filtro) || !empty($filtro)) {
                $cmd.=' where '.$filtro;
            }
            if ($limite_inicial>0 || $limite_final>0) {
                $cmd.=' order by data desc, hora desc LIMIT '.$limite_inicial.','.$limite_final;
            }
            //echo 'query:'.$cmd.'<br>';
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->execute();
            
            return $stm->fetchAll();
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    public function queryInsert ($tela, $opcao, $comando, $observacao) {
        try {
            $this->usuario = $_SESSION["id"];
            
            //$this->id = $dados['id'];
            //$this->usuario = $id_usuario;
            $this->tela = $tela;
            $this->opcao = $opcao;
            $this->comando = $comando;
            $this->observacao = $observacao;
            $this->data = FuncaoBanco::dataAtual();
            $this->hora = FuncaoBanco::horaAtual();
            
            $cmd = "insert into log (id_usuario, tela, opcao, comando, observacao, data, hora) ".
                   " values (:param_id_usuario, :param_tela, :param_opcao, :param_comando, :param_observacao, :param_data, :param_hora)";
            
            //echo "COMANDO:".$cmd;
            $stm = $this->conexao->conectar()->prepare($cmd);
            //$stm->bindParam(":param_id", $this->id, PDO::PARAM_INT);
            $stm->bindParam(":param_id_usuario", $this->usuario, PDO::PARAM_INT);
            $stm->bindParam(":param_tela", $this->tela, PDO::PARAM_STR);
            $stm->bindParam(":param_opcao", $this->opcao, PDO::PARAM_STR);
            $stm->bindParam(":param_comando", $this->comando, PDO::PARAM_STR);
            $stm->bindParam(":param_observacao", $this->observacao, PDO::PARAM_STR);
            $stm->bindParam(":param_data", $this->data, PDO::PARAM_STR);
            $stm->bindParam(":param_hora", $this->hora, PDO::PARAM_STR);
            
            if ($stm->execute()) {
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
            $cmd = "delete from log where id = :param_id";
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $id, PDO::PARAM_INT);
            
            if ($stm->execute()) {
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
            $cmd = "delete from log";
            $stm = $this->conexao->conectar()->prepare($cmd);
            
            if ($stm->execute()) {
                return True;
            } else {
                return False;
            }
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
}

?>