<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<ul class="navbar-nav align-self-end">
    <li class="nav-item active">
        <a class="btn btn-verde btn-lg nav-link"  data-toggle="modal" data-target="#loginModal" style="margin-right: 5px"> <i class="fas fa-sign-in-alt fa-sm"></i> Entrar</a>
    </li>	
    <li class="nav-item active">
        <a class="btn btn-verde btn-lg nav-link" data-toggle="modal" data-target="#cadastrarModal" style="margin-right: 5px"> <i class="fas fa-user-plus fa-sm"></i>  Cadastrar </a>
    </li>
</ul>

<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLongTitle">Entrar</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form  name="formLogin" method="POST" action="{url}Inicio/logar">
                <div class="modal-body">
                    <div class="form-group ">
                        <label for="email" >Email:</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Informe seu email" ng-model="email" ng-required="true">
                        <span class="badge badge-danger form-control" ng-show="(!formLogin.email.$pristine || formLogin.email.$touched) && formLogin.email.$invalid" >Por favor informe um e-mail válido!</span>
                    </div>
                    <div class="form-group ">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Informe sua senha" ng-model="senha" ng-required="true">
                        <span class="badge badge-danger form-control" ng-show="formLogin.senha.$touched && formLogin.senha.$invalid" > Digite a senha para logar no sistema!</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-link" href="{url}Inicio/esqueci">Esqueci minha senha</a>
                    <button type="submit" class="btn btn-success" ng-disabled="formLogin.$invalid" >Entrar</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="cadastrarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLongTitle">Cadastrar</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="formCadastro" method="post" action="{url}Inicio/cadastrar">

                <div class="modal-body">

                    <div class="form-group">
                        <label for="email">Nome:</label>
                        <input type="text" class="form-control" name="nome" id="nome" ng-model="nome" aria-describedby="nome" placeholder="Informe seu nome" ng-required="true" style="text-transform: capitalize;">
                        <span class="badge badge-danger form-control" ng-show="!formCadastro.nome.$pristine && formCadastro.nome.$invalid" >Por favor informe um nome!</span>
                    </div>
                    <div class="form-group">
                        <label for="email">Sobrenome:</label>
                        <input type="text" class="form-control" name="sobrenome" id="sobrenome" ng-model="sobrenome" aria-describedby="nome" placeholder="Informe seu sobre nome" ng-required="true" style="text-transform: capitalize;">
                        <span class="badge badge-danger form-control" ng-show="!formCadastro.sobrenome.$pristine && formCadastro.sobrenome.$invalid" >Por favor informe um nome!</span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="emailCad" id="emailCad" ng-model="emailCad" aria-describedby="emailCad" placeholder="Informe seu email" ng-required="true">
                        <span class="badge badge-danger form-control" ng-show="!formCadastro.emailCad.$pristine && formCadastro.emailCad.$invalid" >Por favor, Insira um email válido!</span>
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" name="senhaCad" id="senhaCad" ng-model="senhaCad" placeholder="Informe sua senha" ng-required="true" minlength="6">
                        <span class="badge badge-danger form-control" ng-show="!formCadastro.senhaCad.$pristine && formCadastro.senhaCad.$invalid" >Infrome uma senha válida e com no mínimo 6 caracteres!</span>
                    </div>
                    <div class="form-group">
                        <label for="senha">Repetir Senha:</label>
                        <input type="password" class="form-control" name="confirmaSenha" id="confirmaSenha" ng-model="confirmaSenha" placeholder="Repita sua senha" ng-required="true">
                        <span class="badge badge-danger form-control" ng-show="!formCadastro.confirmaSenha.$pristine && formCadastro.confirmaSenha.$invalid" >Porfavor repita sua senha!</span>
                    </div>
                    <div class="alert alert-{cor}" style="display: {display}"> {msg} </div>


                </div>

                <div class="modal-footer">
                    <button ng-disabled="formCadastro.$invalid" type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>