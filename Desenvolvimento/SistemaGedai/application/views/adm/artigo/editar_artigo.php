<div class="row justify-content-end">
    <div class="col-sm-2">
        <a class="btn btn-warning btn-lg btn-block" href="{url}client/Artigo/gerenciar_artigos"><i class="fas fa-arrow-left"></i>Voltar</a>
    </div>
</div>

<div class="row" style="margin-bottom: 10px">
    <div class="col">
        <h1>Editar Artigo</h1>
    </div>
</div>



<form method="POST" action="{url}client/Artigo/editar_artigo/{id}" >
    {artigo}
    <div class="form-group">
        <label>Título:</label>
        <input type="text" name="titulo"  value="{titulo}" class="form-control">
    </div>
    <div class="form-group">
        <label>Autores: (caso não seja preenchido, o sistema usará seu nome)</label>
        <input type="text" name="autor" class="form-control"  value="{autor}">
    </div>
     <div class="form-group">
        <label>Objetivo: (Seja breve, use no máximo 200 caracteres)</label>
        <textarea class="form-control" name="objetivo" maxlength="200" required>{objetivo}</textarea>
    </div>
    <div class="form-group">
        <label>Texto:</label>
        <textarea id="conteudo" name="conteudo" class="form-control">{conteudo}</textarea>
    </div>
    <div class="form-group row justify-content-end">
        <button class="btn btn-primary btn-lg" > Editar </button>
    </div>
    {/artigo}
</form>

<script type="text/javascript">
    tinymce.init({
        selector: '#conteudo',
        relative_urls: false,
        remove_script_host: false,
        document_base_url: '{url}',
        language: 'pt_BR',
        height: 600,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'template paste textcolor colorpicker textpattern image code imagetools codesample toc help'
        ],
        toolbar1: 'undo redo | insert | image code | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link ',
        toolbar2: 'print preview | forecolor backcolor |  help',
        image_advtab: true,
        image_caption: true,
        images_upload_url: "{url}client/Artigo/imagem_upload",
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{url}client/Artigo/imagem_upload');

            xhr.onload = function () {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        }
    });

</script>   