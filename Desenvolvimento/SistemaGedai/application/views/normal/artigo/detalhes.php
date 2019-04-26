<?php ?>

<div class="row">
    <div class="col">
        <div class="card" style="margin-top: 10px">
            {artigo}
            <h5 class="card-header">Artigo feito por: {autor}</h5>
            <div class="card-body">
                <h4 class="card-title" style="text-align: center">{titulo}</h4>
                <h5 class="card-title text-right"></h5>
                <p class="card-text">{conteudo}</p>
            </div>
            {/artigo}
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <h3 style="margin-top: 60px">Comentários: </h3>
    </div>
</div>
<div class="row" style="margin-top: 10px"> 
    <div class="col">
        {comentario_form}
    </div>
</div>

{comentarios}
<div class="row" style="margin-top: 10px">
    <div class="col">
        <div class="card" style="margin-top: 10px">
            <p class="card-header"> <b>{nome}</b></p>
            <div class="card-body">
                <p class="card-text">{texto}</p>
            </div>
            <div class="row" style="margin: 10px">
                <div class="col text-right"> {botao} </div>
            </div>
        </div>
    </div>
</div>
{/comentarios}

{modal_excluir}
<div class="modal fade" id="excluirModal{id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle">Deseja mesmo excluir este comentário?</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Esta ação é irreversível!
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Não Excluir</button>
                <a class="btn btn-success" href="{url}client/Artigo/deletar_comentario/{id}/{id_artigo}">Excluir</a>
            </div>

        </div>
    </div>
</div>
{/modal_excluir}