<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">



        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>


        <link rel="stylesheet" type="text/css" href="{url}assets/node_modules/bootstrap/dist/css/bootstrap.css">
        <script type="text/javascript" src="{url}assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="{url}assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="{url}assets/node_modules/data_tables/datatables.min.css"/>
        <script type="text/javascript" src="{url}assets/node_modules/data_tables/datatables.min.js"></script>


        <script type="text/javascript" src="{url}assets/node_modules/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.2/angular.min.js"></script>

        <script type="text/javascript" src="{url}assets/node_modules/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="{url}assets/js/dirPagination.js" ></script>
        <script type="text/javascript" src="{url}assets/js/app.js" ></script>

        <title>GEDAI</title>
    </head>
    <body ng-app="app">
        <!-- Banner -->
        <img src="{url}assets/img/banner.png" class="img-fluid" width="100% \9">
        <!-- NavBar -->
        <nav class="navbar navbar-expand-lg navbar-dark" style="font-size: 20px;background-color: #162B16">
            <a class="navbar-brand" href="#"><i class="fab fa-grav fa-2x"></i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{url}Inicio">Início </a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link active" href="{url}client/Artigo">Artigos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{url}client/Eventos">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{url}Inicio/sobre">Sobre o Projeto</a>
                    </li>
                </ul>

                {menu}

            </div>
        </nav>	



        <!-- Corpo -->
        <div class="container" style="padding: 60px">
            <div class="row">
                <div class="col-sm-12 alert alert-{cor}" style="display: {display}"> 
                    {msg}
                </div>
            </div>
            {conteudo}
        </div>


    </body>
</html>