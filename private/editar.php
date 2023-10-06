<?php
include_once '../header.php';
require 'Usuario.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $currentUser = new Usuario();
    $user = $currentUser->getUserById($id);

    if (!$user) {
        print_error($user['errorMsg'], "danger");
    } else {
        $data = [
            "name" => $user['nome_usuario'],
            "email" => $user['email'],
            "morada" => $user['telefone'],
            "telefone" => $user['morada'],
            "foto" => $user['foto_perfil'],
            "senha" => $user['senha'],
        ];
        extract($data);
    }
}
$regFormData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($regFormData['btnRegisterUser'])) {
    $foto_perfil = $_FILES['usrProfilePic'];
    extract($regFormData);
    extract($foto_perfil);
    $hashedPassword = password_hash($usrPassword, PASSWORD_DEFAULT);
    $updateUser = new Usuario();
    $data = [
         "nome_usuario" => $usrName,
         "email" => $usrEmail,
         "morada" => $usrAddress,
         "telefone" => $usrMobileNumber,
         "senha" => empty($hashedPassword) ? $senha : $hashedPassword,
         "foto_perfil" => empty($name) ? $foto : $name,
         "updated_at" => date('Y-m-d H:i:s'),
         "id" => $id,
       ];

    $isUpdated = $updateUser->updateUser($data);

    if(isset($isUpdated['errorMsg'])) {
        print_error($isUpdated['errorMsg'], "danger");
    } else {

        if (isset($name) && !empty($name)) {
            $usrImagesDir = "../images/$id/";
            Usuario::deleteImage($usrImagesDir);

            mkdir($usrImagesDir, 0755);
            $fileName = $name;
            move_uploaded_file($tmp_name, $usrImagesDir.$fileName);
            print_error('Dados actualizados com sucesso!', 'success');
            header("refresh:1;url=./viewSingle.php?id=".$id);
        }

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

<body class="bg-light d-flex justify-content-center align-items-center slide-in-blurred-left roll-out-left ">
    <div class="container d-flex justify-content-end bg-dark w p-2">
        <a href="viewSingle.php?id=<?php echo $_GET['id']; ?>"
            class="link-offset-2 link-underline link-underline-opacity-0 text-light fs-4 px-2">
            <i class="fa-solid fa-xmark"></i>
        </a>
    </div>
    <form name="registerForm" class="bg-white w shadow p-5 rounded" method="post" enctype="multipart/form-data">
        <div class="mb-2">
            <p class="h2 text-uppercase py-0 ">Dados</p>
        </div>
        <div class="form-group d-flex justify-content-between py-2 gap-2">
            <div class="col-6-xl col-12-sm w-100">
                <input class="form-control" name="usrName"
                    value="<?php echo $name; ?>"
                    placeholder="Nome completo" type="text" />
            </div>
            <div class="col-6-xl col-12-sm w-100">
                <input class="form-control" name="usrEmail"
                    value="<?php echo $email; ?>" placeholder="Email"
                    type="email" />
            </div>
        </div>
        <div class="form-group py-2">
            <div class="">
                <input class="form-control" name="usrAddress"
                    value="<?php echo $morada; ?>"
                    placeholder="Morada" type="text" />
            </div>
        </div>
        <div class="form-group row py-2">
            <div class="col-xl-6 col-sm-12 pos-rel">
                <input class="form-control ps-5" name="usrMobileNumber"
                    value="<?php echo $telefone; ?>"
                    placeholder="Numero de telefone" type="tel" maxlength="9" />
                <span class="countryCode  bg-light">+258</span>
            </div>
            <div class="col-xl-6 col-sm-4">
                <input class="form-control" type="file" name="usrProfilePic"
                    value="<?php echo $foto_perfil; ?>">
            </div>
        </div>

        <div class="form-group row py-2">
            <div class="col-xl-6 col-sm-12">
                <input class="form-control" name="usrPassword" placeholder="Nova senha" type="password" />
            </div>
            <div class="col-xl-6 col-sm-12">
                <input class="form-control" name="usrPasswordConfirm" placeholder="Confirme a nova senha"
                    type="password" />
            </div>
        </div>
        <div class="form-group row mt-1 px-2">
            <div class="col-xl-12 text-white ps-3 bg-danger rounded" id="error" hidden>
                <p class="mt-2 fs-5">As senhas inseridas são diferentes</p>
            </div>
        </div>
        <div class="btn-sub">
            <input type="submit" class="btn bg-secondary btn-radius w-50 text-white fs-5 " name="btnRegisterUser"
                value="Actualizar">
        </div>

    </form>

    <script src="../lib/fontawesome-free-6.4.2-web/js/all.min.js">
    </script>
    <script src="../lib/bootstrap-5.3.2-dist/js/bootstrap.js">
    </script>
    <?php
include_once '../footer.php';
?>