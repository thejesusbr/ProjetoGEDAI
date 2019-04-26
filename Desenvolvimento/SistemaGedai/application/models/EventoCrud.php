<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EventoCrud extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectEventos() {
        $query = "SELECT * FROM evento ORDER BY data DESC";
        return $this->db->query($query)->result_array();
    }
    
    public function selectEventos_inicio() {
        $query = "SELECT * FROM evento WHERE status <> 'Finalizado'  ORDER BY data ASC LIMIT 6" ;
        return $this->db->query($query)->result_array();
    }
}