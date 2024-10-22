<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('conexion.php');

// Conectar a la base de datos
$conexion = new Conexion();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirigir si no está autenticado
    exit;
}

// Obtener el id del usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'];

// Obtener información del usuario
$stmt = $conexion->conectar()->prepare("SELECT nombre_usuario, foto_perfil, nivel, monedas FROM usuarios WHERE id = :id");
$stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $usuario = $stmt->fetch();
    $nombre_usuario = $usuario['nombre_usuario'];
    $foto_perfil = $usuario['foto_perfil'];
    $nivel_usuario = $usuario['nivel'];
    $monedas_usuario = $usuario['monedas'];
} else {
    echo "No se encontró el usuario.";
    exit;
}

// Manejo de botones
if (isset($_POST['inicio'])) {
    header("Location: http://localhost/2901817PHP/2901817/bingo/login/iniciodeljuego/elegirModalidad/elegirModalidad.php");  
    exit;
}

if (isset($_POST['tienda'])) {
    header("Location: http://localhost/2901817PHP/2901817/bingo/login/iniciodeljuego/TiendaMacth/");  
    exit;
}

if (isset($_POST['recompensa'])) {
    header("Location: http://localhost/2901817PHP/2901817/bingo/login/iniciodeljuego/reconpensaMact/");  
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/animaciones.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet"/>
</head>
<body>
    <div class="containerDisco">
        <div class="neon-button">
            <img src="img/configuraciones.jpeg" alt="Imagen 1">
        </div>
        
        <form method="post">
            <div class="neon-button">
                <button type="submit" name="inicio" style="border: none; background: none; padding: 0;">
                    <img src="img/star.jpeg" alt="Imagen 2" style="cursor: pointer;">
                </button>
            </div>
        </form>

        <form method="post">
            <div class="neon-button">
                <button type="submit" name="tienda" style="border: none; background: none; padding: 0;">
                    <img src="img/tienda.jpeg" alt="Imagen 3" style="cursor: pointer;">
                </button>
            </div>
        </form>
        
        <div class="logo-button">
            <img src="img/bingo.png" alt="Imagen 4">
        </div>
  
        <div class="luz-busqueda"></div>

        <div class="usuario-boton" style="cursor: pointer;" onclick="window.location.href='http://localhost/2901817PHP/2901817/bingo/login/iniciodeljuego/perfil/';">
            <img src="<?php echo htmlspecialchars($foto_perfil); ?>" alt="Avatar del usuario" class="avatar">
            <div class="info-usuario">
                <span class="nombre-usuario"><?php echo htmlspecialchars($nombre_usuario); ?></span>
                <div class="barra-nivel">
                    <div class="nivel" style="width: <?php echo htmlspecialchars($nivel_usuario * 10); ?>%;"></div>
                </div>
                <span class="texto-nivel">Nivel <?php echo htmlspecialchars($nivel_usuario); ?></span>
            </div>
        </div>

        <!-- Botón de cantidad de monedas -->
        <div class="cantidad-monedas">
            <button>
                <img src="img/monedas-icono.jpeg" alt="Monedas">
                <?php echo htmlspecialchars($monedas_usuario); ?>
            </button>
        </div>

        <!-- Botón de recompensas diarias -->
        <form method="post">
            <div class="recompensaDiaria">
                <button type="submit" name="recompensa" style="border: none; background: none; padding: 0;">
                    <img src="img/Moneda.jpeg" alt="Imagen 5" style="cursor: pointer;">
                </button>
            </div>
        </form>
    </div>
</body>
</html>
