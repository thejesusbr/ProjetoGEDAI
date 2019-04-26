<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("SeguirCrud");
        $this->load->model("EventoCrud");
    }

    public function index($dados = NULL) {
        if ($dados == NULL) {
            $dados = array("display" => "none", "msg" => " ");
        } else if (empty($dados["display"])) {
            $dados["display"] = 'block';
        }
        if(empty($this->session->userdata("id"))){
            $view = "inicio_s_sessao";
        } else {
            $view = "inicio";
        }
        
        $eventos = $this->EventoCrud->selectEventos_inicio();
        foreach ($eventos as $key => $value) {
            $eventos[$key]["url"] = base_url();
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
                        $eventos[$key]["link"] = "client/Eventos/seguir_evento/" . $eventos[$key]["id"] . "/Inicio";
                    } else {
                        $eventos[$key]["seguir"] = "Deixar de Seguir";
                        $eventos[$key]["cor"] = "danger";
                        $eventos[$key]["link"] = "client/Eventos/deixar_seguir/" . $eventos[$key]["id"] . "/Inicio";
                    }
                }
            }
        }
        
        $artigos = $this->Crud->artigos_mais_acessados();
        foreach ($artigos as $key => $value) {
            $artigos[$key]["url"] = base_url();
        }
        
        $dados["url"] = base_url();
        $dados["menu"] = $this->menu->menu($dados);
        $dados["eventos"] = $eventos;
        $dados["artigos"] = $artigos;
        $dados['conteudo'] = $this->parser->parse($view, $dados, TRUE);
        $this->parser->parse("layout", $dados);
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

    public function cadastrar() {
        $cadastro = $this->input->post();
        $this->form_validation->set_data($cadastro);
        $this->form_validation->set_rules("nome", "NOME", "required");
        $this->form_validation->set_rules("sobrenome", "SOBRENOME", "required");
        $this->form_validation->set_rules("emailCad", "EMAILCAD", "required");
        $this->form_validation->set_rules("senhaCad", "SENHACAD", "required");
        $this->form_validation->set_rules("confirmaSenha", "CONFIRMASENHA", "required");
        if ($this->form_validation->run($cadastro)) {
            $user["email"] = $cadastro["emailCad"];
            $tem = $this->Crud->select("usuario", "id", $user);
            if (empty($tem["message"][0])) {
                if ($cadastro["senhaCad"] == $cadastro["confirmaSenha"]) {
                    $user["nome"] = $cadastro["nome"] . " " . $cadastro["sobrenome"];
                    mb_convert_case($user["nome"], MB_CASE_TITLE, 'UTF-8');
                    $user["email"] = $cadastro["emailCad"];
                    $user["senha"] = sha1($cadastro["senhaCad"]);
                    $user["tipo"] = "normal";
                    $user["ativo"] = 0;
                    $url = base_url() . "api/Usuario_api/usuario";
                    $user = $this->security->xss_clean($user);
                    if ($this->Crud->insere("usuario", $user)) {
                        $dados["display"] = "block";
                        $dados["msg"] = "Cadastrado com sucesso! Você receberá um email de ativação. Ative sua conta para usufruir do sistema!";
                        $dados["cor"] = "success";
                        $this->enviar($cadastro["emailCad"], "ativar");
                    } else {
                        $dados["display"] = "block";
                        $dados["msg"] = "Erro ao cadastrar, consulte os desenvolvedores!";
                        $dados["cor"] = "danger";
                    }
                } else {
                    $dados["display"] = "block";
                    $dados["msg"] = "Os campos 'Senha' e 'Repetir Senha' não são iguais!";
                    $dados["cor"] = "danger";
                }
            } else {
                $dados["display"] = "block";
                $dados["msg"] = "Email já cadastrado!";
                $dados["cor"] = "danger";
            }
            
        } else {
            $dados["display"] = "block";
            $dados["msg"] = "Preencha todos os campos";
            $dados["cor"] = "danger";
        }
        $this->index($dados);
    }

    public function enviar($to = NULL, $funcao = NULL, $what = "email") {
        $param["email"] = $to;
        $id = $this->Crud->select("usuario", "id", $param);
        if (!empty($id) && $to != NULL && $funcao != NULL) {
            $id = $id[0]["id"];
            $this->email->clear();
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->from('gedaicefet2018@gmail.com', 'Sistema GEDAI');
            $this->email->to($to);
            $dados["link"] = base_url() . "Inicio/" . $funcao . "/" . $id . "/" . urlencode($to) . "/" . sha1(sha1(urlencode($to)));
            $what = "emails/" . $what;
            $htmlMessage = $this->parser->parse($what, $dados, TRUE);
            $this->email->subject('Sistema GEDAI');
            $this->email->message($htmlMessage);
            if ($this->email->send()) {
                return true;
            } else {
                show_error($this->email->print_debugger());
                return false;
            }
        } else {
            $dados["display"] = "block";
            $dados["msg"] = "Email não cadastrado!";
            $dados["cor"] = "danger";
            $this->index($dados);
        }
    }

    public function ativar($id = NULL, $email = NULL, $sha1 = NULL) {
        if ($id != NULL && $email != NULL && $sha1 != NULL && sha1(sha1($email)) == $sha1) {
            $param["email"] = urldecode($email);
            $tem = $this->Crud->select("usuario", "id", $param);
            if (!empty($tem)) {
                $sql["ativo"] = 1;
                $param["id"] = $id;
                $this->Crud->update("usuario", $sql, $param);
                $dados["display"] = "block";
                $dados["msg"] = "Conta ativa, agora você pode logar no sistema!";
                $dados["cor"] = "success";
                $this->index($dados);
            } else {
                redirect("Inicio");
            }
        } else {
            redirect("Inicio");
        }
    }

    public function logar() {
        $form = $this->input->post();
        $this->form_validation->set_data($form);
        $this->form_validation->set_rules("email", "EMAIL", "required");
        $this->form_validation->set_rules("senha", "SENHA", "required");
        if ($this->form_validation->run($form)) {
            $user["email"] = $form["email"];
            $tem = $this->Crud->select("usuario", "*", $user);
            if (!empty($tem)) {
                $usuario = $tem[0];
                if ($usuario["ativo"] == 1) {
                    if ($usuario["senha"] == sha1($form["senha"])) {
                        $this->session->set_userdata($usuario);
                        redirect("inicio");
                    } else {
                        $dados["display"] = "block";
                        $dados["cor"] = "danger";
                        $dados["msg"] = "Senha Incorreta!";
                    }
                } else {
                    $dados["display"] = "block";
                    $dados["cor"] = "danger";
                    $dados["msg"] = "Conta Desativada! Verifique seu email para ativar a conta!";
                }
                return $this->index($dados);
            } else {
                $dados["display"] = "block";
                $dados["cor"] = "danger";
                $dados["msg"] = "Dados não cadastros!";
            }
            
        } else {
            $dados["display"] = "block";
            $dados["cor"] = "danger";
            $dados["msg"] = "Preenchar todos os dados para Logar no sistema!";
        }
        return $this->index($dados);
    }

    public function esqueci() {
        $form = $this->input->post();
        if (empty($form)) {
            $dados["url"] = base_url();
            $dados["display"] = "none";
            $dados["menu"] = $this->menu->menu($dados);
            $dados['conteudo'] = $this->parser->parse("esqueci", $dados, TRUE);
            return $this->parser->parse("layout", $dados);
        } else {

            $resultado = $this->Crud->select("usuario", "*", $form);
            if (!empty($resultado)) {
                if ($this->enviar($form["email"], "changepsw", "mudar_senha")) {
                    $dados["msg"] = "Enviamos um email! Verifique sua caixa de entrada para mudar a senha!";
                    $dados["display"] = "block";
                    $dados["cor"] = "success";
                } else {
                    $dados["msg"] = "Não foi possível enviar lhe um e-mail para mudara senha! Contate os desenvolvedores!";
                    $dados["display"] = "block";
                    $dados["cor"] = "danger";
                }
                return $this->index($dados);
            } else {
                $dados["msg"] = "Email não cadastrado no sistema!";
                $dados["display"] = "block";
                $dados["cor"] = "danger";
            }
            return $this->index($dados);
        }
    }

    public function changepsw($id = NULL, $email = NULL, $sha1 = NULL) {
        if ($id != NULL && $email != NULL && $sha1 != NULL && sha1(sha1($email)) == $sha1) {
            $param["email"] = urldecode($email);
            $resultado = $this->Crud->select("usuario", "*", $param);
            if (!empty($resultado)) {
                $form = $this->input->post();
                if (!empty($form)) {
                    $user["senha"] = sha1($form["changeSenha"]);
                    $resultado = $this->Crud->update("usuario", $user, $param);
                    if ($resultado["status"]) {
                        $dados["msg"] = "Senha atualizada, tente logar no sistema!";
                        $dados["display"] = "block";
                        $dados["cor"] = "success";
                    } else {
                        $dados["msg"] = "Erro ao atualizar no banco de dados, por favor contate os desenvolvedores!";
                        $dados["display"] = "block";
                        $dados["cor"] = "danger";
                    }
                    return $this->index($dados);
                    
                } else {
                    $dados["url"] = base_url();
                    $dados["display"] = "none";
                    $dados["menu"] = $this->menu->menu($dados);
                    $dados["id"] = $id;
                    $dados["email"] = $email;
                    $dados["sha1"] = $sha1;
                    $dados["conteudo"] = $this->parser->parse("mudar_senha", $dados, TRUE);
                    return $this->parser->parse("layout", $dados);
                }
            } else {
                redirect("Inicio");
            }
            
        } else {
            redirect("Inicio");
        }
    }

    public function deslogar() {
        $this->session->sess_destroy();
        redirect("Inicio/");
    }

}

?>