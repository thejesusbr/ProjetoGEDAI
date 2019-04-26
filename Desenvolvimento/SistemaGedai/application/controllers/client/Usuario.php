<?php

defined('BASEPATH') OR exit('Nodirect script access allowed');

class Usuario extends CI_Controller {

   

    public function __construct() {
        parent::__construct();
        if (empty($this->session->userdata("id"))) {
            redirect("Inicio/deslogar");
        }
    }

    public function index($dados = NULL) {
        if ($dados != NULL) {
            if (empty($dados['display'])) {
                $dados["display"] = "none";
            }
            $dados["url"] = base_url();
            $dados["menu"] = $this->menu->menu($dados);
            $this->parser->parse("layout", $dados);
        } else {
            redirect("Inicio");
        }
    }

    public function ver_perfil($display = "none", $msg = "", $cor = "") {
        $dados["url"] = base_url();
        $dados["display"] = $display;
        $dados["msg"] = $msg;
        $dados["cor"] = $cor;
        $where["id"] = $this->session->userdata("id");
        $dados["perfil"] = $this->Crud->select("usuario", "*", $where)[0];
        $dados["perfil"]["url"] = base_url();
        $dados["perfil"]["email1"] = urlencode($dados["perfil"]["email"]);
        $dados["perfil"]["sha1"] = sha1(sha1($dados["perfil"]["email1"]));
        $dados["conteudo"] = $this->parser->parse('normal/usuario/perfil', $dados["perfil"], TRUE);

        $this->index($dados);
    }

    public function editar_perfil($id = NULL) {
        if ($id != NULL && $id == $this->session->userdata("id")) {
            $form = $this->input->post();
            if (empty($form)) {
                $where["id"] = $this->session->userdata("id");
                $dados = $this->Crud->select("usuario", "*", $where)[0];
                $dados["url"] = base_url();
                $dados["id"] = $id;
                $dados["conteudo"] = $this->parser->parse("normal/usuario/editar_perfil", $dados, TRUE);
                $this->index($dados);
            } else {
                $where["id"] = $this->session->userdata("id");
                if ($this->Crud->update("usuario", $form, $where)) {
                    $msg = "Perfil Atualizado com sucesso";
                    $this->ver_perfil("block", $msg, "success");
                } else {
                    $msg = "Erro ao atualizar perfil!";
                    $this->ver_perfil("block", $msg, "danger");
                }
            }
        } else {
            redirect("Inicio");
        }
    }

    public function deletar_perfil($id = NULL) {
        $where["id"] = $this->session->userdata("id");
        $tem = $this->Crud->select("usuario", "id", $where);
        if (count($tem) == 1) {
            $dados["msg"] = "Você é o único administrador ativo, portanto não pode ser deletado!";
            $dados["display"] = "block";
            $dados["cor"] = "danger";
            $this->ver_perfil($dados["display"], $dados["msg"], $dados["cor"]);
        } else {
            if ($id != NULL && $id == $this->session->userdata("id")) {
                $where["id"] = $id;
                if ($this->Crud->delete("usuario", $where)) {
                    redirect("Inicio/deslogar");
                } else {
                    $this->ver_perfil("block", "Erro ao deletar.", "danger");
                }
            } else {
                redirect("Inicio");
            }
        }
    }

    public function changepsw_perfil($id = NULL, $v = NULL) {
        if ($id != NULL && $id == $this->session->userdata("id")) {
            try {
                $form = $this->input->post();
                if (!empty($form)) {
                    $display = "none";
                    $user["senha"] = sha1($form["changeSenha"]);
                    $where["id"] = $id;
                    if ($this->Crud->update("usuario", $user, $where)) {
                        $msg = "Senha atualizada!";
                        $display = "block";
                        $cor = "success";
                    } else {
                        $msg = "Erro ao atualizar no banco de dados, por favor contate os desenvolvedores!";
                        $display = "block";
                        $cor = "danger";
                    }
                    return $this->ver_perfil($display, $msg, $cor);
                } else {
                    $dados["url"] = base_url();
                    $dados["id"] = $id;
                    $dados["conteudo"] = $this->parser->parse("normal/usuario/mudar_senha", $dados, TRUE);
                    $this->index($dados);
                }
            } catch (GuzzleHttp\Exception\BadResponseException $ex) {
                $response = $ex->getResponse();
                $responseBodyAsString = $response->getBody()->getContents();
                $dados["msg"] = $responseBodyAsString;
                $dados["display"] = "block";
                $dados["cor"] = "danger";
                $this->index($dados);
            }
        } else {
            redirect("Inicio");
        }
    }

