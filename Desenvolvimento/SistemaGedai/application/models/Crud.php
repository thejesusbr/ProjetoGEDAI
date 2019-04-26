<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function select($tabela = NULL, $campo = "*", $where = NULL, $order = NULL, $how = 'ASC') {
        $this->db->select($campo);
        if ($where) {
            $this->db->where($where);
        }
        if ($order) {
            $this->db->order_by('title', $how);
        }
        $result = $this->db->get($tabela);
        return $result->result_array();
    }

    public function insere($tabela, $dados) {
        return $this->db->insert($tabela, $dados);
    }

    public function update($tabela, $dados, $where) {
        $this->db->where($where);
        try {
            $this->db->update($tabela, $dados);
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function delete($tabela, $where) {
        $this->db->where($where);
        try {
            $this->db->delete($tabela);
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }
    
    public function comentarios($id){
        $query = "SELECT usuario.nome, comentario.texto, comentario.id FROM comentario JOIN usuario ON comentario.id_usuario=usuario.id AND comentario.id_artigo=".$id;
        return $this->db->query($query)->result_array();
    }
    
    public function artigos_mais_acessados(){
        $query = "SELECT * FROM artigo ORDER BY views DESC LIMIT 6";
        return $this->db->query($query)->result_array();
    }

}
?>


