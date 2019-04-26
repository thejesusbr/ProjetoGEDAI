<div class="row">
	<div class="col">
		<h1>Gerenciamento de Usuários</h1>
	</div>
</div>
<div class="table-responsive">
	<table id="tabela" class="table table-striped table-bordered">
		<thead class="thead-dark">
			<tr>
				<th>Nome</th>
				<th>Email</th>
				<th>Privilégios</th>
                                <th>Status</th>
				<th>Editar</th>
				<th>Excluir</th>
			</tr>
		</thead>
		<tbody>
			{usuarios}
			<tr>
				<td>{nome}</td>
				<td>{email}</td>
				<td>
					<div class="dropdown">
						<button class="btn btn-{cor} dropdown-toggle btn-block" type="button" id="dropdownMenu{id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{tipo}
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenu{id}">
							<a class="dropdown-item" href="{url}client/Usuario/mudar_tipo/{tipo1}/{id}">{tipo1}</a>
							<a class="dropdown-item" href="{url}client/Usuario/mudar_tipo/{tipo2}/{id}">{tipo2}</a>
						</div>
					</div>
				</td>
                                <td>
                                    <a class="btn btn-{cor2} btn-block" href="{url}client/Usuario/status_usuario/{id}/{ativo}">{status}</a>
                                </td>
				<td>
					<a class="btn btn-info btn-block" href="{url}client/Usuario/editar_usuario/{id}"><i class="fas fa-edit"></i></a>
				</td>
				<td>
					<button class="btn btn-danger btn-block"  data-toggle="modal" data-target="#excluirModal{id}"><i class="fas fa-trash"></i></button>
					
				</td>
			</tr>
			{/usuarios}
		</tbody>
	</table>
</div>


{modal_excluir}
<!-- Modal -->
<div class="modal fade" id="excluirModal{id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLongTitle">Deseja mesmo excluir o(a) usuário(a) {nome}?</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Esta ação é irreversível!
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" data-dismiss="modal">Não Excluir</button>
				<a class="btn btn-success" href="{url}client/Usuario/deletar_usuario/{id}">Excluir Perfil</a>
			</div>

		</div>
	</div>
</div>
{/modal_excluir}

<script>
	$(document).ready(function() {
		$('#tabela').DataTable();
	} );

</script>