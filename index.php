<?php

include_once 'header.php';
include_once "private/Usuario.php";


if (!isset($_SESSION['id'])) {
    header('Location: ./private/login.php');
    exit;
}

$users = new Usuario();
$allUsers = $users->getAllUsers();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./lib/bootstrap-5.3.2-dist/css/bootstrap.css" />
    <link rel="stylesheet" href="./lib/fontawesome-free-6.4.2-web/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <title>Sistema de gestao de usuarios</title>
</head>

<body class="body">
    <!-- Start nav bar -->
    <div class="position-fixed top-0 z-2">
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm px-5 py-2">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand fs-3" href="#">Sistema de Registro de Usuarios</a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">

                </div>
                <div class="d-flex me-5 align-items-center gap-3">
                    <a style="color:black;"
                        href="./private/viewSingle.php?id=<?php echo $_SESSION['id']; ?>"
                        class="mb-0 text-capitalize link-offset-2 link-underline link-underline-opacity-0">
                        <?php echo $_SESSION['username']; ?>
                    </a>
                    <a style="color:black;"
                        href="./private/viewSingle.php?id=<?php echo $_SESSION['id']; ?>"
                        class="mb-0 text-capitalize link-offset-2 link-underline link-underline-opacity-0">
                        <img class="profile-img" src="
          <?php if (!file_exists('./images/'.$_SESSION['id'].'/'.$_SESSION['pic'])) {
              echo './images/default/default.png';
          } else {
              echo './images/'.$_SESSION['id'].'/'.$_SESSION['pic'];
          }?>" />
                    </a>

                </div>
                <a href="private/logout.php" class="btn btn-outline-success fs-6">
                    <span class="px-3">Sair</span>
                    <i class="fa-solid fa-right-from-bracket"> </i>
                </a>
            </div>
        </nav>
    </div>
    <!-- end navbar -->
    <!-- start content -->
    <div class="container d-flex justify-content-end bg-dark p-2 m-top-nav rounded">
        <a href="private/registar.php"
            class="d-flex justify-content-between align-items-center link-offset-2 link-underline link-underline-opacity-0 w-25 ps-2 fs-5 btn btn-outline-light">
            <span class="ms-2">Novo Registo</span>
            <i class="fa-solid fa-circle-plus"></i>
        </a>
    </div>
    <div class="container p-5 bg-white shadow-sm">
        <table class="table table-hover">
            <thead>
                <tr class="fs-4">
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contacto</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Criado</th>
                    <th scope="col">Actualizado</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="table-group-divider">

                <?php
foreach ($allUsers as $user) {
    extract($user);
    echo ' 
      <tr>
        <td>'.$nome_usuario.'</td>
        <td>'.$email.'</td>
        <td>'.$telefone.'</td>
        <td>'.$morada.'</td>
        <td>'.$created_at.'</td>
        <td>'.$updated_at.'</td>
        <td class="">
          <a class="btn btn-outline-secondary px-3 w-100 d-flex justify-content-around align-items-center text-dark link-offset-2 link-underline link-underline-opacity-0" href="./private/viewSingle.php?id='.$id.'">Detalhes<i class="fa-solid fa-arrow-up-right-from-square fs-5"> </i></a>
        </td>
      </tr>'
    ;
}
?>
            </tbody>
        </table>
    </div>
    <script src="./lib/fontawesome-free-6.4.2-web/js/all.min.js">
    </script>
    <script src="./lib/bootstrap-5.3.2-dist/js/bootstrap.js">
    </script>
    <?php
include_once 'footer.php';
?>