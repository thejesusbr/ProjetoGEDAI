<div class="row justify-content-end">
	<div class="col-sm-2">
		<a class="btn btn-warning btn-lg btn-block" href="{url}client/Eventos/gerenciar_eventos"><i class="fas fa-arrow-left"></i> Voltar</a>
	</div>
</div>

<div class="row" style="margin-bottom: 10px">
    <div class="col">
        <h1>Editar Evento</h1>
    </div>
</div>

<form name="eventoForm" action="{url}client/Eventos/editar_evento/{id}" method="POST" >
    <div class="form-group row">
        <label for="nome" class="col-sm-2 col-form-label" >Nome do Evento:</label>
        <div class="col-sm-10">
            <input type="text" value="{nome}" class="form-control" name="nome" required >
        </div>
    </div>
     <div class="form-group row">
        <label for="informacoes" class="col-sm-2 col-form-label">Informações sobre:</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="informacoes" requerid >{informacoes}</textarea>           
        </div>
    </div>
    <div class="form-group row">
        <label for="data" class="col-sm-2 col-form-label">Data: (dd/mm/aaaa)</label>
        <div class="col-sm-10">
            <input type="date" class="form-control"  name="data" required value="{data}" min="{min}" >           
        </div>
    </div>
    <div class="form-group row">
        <label for="hora" class="col-sm-2 col-form-label">Hora: (hh:mm)</label>
        <div class="col-sm-10">
            <input type="time" class="form-control"  name="hora" required value="{hora}">           
        </div>
    </div>
    <div class="form-group row">
        <label for="local" class="col-sm-2 col-form-label">Local:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="local" required value="{local}">           
        </div>
    </div>
    <div class="form-group row justify-content-end">
        <button class="btn btn-primary btn-lg" ng-disabled="eventoForm.$invalid"> Editar </button>
    </div>
</form>