<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library("parser");
        $this->CI->load->library("session");
    }

    public function menu($dados) {
        if (empty($this->CI->session->userdata("id"))) {
            return $this->CI->parser->parse("menu/deslogado", $dados, TRUE);
        } else if ($this->CI->session->userdata("tipo") == "normal") {
            return $this->CI->parser->parse("menu/normal", $dados, TRUE);
        } else if ($this->CI->session->userdata("tipo") == "moderador") {
            return $this->CI->parser->parse("menu/moderador", $dados, TRUE);
        } else if ($this->CI->session->userdata("tipo") == "administrador") {
            return $this->CI->parser->parse("menu/administrador", $dados, TRUE);
        }
    }

}
