<?php
session_start(); // Iniciar sesión
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'usuariosDa');

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

// Obtener el id del usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];

    // Manejo de la imagen de perfil
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $nombre_archivo = $_FILES['foto_perfil']['name'];
        $ruta_temporal = $_FILES['foto_perfil']['tmp_name'];
        $ruta_destino = "img/" . $nombre_archivo;

        // Mover el archivo a la carpeta de imágenes
        if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
            // Actualizar la base de datos con la nueva foto de perfil
            $stmt = $conexion->prepare("UPDATE usuarios SET nombre_usuario = ?, foto_perfil = ? WHERE id = ?");
            $stmt->bind_param('ssi', $nombre_usuario, $ruta_destino, $id_usuario);
        } else {
            echo "Error al subir la imagen.";
            exit;
        }
    } else {
        // Si no se sube una nueva imagen, solo actualiza el nombre
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre_usuario = ? WHERE id = ?");
        $stmt->bind_param('si', $nombre_usuario, $id_usuario);
    }

    if ($stmt->execute()) {
        // Redirigir después de guardar cambios
        header("Location: http://localhost/2901817PHP/2901817/bingo/login/iniciodeljuego/perfil/");
        exit;
    } else {
        echo "Error al guardar los cambios.";
    }
}

$conexion->close();
?>
