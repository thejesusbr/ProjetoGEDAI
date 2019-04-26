 <h1><b>Mudar Senha:</b></h1>
 <form method="POST" action="{url}Inicio/changepsw/{id}/{email}/{sha1}">
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