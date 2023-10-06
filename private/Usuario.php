<?php

session_start();
require_once 'DbConnect.php';

class Usuario
{
    private $dbName =  'modelacao_crud';
    private $connection;
    private $table = 'usuarios';

    public function __construct()
    {
        if(isset($_SESSION['db_error'])) {
            print_error($_SESSION['db_error'], "danger");
            exit;
        }
        $db = new DbConnect($this->dbName);
        $this->connection = $db->getConnection();
    }

    public function getAllUsers()
    {
        try {
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query_allUsers = 'SELECT id, nome_usuario, email, telefone, morada, foto_perfil, created_at, updated_at FROM usuarios';
            $stmt = $this->connection->prepare($query_allUsers);
            $stmt->Execute();
            $row = $stmt->fetchAll();
            return $row;
        } catch(PDOException $e) {
            return ['errorMsg' => $e->getMessage()];
        }
        $this->connection = null;
    }
    public function getUserByEmail(string $email): array
    {
        try {
            $this->connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->connection->prepare("SELECT id, nome_usuario,email, senha, foto_perfil FROM usuarios WHERE email = :email");
            $stmt -> bindParam(":email", $email);
            $stmt->execute();
            $result = $stmt->fetch();
            if(!$result) {
                return ['errorMsg' => "Email ou senha invalido"];
            }
            return $result;
        } catch(PDOException $e) {
            return ['errorMsg' => $e->getMessage()];
        }
        $this->connection = null;
    }

    public function getUserById(int $id)
    {
        try {
            $this->connection -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->connection->prepare("SELECT nome_usuario,email, telefone, morada, senha, foto_perfil FROM usuarios WHERE id = :id");
            $stmt -> bindParam(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch(PDOException $e) {
            return false;
        }
        $this->connection = null;
    }
    public function insertUser(array $formData, array $file)
    {
        extract($formData);
        extract($file);
        $hashedPassword = password_hash($usrPassword, PASSWORD_DEFAULT);
        echo $usrPassword;
        $data = [
            ':nome' => $usrName,
            ':email' => $usrEmail,
            ':morada' => $usrAddress,
            ':telefone' => $usrMobileNumber,
            ':senha' => $hashedPassword,
            ':foto' => $name,
            ':created_at' => date('Y-m-d H:i:s'),
        ];
        try {
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO usuarios (nome_usuario,email,morada,telefone,senha,foto_perfil, created_at) VALUES (:nome,:email,:morada,:telefone,:senha,:foto,:created_at)";
            $query1 = "SELECT email from usuarios where email = :email";
            $statement1 = $this->connection->prepare($query1);
            $statement1->bindParam(':email', $usrEmail);
            $statement1->execute();
            if($statement1->rowCount() != 0) {
                $_SESSION['errorMsg'] = "O email ou telefone ja existe no banco de dados";
            } else {
                $statement = $this->connection->prepare($query);
                $statement->execute($data);

                if (isset($name) && !empty($name)) {
                    $lastId = $this->connection->lastInsertId();
                    // criando um directorio para as imagens
                    $usrImagesDir = "../images/$lastId/";
                    // director para imagem de cada usuario
                    mkdir($usrImagesDir, 0755);
                    $fileName = $name;
                    move_uploaded_file($tmp_name, $usrImagesDir.$fileName);

                    return true;
                }
            }
        } catch(PDOException $e) {
            return false;
        }
        $this->connection = null;
    }
    public function updateUser(array $data)
    {
        try {

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            extract($data);
            if(empty($name)) {

            }
            $updateQuery = "UPDATE usuarios SET nome_usuario=:nome_usuario, email=:email, morada=:morada, telefone=:telefone, senha=:senha, foto_perfil=:foto_perfil, updated_at = :updated_at WHERE id=:id";
            $resp = $this->getUserByEmail($email);

            if((isset($resp['email']) || isset($resp['telefone'])) && $resp['id'] != $id) {
                return ['errorMsg' => "O email ou contacto ja existe no banco de dados"];
            } else {
                $stmt = $this->connection->prepare($updateQuery);
                $stmt->execute($data);

                return true;
            }
        } catch(PDOException $e) {
            return ["errorMsg" => $e->getMessage()];
        }
        $this->connection = null;
    }
    public function deleteUser($id)
    {
        try {
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return ["errorMsg" => $e->getMessage()];
        }
        $this->connection = null;
    }
    public static function deleteImage(string $src)
    {
        $dir = opendir($src);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $full = $src.'/'.$file;
                if (is_dir($full)) {
                    rrmdir($full);
                } else {
                    unlink($full);
                }
            }
        }
        closedir($dir);
        rmdir($src);
    }
}
