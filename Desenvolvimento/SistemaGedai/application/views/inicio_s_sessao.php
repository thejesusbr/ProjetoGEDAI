<?php ?>
<div class="row" style="margin-bottom: 40px">
    <h1>Sobre o Projeto</h1>
    <p style="text-align: justify"> O projeto GEDAI tem a finalidade de expôr artigos e eventos astronômicos que acontecem no CEFET-MG Campus Varginha</p>

</div>
<div class="row">
    <div class="col-sm-4">
        <h1>Eventos</h1>
        {eventos}
        <div class="row" style="margin-top: 10px">
            <div class="card" style="min-height: 300px; max-height: 300px; margin: 10px">
                <div class="card-body">
                    <h5 class="card-title">{nome}</h5>
                    <p class="card-text" >{informacoes} ...</p>
                    <p class="card-text">{data}</p>
                    <a href="#" class="btn btn-secondary" style="margin-top: 10px; margin-bottom:10px" data-toggle="modal" data-target="#cadastrarModal" >Cadastre-se para seguir evento</a>
                    <a href="{url}client/Eventos/ver_evento/{id}" class="btn btn-info"> Detalhes </a>
                </div>
            </div>
        </div>
        {/eventos}
    </div>
    
    <div class="col-sm-8">
        <h1>Artigos</h1>
        {artigos}
        <div class="col align-self-center" style="margin-top: 10px">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{titulo}</h5>
                    <p class="card-text" ><b>Objetivo</b>: {objetivo}</p>
                    <div class="position-relative fixed-bottom">
                        <div class="col text-right align-self-end" >
                            <a href="{url}client/Artigo/visualizar/{id}" class="btn btn-info"> Ler Artigo </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {/artigos}
    </div>
</div>

