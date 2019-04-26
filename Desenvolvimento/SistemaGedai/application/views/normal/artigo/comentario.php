
<form method="POST" name="comentForm" action="{url}client/Artigo/comentar/{id_usuario}/{id_artigo}">
    <div class="form-group row">
        <label for="texto" class="col-sm-1 col-form-label">Comentar:</label>
        <div class="col-sm-11">
            <textarea name="texto" class="form-control" ng-model="texto" ng-required="true"></textarea>
        </div>
    </div>
    <div class="form-group row justify-content-end">
        <button class="btn btn-primary" ng-disabled="comentForm.$invalid" >Comentar</button>
    </div>
</form>