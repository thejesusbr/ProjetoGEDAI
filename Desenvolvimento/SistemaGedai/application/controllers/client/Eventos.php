<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Eventos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("SeguirCrud");
        $this->load->model("EventoCrud");
    }

    public function atualiza_sessao($array = array()) {
        $sessao = $this->session->userdata();
        $sessao["mensagens"] = $array;
        $this->session->set_userdata($sessao);
    }

    public function index($dados = array()) {
        $dados["url"] = base_url();
        $dados["vazio"] = "";
        $eventos = $this->Crud->select("evento");
        if (empty($eventos)) {
            $dados["vazio"] = "<h3>Nenhum evento agendado no sistema.</h3>";
        }
        if (empty($this->session->userdata("id"))) {
            $dados["modal"] = 'data-toggle="modal" data-target="#cadastrarModal"';
            $dados["conteudo"] = $this->parser->parse("adm/eventos/eventos_sem_sessao", $dados, TRUE);
        } else {
            $dados["conteudo"] = $this->parser->parse("adm/eventos/eventos_sessao", $dados, TRUE);
        }
        return $this->layout($dados);
    }

    public function todos_os_eventos() {
        $eventos = $this->EventoCrud->selectEventos();
        foreach ($eventos as $key => $value) {
            $eventos[$key]["informacoes"] = substr($eventos[$key]["informacoes"], 0, 50);
            $eventos[$key]["data"] = date('d/m/Y', strtotime($eventos[$key]["data"]));
            $dia = $eventos[$key]["data"];
            $hoje = date("d/m/Y");
            $comparacao = $this->compara_data($hoje, $dia);
            if ($comparacao == "False") {
                $eventos[$key]["seguir"] = "Finalizado";
                $eventos[$key]["cor"] = "secondary";
                $eventos[$key]["link"] = "Client/Eventos";
                $where["id"] = $eventos[$key]["id"];
                $dado["status"] = "Finalizado";
                $this->Crud->update("evento", $dado, $where);
            } else {
                if (!empty($this->session->userdata("id"))) {
                    $segue = $this->SeguirCrud->get_seguir_evento($this->session->userdata("id"), $eventos[$key]["id"]);
                    if (empty($segue)) {
                        $eventos[$key]["seguir"] = "Seguir";
                        $eventos[$key]["cor"] = "primary";
                        $eventos[$key]["link"] = "client/Eventos/seguir_evento/" . $eventos[$key]["id"];
                    } else {
                        $eventos[$key]["seguir"] = "Deixar de Seguir";
                        $eventos[$key]["cor"] = "danger";
                        $eventos[$key]["link"] = "client/Eventos/deixar_seguir/" . $eventos[$key]["id"];
                    }
                }
            }
        }
        $return = json_encode($eventos);
        echo $return;
    }

    public function compara_data($hoje, $data) {
        $hoje = explode("/", $hoje);
        $data = explode("/", $data);
        $retorno = "True";
        if (intval($data[2]) < intval($hoje[2])) {
            $retorno = "False";
        } else if (intval($data[2]) <= intval($hoje[2]) && intval($data[1]) < intval($hoje[1])) {
            $retorno = "False";
        } else if (intval($data[2]) <= intval($hoje[2]) && intval($data[1]) <= intval($hoje[1]) && intval($data[0]) < intval($hoje[0])) {
            $retorno = "False";
        }

        return $retorno;
    }

    public function tem($where) {
        $result = $this->Crud->select("evento", "id", $where);
        return $result;
    }

    public function layout($dados = NULL) {
        if ($dados != NULL) {
           if (!empty($this->session->userdata("mensagens"))) {
                $dados["msg"] = $this->session->userdata("mensagens")["msg"];
                $dados["display"] = $this->session->userdata("mensagens")["display"];
                $dados["cor"] = $this->session->userdata("mensagens")["cor"];
                $this->atualiza_sessao(array());
            } else {
                $dados["display"] = "none";
            }
            $dados["url"] = base_url();
            $dados["menu"] = $this->menu->menu($dados);
            $this->parser->parse("layout", $dados);
        } else {
            redirect("Inicio");
        }
    }

    public function gerenciar_eventos() {
        if (!empty($this->session->userdata("id")) && $this->session->userdata("tipo") == "administrador" || $this->session->userdata("tipo") == "moderador") {
            $dados["eventos"] = $this->EventoCrud->selectEventos();
            $dados["url"] = base_url();
            foreach ($dados["eventos"] as $key => $value) {
                $dados["eventos"][$key]["url"] = base_url();
            }
            $dados["modal_excluir"] = $dados["eventos"];
            $dados["conteudo"] = $this->parser->parse("adm/eventos/gerenciar_eventos", $dados, TRUE);
            $this->layout($dados);
        } else {
            redirect("Inicio");
        }
    }

    public function adicionar_evento() {
        if (!empty($this->session->userdata("id")) && $this->session->userdata("tipo") == "administrador") {
            $form = $this->input->post();
            if (!empty($form)) {
                $form["status"] = "Marcado";
                if ($this->Crud->insere("evento", $form)) {
                    $msg["msg"] = "Evento adicionado com sucesso!";
                    $msg["display"] = "block";
                    $msg["cor"] = "success";
                } else {
                    $msg["msg"] = "Erro ao adicionar evento!";
                    $msg["display"] = "block";
                    $msg["cor"] = "danger";
                }
                $this->atualiza_sessao($msg);
                redirect("client/Eventos/gerenciar_eventos");
            } else {
                $dados["url"] = base_url();
                $dados["min"] = date("Y-m-d");
                $dados["conteudo"] = $this->parser->parse("adm/eventos/add_eventos", $dados, TRUE);
                return $this->layout($dados);
            }
        } else {
            redirect("Inicio");
        }
    }

    public function editar_evento($id = NULL) {
        $where["id"] = $id;
        $tem = $this->tem($where);
        if (!empty($this->session->userdata("id")) && $this->session->userdata("tipo") == "administrador" && $id != NULL) {
            $where["id"] = $id;
            $form = $this->input->post();
            if (!empty($form)) {
                $this->form_validation->set_data($form);
                $this->form_validation->set_rules("nome", "NOME", "required");
                $this->form_validation->set_rules("informacoes", "INFORMACOES", "required");
                $this->form_validation->set_rules("data", "DATA", "required");
                $this->form_validation->set_rules("hora", "HORA", "required");
                $this->form_validation->set_rules("local", "LOCAL", "required");
                if ($this->form_validation->run() != FALSE) {
                    $antes = $this->Crud->select("evento", "*", $where)[0];
                    $mensagem = $this->indentifica_mudanca($antes, $form);
                    $antes = date('d/m/Y', strtotime($antes["data"]));
                    $data = date('d/m/Y', strtotime($form["data"]));
                    $compara = $this->compara_data($antes, $data);
                    if($compara=="True"){
                        $form["status"] = "Adiado";
                    }
                    if ($this->Crud->update("evento", $form, $where)) {
                        $dados["msg"] = "Evento editado com sucesso!";
                        $dados["display"] = "block";
                        $dados["cor"] = "success";
                        if ($mensagem != "falhou") {
                            $this->notifica($mensagem, $id);
                        }
                    } else {
                        $dados["msg"] = "Erro ao editar evento!";
                        $dados["display"] = "block";
                        $dados["cor"] = "danger";
                    }
                    $this->atualiza_sessao($dados);
                } else {
                    $dados["msg"] = "Por favor preencha todos os campos para salvar a edição!";
                    $dados["display"] = "block";
                    $dados["cor"] = "danger";
                }
                redirect("client/Eventos/gerenciar_eventos");
            } else {
                $dados = $this->Crud->select("evento", "*", $where)[0];
                $dados["url"] = base_url();
                $dados["min"] = date("Y-m-d");
                $dados["conteudo"] = $this->parser->parse("adm/eventos/editar_evento", $dados, TRUE);
                return $this->layout($dados);
            }
        } else if (empty($tem)) {
            redirect("client/Eventos/gerenciar_eventos");
        } else {
            redirect("Inicio");
        }
    }

    private function indentifica_mudanca($antes = NULL, $depois = NULL) {
        if ($depois != NULL && $antes != NULL) {
            $mudou = 0;
            $msg = array();
            if ($antes["nome"] != $depois["nome"]) {
                $msg['lista'][1]["msg"] = "Nome do evento alterado de '" . $antes["nome"]. "' para: " . $depois["nome"] ;
                $mudou = 1;
            }
            if ($antes["data"] != $depois["data"]) {
                $string = date("d/m/Y", strtotime($depois["data"]));
                $msg['lista'][2]["msg"] = "A data do evento foi alterada para: " . $string;
                $mudou = 1;
            }
            if ($antes["hora"] != $depois["hora"]) {
                $msg['lista'][3]["msg"] = "O horário foi alterado para: " . $depois["hora"];
                $mudou = 1;
            }
            if ($antes["local"] != $depois["local"]) {
                $msg["lista"][4]["msg"] = "O local do evento foi alterador para: " . $depois["local"];
                $mudou = 1;
            }
            if ($antes["informacoes"] != $depois["informacoes"]) {
                $msg["lista"][5]["msg"] = "As informações sobre o evento foram atualizadas!";
                $mudou = 1;
            }
            if ($mudou == 1) {
                $msg["evento"] = $antes["nome"];
                $retorno = $this->parser->parse("emails/notificacao", $msg, TRUE);
            } else {
                $retorno = "falhou";
            }
            return $retorno;
        }
    }

    public function notifica($msg = NULL, $evento = NULL) {
        $emails = $this->SeguirCrud->get_where_evento($evento);
        $para = array();
        foreach ($emails as $key => $value) {
            $para[$key] = $emails[$key]["email"];
        }
        if (!empty($para)) {
            $this->email->clear();
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from('gedaicefet2018@gmail.com', 'Sistema GEDAI');
            $this->email->to($para);
            $dados["url"] = base_url();
            $dados["nome"] = $this->Crud->select("evento", "nome", "id=" . $evento)[0]["nome"];
            $dados["msg"] = $msg;
            $dados["link"] = "client/Eventos/ver_evento/" . $evento;
            $htmlMessage = $this->parser->parse("adm/eventos/notifica", $dados, TRUE);
            $this->email->subject('Sistema GEDAI');
            $this->email->message($htmlMessage);
            if ($this->email->send()) {
                return true;
            } else {
                show_error($this->email->print_debugger());
                return false;
            }
        }
    }

    public function deletar_evento($id = NULL) {
        $where["id"] = $id;
        $tem = $this->tem($where);
        if (!empty($this->session->userdata("id")) && $this->session->userdata("tipo") == "administrador" && $id != NULL && !empty($tem)) {
            if ($this->Crud->delete("evento", $where)) {
                $dados["msg"] = " Evento deletado com sucesso";
                $dados["display"] = "block";
                $dados["cor"] = "success";
            } else {
                $dados["msg"] = "Erro ao deletar evento!";
                $dados["display"] = "block";
                $dados["cor"] = "danger";
            }
            $this->atualiza_sessao($dados);
            redirect("client/Eventos/gerenciar_eventos");
        } else if (empty($tem)) {
            redirect("client/Eventos/gerenciar_eventos");
        } else {
            redirect("Inicio");
        }
    }

    public function seguir_evento($id_evento = NULL, $link = NULL) {
        if (!empty($this->session->userdata("id")) && $id_evento != NULL) {
            $dados["id_usuario"] = $this->session->userdata("id");
            $dados["id_evento"] = $id_evento;
            if (empty($this->SeguirCrud->get_seguir_evento($this->session->userdata("id"), $id_evento))) {
                if ($this->Crud->insere("seguir_evento", $dados)) {
                    $data["display"] = "block";
                    $data["cor"] = "success";
                    $data["msg"] = "Seguindo Evento";
                    if ($link != NULL) {
                        if($func == "Inicio"){
                            redirect($link);
                        } else {
                            $red = "client/Eventos/ver_evento/".$id_evento;
                            redirect($red);
                        }
                    } else {
                        return $this->index($data);
                    }
                } else {
                    $data["display"] = "block";
                    $data["cor"] = "danger";
                    $data["msg"] = "Erro no banco de dados. Contate um desenvolvedor!";
                    return $this->index($data);
                }
            } else {
                if ($func != NULL) {
                    $link = "client/Eventos/" . $func . "/" . $id_evento;
                } else {
                    $link = "client/Eventos";
                }
                redirect($link);
            }
        }
    }

    public function deixar_seguir($id_evento, $link = NULL) {
        if (!empty($this->session->userdata("id")) && $id_evento != NULL) {
            $dados["id_usuario"] = $this->session->userdata("id");
            $dados["id_evento"] = $id_evento;
            if (!empty($this->SeguirCrud->get_seguir_evento($this->session->userdata("id"), $id_evento))) {
                if ($this->Crud->delete("seguir_evento", $dados)) {
                    $data["display"] = "block";
                    $data["cor"] = "primary";
                    $data["msg"] = "Deixou de seguir evento!";
                    if ($link != NULL) {
                       if($link == "Inicio"){
                            redirect($link);
                        } else {
                            $red = "client/Eventos/ver_evento/".$id_evento;
                            redirect($red);
                        }
                    } else {
                        return $this->index($data);
                    }
                } else {
                    $data["display"] = "block";
                    $data["cor"] = "danger";
                    $data["msg"] = "Erro no banco de dados. Contate um desenvolvedor!";
                    return $this->index($data);
                }
            } else {
                if ($func != NULL) {
                    $link = "client/Eventos/" . $func . "/" . $id_evento;
                } else {
                    $link = "client/Eventos";
                }
                redirect($link);
            }
        }
    }

    public function ver_evento($id = NULL) {
        if ($id != NULL) {
            $where["id"] = $id;
            $dados = $this->Crud->select("evento", "*", $where)[0];
            $dados["url"] = base_url();
            $dados["link"] = base_url() . "client/Eventos/";
            $dados["data"] = date("d/m/Y", strtotime($dados["data"]));
            if (!empty($this->session->userdata("id"))) {
                $tem = $this->SeguirCrud->get_seguir_evento($this->session->userdata("id"), $id);
                if (empty($tem)) {
                    $dados["seguir"] = "Seguir";
                    $dados["cor2"] = "primary";
                    $dados["link"] = $dados["link"] . "seguir_evento/" . $id . "/ver_evento";
                } else {
                    $dados["seguir"] = "Deixar de Seguir";
                    $dados["cor2"] = "danger";
                    $dados["link"] = $dados["link"] . "deixar_seguir/" . $id . "/ver_evento";
                }

                if ($dados["status"] == "Marcado") {
                    $dados["cor"] = "primary";
                } else if ($dados["status"] == "Finalizado") {
                    $dados["cor"] = "secondary";
                    $dados["link"] = " ";
                    $dados["seguir"] = "Finalizado";
                    $dados["cor2"] = "secondary";
                } else if ($dados["status"] == "Adiado") {
                    $dados["cor"] = "warning";
                }
                $dados["conteudo"] = $this->parser->parse("normal/eventos/detalhes", $dados, TRUE);
                return $this->layout($dados);
            } else {
                $dados["cor"] = "secondary";
                $dados["link"] = " ";
                $dados["seguir"] = "Cadastre-se para seguir este evento";
                $dados["cor2"] = "secondary";
                $dados["conteudo"] = $this->parser->parse("normal/eventos/detalhes", $dados, TRUE);
                return $this->layout($dados);
            }
        }
    }

}

?>