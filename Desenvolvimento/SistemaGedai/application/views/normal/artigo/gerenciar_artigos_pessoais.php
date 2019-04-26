<div class="row" style="margin-bottom: 10px">
    <div class="col">
        <h1>Gerenciamento de Artigos Pessoais</h1>
    </div>
</div>


<div class="table-responsive">
    <table id="tabela" class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Título</th>
                <th>Ativo</th>
                <th>Detalhes</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            {artigo}
            <tr>
                <td>{titulo}</td> 
                <td>{ativo}</td>
                <td>
                    <a class="btn btn-warning btn-block btn-lg" href="{url}client/Artigo/visualizar/{id}"> <i class="fas fa-eye"></i>  Detalhes </a>
                </td>
                <td>
                    <a class="btn btn-info btn-block btn-lg" href="{url}client/Artigo/editar_artigo_pessoal/{id}"><i class="fas fa-edit"></i> Editar</a>
                </td>
                <td>
                    <button data-toggle="modal" data-target="#exampleModal" class="btn btn-danger btn-block btn-lg" ><i class="fas fa-trash"></i> Excluir</button>
                </td>
            </tr>
            {/artigo}
        </tbody>
    </table>
</div>


{modal_excluir}
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deseja mesmo excluir o artigo "{titulo}"?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Junto com esse artigo serão excluidos todas as imagens e comentários relacionados a ele!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                <a class="btn btn-success" href="{url}client/Artigo/excluir_artigo_pessoal/{id}">Sim</a>
            </div>
        </div>
    </div>
</div>
{/modal_excluir}


<script>
    $(document).ready(function () {
        $('#tabela').DataTable({
            "oLanguage": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "Mostrando _MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            }
        });
    });

</script>