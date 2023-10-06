<?php

include_once '../header.php';
require_once "Usuario.php";

$regFormData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($regFormData['btnRegisterUser'])) {
    $foto_perfil = $_FILES['usrProfilePic'];

    $usr = new Usuario();
    $isInserted = $usr->insertUser($regFormData, $foto_perfil);

    if($isInserted) {
        print_error("Usuario registado com sucesso", "success");
        header('refresh:1;url=../index.php');
    } else {
        print_error($_SESSION['errorMsg'], 'danger');
        session_destroy();
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
    <title>Registo</title>
</head>

<body class="bg-light d-flex justify-content-center align-items-center">
    <div class="container d-flex justify-content-end bg-dark p-2 w">
        <a href="../index.php" class="link-offset-2 link-underline link-underline-opacity-0 text-light px-2 fs-4">
            <i class="fa-solid fa-xmark"></i>
        </a>
    </div>
    <form name="registerForm" class="bg-white w shadow p-5 rounded" method="post" enctype="multipart/form-data">
        <div class="mb-4">
            <p class="h2 text-uppercase py-0 text-center">Registar</p>
            <hr class="py-0 my-0">
        </div>
        <div class="form-group py-2">
            <div class="">
                <input class="form-control" name="usrName" placeholder="Nome completo" type="text" required autofocus />
            </div>
        </div>
        <div class="form-group py-2">
            <div class="">
                <input class="form-control" name="usrEmail" placeholder="Email" type="email" required />
            </div>
        </div>
        <div class="form-group py-2">
            <div class="">
                <input class="form-control" name="usrAddress" placeholder="Morada" type="text" />
            </div>
        </div>
        <div class="form-group row py-2">
            <div class="col-xl-6 col-sm-12 pos-rel">
                <input class="form-control ps-5" name="usrMobileNumber" placeholder="Numero de telefone" type="tel"
                    maxlength="9" />
                <span class="countryCode  bg-light">+258</span>
            </div>
            <div class="col-xl-6 col-sm-4">
                <input class="form-control" type="file" name="usrProfilePic">
            </div>
        </div>

        <div class="form-group row py-2">
            <div class="col-xl-6 col-sm-12">
                <input class="form-control" name="usrPassword" placeholder="Senha" type="password" required />
            </div>
            <div class="col-xl-6 col-sm-12">
                <input class="form-control" name="usrPasswordConfirm" placeholder="Confirme a senha" type="password"
                    required />
            </div>
        </div>
        <div class="form-group row mt-1 px-2">
            <div class="col-xl-12 text-white ps-3 bg-danger rounded" id="error" hidden>
                <p class="mt-2 fs-5">As senhas inseridas são diferentes</p>
            </div>
        </div>
        <div class="btn-sub">
            <input type="submit" class="btn bg-secondary btn-radius w-50 text-white fs-5 " name="btnRegisterUser"
                value="Enviar">
        </div>
        <div class="px-2 w-100 mb-0 py-2">
            <p class="text-end fs-6">
                Já possui uma conta? Faça
                <a class="link-offset-2 link-underline link-underline-opacity-0" href="login.php"> Login</a>
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