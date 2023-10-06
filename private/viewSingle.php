<?php
include_once '../header.php';
require_once 'Usuario.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $currentUser = new Usuario();
    $user = $currentUser->getUserById($id);

    if(!$user) {
        header("location: ../index.php");
    } else {
        $data = [
        "userName" => $user['nome_usuario'],
        "userEmail" => $user['email'],
         "userContact" => $user['telefone'],
         "userAddress" => $user['morada'] ,
         "userPhoto" => $user['foto_perfil'],
    ];
        extract($data);
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
    <title>Usuario - <?php echo $userName; ?></title>
</head>

<body class="bg-light bounce-in-top roll-out-left">
    <div class="container d-flex justify-content-end bg-dark w-50 p-2">
        <a href="../index.php" class="link-offset-2 link-underline link-underline-opacity-0 text-light fs-4 px-2">
            <i class="fa-solid fa-xmark"></i>
        </a>
    </div>
    <div class="card p-4 w-50 h-75 ">
        <div class="w-100 h-100 d-flex align-items-center flex-column">
            <div class="img">
                <img src="<?php if (!file_exists('../images/'.$_GET['id'].'/'.$userPhoto)) {
            echo '../images/default/default.png';
        } else {
            echo '../images/'.$_GET['id'].'/'.$userPhoto;
        }?>" class="img" alt="Foto de perfil">
            </div>
            <div class="m-3">
                <h5 class="card-title"></i><span class="text-capitalize fs-4"><?php echo $userName; ?></span>
                </h5>
            </div>
            <div class="mt-2">
                <p class="" style="margin:2px !important; padding:0 !important;"><i
                        class="pe-2 fa-regular fa-envelope-open"></i><span
                        class="text-capitalize ms-3"><?php echo $userEmail; ?></span>
                </p>
                <p class="" style="margin:2px !important; padding:0 !important;"><i
                        class="pe-2 fa-solid fa-location-dot"></i><span
                        class="text-capitalize ms-3"><?php echo $userAddress; ?></span>
                </p>
                <p class="" style="margin:2px !important; padding:0 !important;"><i
                        class="pe-2 fa-regular fa-address-book"></i><span
                        class="text-capitalize ms-3"><?php echo $userContact; ?></span>
                </p>
                <div class="my-3 d-flex gap-5">
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="return openModal();"
                        href="./delete.php?id=<?php echo $_GET['id']; ?>"
                        class="btn btn-outline-danger d-flex gap-2 align-items-center"><i
                            class="fa-solid fa-trash-can"></i>Eliminar</a>
                    <a href="./editar.php?id=<?php echo $_GET['id']; ?>"
                        class="btn btn-outline-secondary d-flex gap-2 align-items-center"><i
                            class="fa-solid fa-pen-to-square"></i>Actualizar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar registo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que pretende apagar este registo?
                </div>
                <div class="modal-footer">
                    <button onclick="openModal(false);" type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Não</button>
                    <a href="./delete.php?id=<?php echo $_GET['id']; ?>" type="button" class="btn btn-primary">Sim</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Termina o modal -->
    <script src="../lib/fontawesome-free-6.4.2-web/js/all.min.js">
    </script>
    <script src="../lib/bootstrap-5.3.2-dist/js/bootstrap.js">
    </script>
    <?php
include_once '../footer.php';
?>