<div class="row">
    <div class="col col-sm-4 align-self-start">
        <h1>Artigos</h1>
    </div>
</div>


<div class="row" style="margin-top: 10px">
    <dir-pagination-controls max-size="3" boundary-links="true"></dir-pagination-controls>
</div>


<div class="section" ng-controller="listarArtigos">
    <div class="div" dir-paginate="artigo in artigos | itemsPerPage:6">
        <div class="row" style="margin: 10px">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{artigo.titulo}}</h5>
                        <p class="card-text" ><b>Objetivo</b>: {{artigo.objetivo}} ...</p>
                        <div class="position-relative fixed-bottom">
                            <div class="col text-right align-self-end" >
                                <a href="{url}client/Artigo/visualizar/{{artigo.id}}" class="btn btn-info"> Ler Artigo </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 10px">
    <dir-pagination-controls max-size="3" boundary-links="true"></dir-pagination-controls>
</div>
