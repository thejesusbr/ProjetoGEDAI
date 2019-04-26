<?php
defined("BASEPATH") OR exit("No direct access script allowed");
?>

<div class="row" style="margin-bottom: 20px">
	<div class="col">
		<h1><b>Seu Perfil</b></h1>
	</div>
</div>
<div class="row" style="margin-bottom: 60px">
	<div class="col">
		<a class="btn btn-info btn-lg" href="{url}client/Usuario/editar_perfil/{id}" style="margin-top: 20px">Editar Perfil</a>
		<a class="btn btn-info btn-lg" href="{url}client/Usuario/changepsw_perfil/{id}" style="margin-top: 20px">Mudar Senha</a>
		<button class="btn btn-danger btn-lg"  data-toggle="modal" data-target="#excluirModal" style="margin-top: 20px">Excluir Perfil</button>
	</div>
</div>

<div class="modal fade" id="excluirModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLongTitle">Deseja mesmo excluir seu perfil?</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Seus artigos continuarão no sistema!
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" data-dismiss="modal">Não Excluir</button>
				<a href="{url}client/Usuario/deletar_perfil/{id}" class="btn btn-success">Excluir</a>
			</div>

		</div>
	</div>
</div>

<div class="form" action="#" style="font-size: 20px;">
	<div class="form-group row">
		<div class="col-sm-2  justify-content-end ">Nome:</div>
		<div class="col-sm-10">
			<input type="text" name="nome" class="form-control" value="{nome}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<div class="label col-sm-2 col-form-label">Email:</div>
		<div class="col-sm-10">
			<input type="text" name="email" class="form-control" value="{email}" disabled>
		</div>
	</div>
	<div class="form-group row">
		<div class="label col-sm-2 col-form-label">Usuario:</div>
		<div class="col-sm-10">
			<input type="text" name="tipo" class="form-control" value="{tipo}" disabled>
		</div>
	</div>
</div>