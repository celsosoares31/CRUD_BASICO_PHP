<?php include_once '../header.php';
require_once "Usuario.php";

$formData = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (!empty($formData['btnEntrar'])) {
    extract($formData);

    $loggedUser = new Usuario();
    $usrLogin = $loggedUser->getUserByEmail($email);
    if(!isset($usrLogin['errorMsg'])) {
        extract($usrLogin);
        if (password_verify($senhaInput, $senha)) {
            $_SESSION['id'] = $id;
            $_SESSION['pic'] = $foto_perfil;
            $_SESSION['username'] = $nome_usuario;

            header('Location: ../index.php');
            echo "yes....";
            exit;
        } else {
            print_error('Usuario ou senha invalidos', 'danger');
            header('refresh:1; url = login.php');
        }
    } else {
        print_error($usrLogin['errorMsg'], 'danger');
        header('refresh:1; url = login.php');

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../lib/bootstrap-5.3.2-dist/css/bootstrap.css" />
    <link rel="stylesheet" href="../lib/fontawesome-free-6.4.2-web/css/all.min.css" />
    <link rel="stylesheet" href="../style.css">
    <title>Login</title>
</head>

<body class="bg-light">
    <form class="form w-25 shadow rounded bg-white p-5" method="post">
        <div class="px-2 mb-4">
            <p class="h2 text-uppercase py-0 text-center">login</p>
            <hr class="py-0 my-0">
        </div>
        <div class="form-group p-2">
            <div class="col-sm-12">
                <input class="form-control" name="email" placeholder="E-mail" type="email" required autofocus />
            </div>
        </div>
        <div class="form-group p-2">
            <div class="col-sm-12">
                <input class="form-control" name="senhaInput" placeholder="Senha" type="password" required />
            </div>
        </div>

        <div class="row p-2 mb-4 mt-2 pl-4">
            <div class="col-sm-12">
                <input type="submit" class="btn bg-dark-subtle fs-5 w-100" name="btnEntrar" value="Entrar" />
            </div>
        </div>
        <div class="px-2 w-100 mb-0">
            <p class="text-end fs-6">
                Nao possui uma conta?
                <a class="link-offset-2 link-underline link-underline-opacity-0" href="registar.php"> Registar</a>
            </p>
        </div>
    </form>
    <script src="../lib/fontawesome-free-6.4.2-web/js/all.min.js">
    </script>
    <script src="../lib/bootstrap-5.3.2-dist/js/bootstrap.js">
    </script>
    <?php
include_once '../footer.php';
?>