<?php

defined('BASEPATH') OR exit('No direct scrpit direct access allowed');

Class Artigo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index($dados = array()) {
        $dados["url"] = base_url();
        $dados["conteudo"] = $this->parser->parse("normal/artigo/listar_artigos", $dados, TRUE);
        return $this->layout($dados);
    }

    public function todos_artigos() {
        $where["ativo"] = 1;
        $artigos = $this->Crud->select("artigo", "*", $where);
        echo json_encode($artigos);
    }

    public function atualiza_sessao($array = array()) {
        $sessao = $this->session->userdata();
        $sessao["mensagens"] = $array;
        $this->session->set_userdata($sessao);
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
            return $this->parser->parse("layout", $dados);
        } else {
            redirect("Inicio");
        }
    }

    public function novo_artigo() {
        if (!empty($this->session->get_userdata("id"))) {
            $form = $this->input->post();
            if (!empty($form)) {
                $this->form_validation->set_data($form);
                $this->form_validation->set_rules("titulo", "TITULO", "required");
                $this->form_validation->set_rules("conteudo", "CONTEUDO", "required");
                if ($this->form_validation->run() != false) {
                    if (empty($form["autor"])) {
                        $form["autor"] = $this->session->userdata("nome");
                    }
                    $form["ativo"] = 0;
                    $form["id_usuario"] = $this->session->userdata("id");
                    if ($this->Crud->insere("artigo", $form)) {
                        print_r($this->session->userdata("images"));
                        $dados["msg"] = "Artigo inserido com sucesso";
                        $dados["display"] = "block";
                        $dados["cor"] = "success";
                    } else {
                        $dados["msg"] = "Erro no banco de dados, por favor consulte um desenvolvedor!";
                        $dados["display"] = "block";
                        $dados["cor"] = "danger";
                    }
                    $this->atualiza_sessao($dados);
                    redirect("client/Artigo/gerenciar_artigos_pessoais");
                }
            } else {
                $dados["url"] = base_url();
                $dados["conteudo"] = $this->parser->parse("normal/artigo/novo_artigo", $dados, TRUE);
                return $this->layout($dados);
            }
        } else {
            redirect("Inicio");
        }
    }

    public function editar_artigo_pessoal($id = NULL) {
        $where["id"] = $id;
        $id_confere = $this->Crud->select("artigo", "id_usuario", $where)[0]["id_usuario"];
        if ($id != NULL && !empty($this->session->userdata("id")) && $this->session->userdata("id") == $id_confere) {
            $form = $this->input->post();
            if (empty($form)) {
                $dados["url"] = base_url();
                $where["id"] = $id;
                $dados["artigo"] = $this->Crud->select("artigo", "*", $where);
                $dados["id"] = $id;
                $dados["conteudo"] = $this->parser->parse("normal/artigo/editar_artigo", $dados, TRUE);
                return $this->layout($dados);
            } else {
                $where["id"] = $id;
                $this->form_validation->set_data($form);
                $this->form_validation->set_rules("titulo", "TITULO", "required");
                $this->form_validation->set_rules("autor", "AUTOR", "required");
                $this->form_validation->set_rules("conteudo", "CONTEUDO", "required");
                if ($this->form_validation->run()) {
                    if ($this->Crud->update("artigo", $form, $where)) {
                        $message["msg"] = "Artigo Editado com Sucesso";
                        $message["display"] = "block";
                        $message["cor"] = "success";
                    } else {
                        $message["msg"] = "Erro ao editar arquivo";
                        $message["display"] = "block";
                        $message["cor"] = "danger";
                    }
                }
            }
            $this->atualiza_sessao($message);
            redirect("client/Artigo/gerenciar_artigos_pessoais");
        }
    }

    public function excluir_artigo_pessoal($id = NULL) {
        $where["id"] = $id;
        $id_confere = $this->Crud->select("artigo", "id_usuario", $where)[0]["id_usuario"];
        if ($id != NULL && !empty($this->session->userdata("id")) && $this->session->userdata("id") == $id_confere) {
            if ($this->Crud->delete("artigo", $where)) {
                $message["msg"] = "Artigo deletado com sucesso";
                $message["display"] = "block";
                $message["cor"] = "success";
            } else {
                $message["msg"] = "Erro ao deletar artigo.";
                $message["display"] = "block";
                $message["cor"] = "danger";
            }
            $this->atualiza_sessao($message);
            redirect("client/Artigo/gerenciar_artigos_pessoais");
        }
    }

    public function gerenciar_artigos_pessoais() {
        if (!empty($this->session->userdata("id"))) {
            $dados["url"] = base_url();
            $where['id_usuario'] = $this->session->userdata("id");
            $dados["artigo"] = $this->Crud->select("artigo", "*", $where);
            foreach ($dados["artigo"] as $key => $value) {
                $dados["artigo"][$key]["url"] = base_url();
                if ($dados["artigo"][$key]["ativo"] == 0) {
                    $dados["artigo"][$key]["ativo"] = "Não";
                } else {
                    $dados["artigo"][$key]["ativo"] = "Sim";
                }
            }
            $dados["modal_excluir"] = $dados["artigo"];
            $dados["conteudo"] = $this->parser->parse("normal/artigo/gerenciar_artigos_pessoais", $dados, TRUE);
            return $this->layout($dados);
        }
    }

    public function visualizar($id = NULL) {
        if ($id != NULL) {
            $where["id"] = $id;
            $dados["artigo"] = $this->Crud->select("artigo", "*", $where);
            $dados["url"] = base_url();
            $where2["id_artigo"] = $id;
            $dados["modal_excluir"] = array();
            $dados["comentarios"] = $where2["id_usuario"] = $this->session->userdata("id");
            $dados["comentarios"] = $this->Crud->comentarios($id);
            if ($this->session->userdata("tipo") == "administrador" || $this->session->userdata("tipo") == "moderador") {
                foreach ($dados["comentarios"] as $key => $value) {
                    $dados["comentarios"][$key]["botao"] = "<button class='btn btn-danger' data-toggle='modal' data-target='#excluirModal" . $dados["comentarios"][$key]["id"] . "'><i class='fas fa-trash'></i></button>";
                    $dados["comentarios"][$key]["url"] = base_url();
                    $dados["comentarios"][$key]["id_artigo"] = $id;
                }
                $dados["modal_excluir"] = $dados["comentarios"];
            } else {
                foreach ($dados["comentarios"] as $key => $value) {
                    $dados["comentarios"][$key]["botao"] = " ";
                }
            }
            $where2["id_usuario"] = $this->session->userdata("id");
            $tem_coment = $this->Crud->select("comentario", "*", $where2);
            if (!empty($tem_coment)) {
                $self["url"] = base_url();
                $self["id_usuario"] = $this->session->userdata("id");
                $self["id"] = $tem_coment[0]["id"];
                $self["id_artigo"] = $id;
                $self["texto"] = $tem_coment[0]["texto"];
                $dados["comentario_form"] = $this->parser->parse("normal/artigo/self_comentario", $self, TRUE);
            } else if (!empty($this->session->userdata("id"))) {
                $coment["url"] = base_url();
                $coment["id_artigo"] = $id;
                $coment["id_usuario"] = $this->session->userdata("id");
                $dados["comentario_form"] = $this->parser->parse("normal/artigo/comentario", $coment, TRUE);
            } else {
                $dados["comentario_form"] = "<span class='badge' style='background-color: #100049; color: white' > <h5> Cadastre-se no sistema para comentar em artigos. </h5> </span>";
            }
            $dados["conteudo"] = $this->parser->parse("normal/artigo/detalhes", $dados, TRUE);
            $up["views"] = intval($this->Crud->select("artigo", "views", $where)[0]["views"]);
            $up["views"] += 1;
            $this->Crud->update("artigo", $up, $where);
            return $this->layout($dados);
        } else {
            return redirect("Inicio");
        }
    }

    public function imagem_upload() {

        // Allowed origins to upload images
        $accepted_origins = array("http://localhost", "http://107.161.82.130", "http://codexworld.com");

        // Images upload path
        $imageFolder = "images/";

        reset($_FILES);
        $temp = current($_FILES);
        if (is_uploaded_file($temp['tmp_name'])) {
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                // Same-origin requests won't set an origin. If the origin is set, it must be valid.
                if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
                    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
                } else {
                    header("HTTP/1.1 403 Origin Denied");
                    return;
                }
            }

            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
                header("HTTP/1.1 400 Invalid file name.");
                return;
            }

            // Verify extension
            if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }

            // Accept upload if there was no origin, or if it is an accepted origin
            $filetowrite = $imageFolder . $temp['name'];
            move_uploaded_file($temp['tmp_name'], $filetowrite);

            // Respond to the successful upload with JSON.
            echo json_encode(array('location' => $filetowrite));
        } else {
            header("HTTP/1.1 500 Server Error");
        }
    }

    public function gerenciar_artigos() {
        if (!empty($this->session->userdata("id")) && ($this->session->userdata("tipo") == "administrador" || $this->session->userdata("tipo") == "moderador")) {
            $dados["url"] = base_url();
            $dados["artigo"] = $this->Crud->select("artigo");
            foreach ($dados["artigo"] as $key => $value) {
                $dados["artigo"][$key]["url"] = base_url();
                if ($dados["artigo"][$key]["ativo"] == 0) {
                    $dados["artigo"][$key]["ativo"] = "Não";
                    $dados["artigo"][$key]["corAtivo"] = "danger";
                    $dados["artigo"][$key]["func"] = "ativar_artigo";
                } else {
                    $dados["artigo"][$key]["ativo"] = "Sim";
                    $dados["artigo"][$key]["corAtivo"] = "success";
                    $dados["artigo"][$key]["func"] = "desativar_artigo";
                }
            }
            $dados["modal_excluir"] = $dados["artigo"];
            $dados["conteudo"] = $this->parser->parse("adm/artigo/gerenciar_artigos", $dados, TRUE);
            return $this->layout($dados);
        }
    }

    public function editar_artigo($id = NULL) {
        if ($id != NULL && !empty($this->session->userdata("id")) && ($this->session->userdata("tipo") == "administrador" || $this->session->userdata("tipo") == "moderador")) {
            $form = $this->input->post();
            if (empty($form)) {
                $dados["url"] = base_url();
                $where["id"] = $id;
                $dados["artigo"] = $this->Crud->select("artigo", "*", $where);
                $dados["id"] = $id;
                $dados["conteudo"] = $this->parser->parse("adm/artigo/editar_artigo", $dados, TRUE);
                return $this->layout($dados);
            } else {
                $where["id"] = $id;
                $this->form_validation->set_data($form);
                $this->form_validation->set_rules("titulo", "TITULO", "required");
                $this->form_validation->set_rules("autor", "AUTOR", "required");
                $this->form_validation->set_rules("conteudo", "CONTEUDO", "required");
                if ($this->form_validation->run()) {
                    if ($this->Crud->update("artigo", $form, $where)) {
                        $message["msg"] = "Artigo Editado com Sucesso";
                        $message["display"] = "block";
                        $message["cor"] = "success";
                    } else {
                        $message["msg"] = "Erro ao editar arquivo";
                        $message["display"] = "block";
                        $message["cor"] = "danger";
                    }
                }
            }
            $this->atualiza_sessao($message);
            redirect("client/Artigo/gerenciar_artigos");
        }
    }

    public function excluir_artigo($id) {
        if ($id != NULL && !empty($this->session->userdata("id")) && ($this->session->userdata("tipo") == "administrador" || $this->session->userdata("tipo") == "moderador")) {
            if ($this->Crud->delete("artigo", "id=" . $id)) {
                $message["msg"] = "Artigo deletado com sucesso";
                $message["display"] = "block";
                $message["cor"] = "success";
            } else {
                $message["msg"] = "Erro ao deletar artigo.";
                $message["display"] = "block";
                $message["cor"] = "danger";
            }
            $this->atualiza_sessao($message);
            redirect("client/Artigo/gerenciar_artigos_pessoais");
        }
    }

    public function ativar_artigo($id = NULL) {
        if ($id != NULL && ($this->session->userdata("tipo") == "administrador" || $this->session->userdata("tipo") == "moderador")) {
            $where["id"] = $id;
            $dados["ativo"] = 1;
            if ($this->Crud->update("artigo", $dados, $where)) {
                $atualiza["msg"] = "Artigo ativado com sucesso!";
                $atualiza["cor"] = "success";
                $atualiza["display"] = "block";
            } else {
                $atualiza["msg"] = "Erro ao ativar artigo";
                $atualiza["cor"] = "danger";
                $atualiza["display"] = "block";
            }
            $this->atualiza_sessao($atualiza);
            redirect("client/Artigo/gerenciar_artigos");
        }
    }

    public function desativar_artigo($id = NULL) {
        if ($id != NULL && ($this->session->userdata("tipo") == "administrador" || $this->session->userdata("tipo") == "moderador")) {
            $where["id"] = $id;
            $dados["ativo"] = 0;
            if ($this->Crud->update("artigo", $dados, $where)) {
                $atualiza["msg"] = "Artigo desativado com sucesso!";
                $atualiza["cor"] = "warning";
                $atualiza["display"] = "block";
            } else {
                $atualiza["msg"] = "Erro ao ativar artigo";
                $atualiza["cor"] = "danger";
                $atualiza["display"] = "block";
            }
            $this->atualiza_sessao($atualiza);
            redirect("client/Artigo/gerenciar_artigos");
        }
    }

    public function comentar($id_usuario = NULL, $id_artigo = NULL) {
        if ($id_artigo != NULL && $id_usuario == $this->session->userdata("id")) {
            $form = $this->input->post();
            $form["id_usuario"] = $id_usuario;
            $form["id_artigo"] = $id_artigo;
            print_r($form);
            if ($this->Crud->insere("comentario", $form)) {
                $message["msg"] = "Comentado com sucesso!";
                $message["display"] = "block";
                $message["cor"] = "success";
            } else {
                $message["msg"] = "Erro ao inserir comentário!";
                $message["display"] = "block";
                $message["cor"] = "danger";
            }
            $this->atualiza_sessao($message);
            redirect("client/Artigo/visualizar/" . $id_artigo);
        }
    }

    public function deletar_meu_comentario($id_comentario = NULL, $id_usuario = NULL, $id_artigo = NULL) {
        if ($id_comentario != NULL && $id_usuario == $this->session->userdata("id")) {
            $where["id"] = $id_comentario;
            $where["id_usuario"] = $id_usuario;
            if ($this->Crud->delete("comentario", $where)) {
                $message["cor"] = "success";
                $message["display"] = "block";
                $message["msg"] = "Seu comentário foi deletado!!";
            } else {
                $message["cor"] = "danger";
                $message["display"] = "block";
                $message["msg"] = "Erro ao deletar seu comentário, consulte um desenvolvedor!";
            }
            $this->atualiza_sessao($message);
            redirect("client/Artigo/visualizar/" . $id_artigo);
        }
    }
    
    public function deletar_comentario($id_comentario = NULL, $id_artigo = NULL) {
        if ($id_comentario != NULL && ($this->session->userdata("tipo") == "administrador" || $this->session->userdata("tipo") == "moderador")) {
            $where["id"] = $id_comentario;
            if ($this->Crud->delete("comentario", $where)) {
                $message["cor"] = "success";
                $message["display"] = "block";
                $message["msg"] = "Comentário deletado com sucesso!!";
            } else {
                $message["cor"] = "danger";
                $message["display"] = "block";
                $message["msg"] = "Erro ao deletar comentário, consulte um desenvolvedor!";
            }
            $this->atualiza_sessao($message);
            redirect("client/Artigo/visualizar/" . $id_artigo);
        }
    }
}
?>