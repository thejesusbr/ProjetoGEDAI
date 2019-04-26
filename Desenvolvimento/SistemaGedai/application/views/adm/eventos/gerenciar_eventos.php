<div class="row" style="margin-bottom: 10px">
    <div class="col">
        <h1>Gerenciamento de Eventos</h1>
    </div>
</div>

<a class="btn btn-primary" href="{url}client/Eventos/adicionar_evento" style="margin-bottom: 20px"><i class="fas fa-plus-square"></i> Novo Evento </a>

<div class="table-responsive">
    <table id="tabela" class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nome do Evento</th>
                <th>Status</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            {eventos}
            <tr>
                <td>{nome}</td>
                <td>
                    {status}
                </td>
                <td>
                    {data}
                </td>
                <td>
                    {hora}
                </td>
                <td>
                    <a class="btn btn-info btn-block" href="{url}client/Eventos/editar_evento/{id}"><i class="fas fa-edit"></i></a>
                </td>
                <td>
                    <button class="btn btn-danger btn-block"  data-toggle="modal" data-target="#excluirModal{id}"><i class="fas fa-trash"></i></button>

                </td>
            </tr>
            {/eventos}
        </tbody>
    </table>
</div>


{modal_excluir}
<!-- Modal -->
<div class="modal fade" id="excluirModal{id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle">Deseja mesmo excluir evento "{nome}"?</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Este evento será deletado mas os as fotos sobre o evento permanecerão no sistema!
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Não Excluir</button>
                <a class="btn btn-success" href="{url}client/Eventos/deletar_evento/{id}">Excluir Evento</a>
            </div>

        </div>
    </div>
</div>
{/modal_excluir}

<script>
    $(document).ready(function () {
        $('#tabela').DataTable();
    });

</script>