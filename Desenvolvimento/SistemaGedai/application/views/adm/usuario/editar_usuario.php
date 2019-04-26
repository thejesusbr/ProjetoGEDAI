<?php
defined("BASEPATH") OR exit("No direct access script allowed");
?>
<div class="row justify-content-end">
	<div class="col-sm-2">
		<a class="btn btn-warning btn-lg btn-block" href="{url}client/Usuario/gerenciar_usuarios"><i class="fas fa-arrow-left"></i> Voltar</a>
	</div>
</div>
<div class="row" style="margin-bottom: 20px">
	<div class="col-sm-9">
		<h1><b>Editar Usuário(a)</b></h1>
	</div>
</div>
<form method="POST" action="{url}client/Usuario/editar_usuario/{id}" style="font-size: 20px;">
	<div class="form-group row">
		<div class="col-sm-1  justify-content-end ">Nome:</div>
		<div class="col-sm-11">
			<input type="text" name="nome" class="form-control" value="{nome}">
		</div>
	</div>
	<div class="form-group row">
		<div class="label col-sm-1 col-form-label">Email:</div>
		<div class="col-sm-11">
			<input type="email" name="email" class="form-control" value="{email}">
		</div>
	</div>
	<div class="form-group row justify-content-end">
		<div class="col-sm-2">
			<button type="submit" class="btn btn-success btn-lg">Enviar</button>
		</div>
	</div>
	
</form>