<div class="row">
    <div class="col col-sm-4 align-self-start">
        <h1>Artigos</h1>
    </div>
</div>


<div class="row" style="margin-top: 10px">
    <dir-pagination-controls max-size="3" boundary-links="true"></dir-pagination-controls>
</div>


<div class="row" ng-controller="listarArtigos">
    <div class="col-sm-4" dir-paginate="artigo in artigos | itemsPerPage:6">
        <div class="card" style="min-height: 300px; max-height: 300px; margin: 10px">
            <div class="card-body">
                <h5 class="card-title">{{artigo.titulo}}</h5>
                <p class="card-text" >{{artigo.objetivo}} ...</p>
                <a href="{url}client/Artiho/ler_artigo/{{artigo.id}}" class="btn btn-info"> Ler Artigo </a>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 10px">
    <dir-pagination-controls max-size="3" boundary-links="true"></dir-pagination-controls>
</div>
