 <div class="row justify-content-end">
 	<div class="col-sm-2">
 		<a class="btn btn-warning btn-lg btn-block" href="{url}client/Usuario/ver_perfil/{id}"><i class="fas fa-arrow-left"></i> Voltar</a>
 	</div>
 </div>

 <h1><b>Mudar Senha:</b></h1>
 <form method="POST" action="{url}client/Usuario/changepsw_perfil/{id}">
 	<div class="form-group ">
 		<input type="password" class="form-control" id="changeSenha" name="changeSenha" aria-describedby="changeSenha" placeholder="Informe sua nova senha" required>
 	</div>
 	<div class="form-group ">
 		<input type="password" class="form-control" id="repeatSenha" name="repeatSenha" aria-describedby="repeatSenha" placeholder="Repita sua nova senha" required>
 	</div>
 	<div class="form-group ">
 		<button type="submit" class="btn btn-success">Mudar</button>
 	</div>
 </form>