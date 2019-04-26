<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul class="navbar-nav my-lg-0">
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:whitesmoke">
           <i class="fas fa-newspaper fa-sm"></i> Meus Artigos
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{url}client/Artigo/novo_artigo"><i class="fas fa-plus-square fa-sm"></i> Novo Artigo</a>
            <a class="dropdown-item" href="{url}client/Artigo/gerenciar_artigos_pessoais"><i class="fas fa-eye fa-sm"></i> Gerenciar </a>
        </div>
    </li>
    <li class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:whitesmoke">
            <i class="fas fa-user fa-sm"></i> Perfil
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{url}client/Usuario/ver_perfil/"> Visualizar Perfil </a>
            <a class="dropdown-item" href="{url}Inicio/deslogar/">Sair</a>
        </div>
    </li>
</ul>