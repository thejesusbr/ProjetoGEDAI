<div class="row">
    <div class="col col-sm-4 align-self-start">
        <h1>Eventos</h1>
    </div>
</div>

<div class="row" style="margin-top: 10px">
    {vazio}
</div>


<div class="row" style="margin-top: 10px">
    <dir-pagination-controls max-size="3" boundary-links="true"></dir-pagination-controls>
</div>


<div class="row" ng-controller="listarEventos">
    <div class="col-sm-4" dir-paginate="dado in dados|itemsPerPage:6">
        <div class="card" style="min-height: 300px; max-height: 300px; margin: 10px">
            <div class="card-body">
                <h5 class="card-title">{{dado.nome}}</h5>
                <p class="card-text" >{{dado.informacoes}} ...</p>
                <p class="card-text">{{dado.data}}</p>
                <a href="{url}{{dado.link}}" class="btn btn-{{dado.cor}}" style="margin-top: 10px; margin-bottom:10px">{{dado.seguir}}</a>
                <a href="{url}client/Eventos/ver_evento/{{dado.id}}" class="btn btn-info"> Detalhes </a>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 10px">
    <dir-pagination-controls max-size="3" boundary-links="true"></dir-pagination-controls>
</div>
