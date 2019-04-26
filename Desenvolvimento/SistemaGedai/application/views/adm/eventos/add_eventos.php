<div class="row justify-content-end">
	<div class="col-sm-2">
		<a class="btn btn-warning btn-lg btn-block" href="{url}client/Eventos/gerenciar_eventos"><i class="fas fa-arrow-left"></i> Voltar</a>
	</div>
</div>

<div class="row" style="margin-bottom: 10px">
    <div class="col">
        <h1>Adicionar Evento</h1>
    </div>
</div>

<form name="eventoForm" action="{url}client/Eventos/adicionar_evento" method="POST" >
    <div class="form-group row">
        <label for="nome" class="col-sm-2 col-form-label" >Nome do Evento:</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" ng-model="nome"  name="nome" ng-required="true" >
        </div>
    </div>
     <div class="form-group row">
        <label for="informacoes" class="col-sm-2 col-form-label">Informações sobre:</label>
        <div class="col-sm-10">
            <textarea class="form-control" ng-model="informacoes" name="informacoes" requerid></textarea>           
        </div>
    </div>
    <div class="form-group row">
        <label for="data" class="col-sm-2 col-form-label">Data: (dd/mm/aaaa)</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" ng-model="data" name="data" required min="{min}">           
        </div>
    </div>
    <div class="form-group row">
        <label for="hora" class="col-sm-2 col-form-label">Hora: (hh:mm)</label>
        <div class="col-sm-10">
            <input type="time" class="form-control" ng-model="hora" name="hora" required>           
        </div>
    </div>
    <div class="form-group row">
        <label for="local" class="col-sm-2 col-form-label">Local:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" ng-model="local" name="local" required>           
        </div>
    </div>
    <div class="form-group row justify-content-end">
        <button class="btn btn-primary btn-lg" ng-disabled="eventoForm.$invalid"> Adicionar </button>
    </div>
</form>