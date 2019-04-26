<?php 
?>
<div class="row justify-content-end">
	<div class="col-sm-2">
		<a class="btn btn-warning btn-lg btn-block" href="{url}client/Eventos"><i class="fas fa-arrow-left"></i> Voltar</a>
	</div>
</div>

<div class="card" style="margin-top: 10px">
  <h5 class="card-header">Evento <span class="badge badge-{cor}">{status}</span></h5>
  <div class="card-body">
    <h5 class="card-title">{nome}</h5>
    <p class="card-text">{informacoes}</p>
    <p class="card-text">Local: {local}</p>
    <p class="card-text">Data: {data}</p>
    <p class="card-text">Hora: {hora}</p>
    <a href="{link}" class="btn btn-{cor2}">{seguir}</a>
  </div>
</div>