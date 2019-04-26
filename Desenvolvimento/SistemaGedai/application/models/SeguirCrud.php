<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SeguirCrud extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_seguir_evento($id_usuario, $id_evento){
        $query = "SELECT id FROM seguir_evento WHERE id_usuario=".$id_usuario." AND id_evento=".$id_evento.";";
        return  $this->db->query($query)->result_array();
    }
    
    public function get_where_evento($id_evento) {
        $query = "SELECT usuario.email FROM usuario JOIN seguir_evento ON seguir_evento.id_evento=" . $id_evento . " AND usuario.id=seguir_evento.id_usuario;";
        return  $this->db->query($query)->result_array();
    }
    
}
?>