    public function gerenciar_usuarios($var = NULL) {
        if ($var != NULL) {
            $dados = $var;
        }
        if ($this->session->userdata("tipo") == "administrador") {
            $usuario = $this->Crud->select("usuario");
            foreach ($usuario as $key => $value) {
                if ($usuario[$key]["email"] == $this->session->userdata("email") && $usuario[$key]["id"] == $this->session->userdata("id")) {
                    unset($usuario[$key]);
                }
            }
            $dados["usuarios"] = $usuario;
            foreach ($dados["usuarios"] as $key => $value) {
                $dados["usuarios"][$key]["url"] = base_url();
                $dados["usuarios"][$key]["email1"] = urlencode($dados["usuarios"][$key]["email"]);
                if ($dados["usuarios"][$key]["ativo"] == 1) {
                    $dados["usuarios"][$key]["status"] = "Ativado";
                    $dados["usuarios"][$key]["cor2"] = "success";
                } else {
                    $dados["usuarios"][$key]["status"] = "Desativado";
                    $dados["usuarios"][$key]["cor2"] = "danger";
                }
                if ($dados["usuarios"][$key]["tipo"] == "normal") {
                    $dados["usuarios"][$key]["cor"] = "success";
                    $dados["usuarios"][$key]["tipo1"] = "moderador";
                    $dados["usuarios"][$key]["tipo2"] = "administrador";
                } else if ($dados["usuarios"][$key]["tipo"] == "moderador") {
                    $dados["usuarios"][$key]["cor"] = "primary";
                    $dados["usuarios"][$key]["tipo1"] = "normal";
                    $dados["usuarios"][$key]["tipo2"] = "administrador";
                } else {
                    $dados["usuarios"][$key]["cor"] = "danger";
                    $dados["usuarios"][$key]["tipo1"] = "moderador";
                    $dados["usuarios"][$key]["tipo2"] = "normal";
                }
            }
            $dados["modal_excluir"] = $dados["usuarios"];
            $dados["conteudo"] = $this->parser->parse("adm/usuario/gerenciar_usuarios", $dados, TRUE);
            return $this->index($dados);
        } else {
            redirect("Inicio");
        }
    }

    public function mudar_tipo($tipo = NULL, $id = NULL) {
        if ($id != NULL && $tipo != NULL && $this->session->userdata("tipo") == "administrador") {
            $where["id"] = $id;
            $user["tipo"] = $tipo;
            if ($this->Crud->update("usuario", $user, $where)) {
                $dados["display"] = "block";
                $dados["cor"] = "success";
                $dados["msg"] = 'Privilégios de usuário alterado para ' . $tipo;
            } else {
                $dados["display"] = "block";
                $dados["cor"] = "danger";
                $dados["msg"] = 'Erro ao mudar privilégios de usuário, por favor contate os desenvolvedores!';
            }
            return $this->gerenciar_usuarios($dados);
        } else {
            redirect("Inicio");
        }
    }

    public function deletar_usuario($id = NULL) {
        if ($id != NULL && $this->session->userdata("tipo") == "administrador" && $id != $this->session->userdata("id")) {
            $where["id"] = $id;
            if ($this->Crud->delete("usuario", $where)) {
                $dados["display"] = "block";
                $dados["msg"] = "Usuário deletado com sucesso!";
                $dados["cor"] = "success";
            } else {
                $dados["display"] = "block";
                $dados["msg"] = "Usuário deletado com sucesso!";
                $dados["cor"] = "success";
            }
            $this->gerenciar_usuarios($dados);
        } else {
            redirect("Inicio");
        }
    }

    public function editar_usuario($id = NULL) {
        if ($id != NULL && $this->session->userdata("tipo") == "administrador") {
            $form = $this->input->post();
            if (empty($form)) {

                $where["id"] = $id;
               
                $dados = $this->Crud->select("usuario", "*", $where)[0];
                $dados["url"] = base_url();
                $dados["id"] = $id;
                $dados["conteudo"] = $this->parser->parse("adm/usuario/editar_usuario", $dados, TRUE);
                return $this->index($dados);
            } else {
                    $where["id"] = $id;
                    if ($this->Crud->update("usuario", $form, $where)) {
                        $dados["msg"] = "Usuário Atualizado com sucesso";
                        $dados["display"] = "block";
                        $dados["cor"] = "success";
                        $this->gerenciar_usuarios($dados);
                    } else {
                        $dados["msg"] = "Erro ao atualizar usuário,consulte os desenvolvedores!";
                        $dados["display"] = "block";
                        $dados["cor"] = "danger";
                        return $this->gerenciar_usuarios($dados);
                    }
            }
        } else {
            redirect("Inicio");
        }
    }

    public function status_usuario($id = NULL, $ativo) {
        if ($this->session->userdata("tipo") == "administrador" && $id != NULL) {
            if ($ativo == 1 || $ativo == 0) {
              
                    $where["id"] = $id;
                    if ($ativo == 1) {
                        $ativo = 0;
                    } else {
                        $ativo = 1;
                    }
                    $user["ativo"] = $ativo;
                    if ($this->Crud->update("usuario", $user, $where)) {
                        $dados["msg"] = "Status do usuário atualizado com sucesso";
                        $dados["display"] = "block";
                        $dados["cor"] = "success";
                        return $this->gerenciar_usuarios($dados);
                    } else {
                        $dados["msg"] = "Erro ao atualizar status do usuário";
                        $dados["display"] = "block";
                        $dados["cor"] = "danger";
                        return $this->gerenciar_usuarios($dados);
                    }
               
            } else {
                redirect("Inicio/deslogar");
            }
        } else {
            redirect("Inicio/deslogar");
        }
    }

}

?>