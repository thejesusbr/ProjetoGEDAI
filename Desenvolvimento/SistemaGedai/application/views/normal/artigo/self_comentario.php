<div class="row" style="margin-top: 10px">
    <div class="col">
        <div class="card" style="margin-top: 10px">
            <p class="card-header"> <b>Meu comentáro:</b></p>
            <div class="card-body">
                <p class="card-text">{texto}</p>
            </div>
            <div class="row" style="margin: 10px">
                <div class="col text-right">  <button class='btn btn-danger' data-toggle='modal' data-target='#excluirModalMeuComentario'><i class='fas fa-trash'></i></button></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="excluirModalMeuComentario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLongTitle">Deseja mesmo excluir seu comentário?</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Esta ação é irreversível!
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" data-dismiss="modal">Não Excluir</button>
				<a class="btn btn-success" href="{url}client/Artigo/deletar_meu_comentario/{id}/{id_usuario}/{id_artigo}">Excluir</a>
			</div>

		</div>
	</div>
</div>