<?php
session_start();
$conexion = new mysqli('localhost', 'root', '', 'usuariosDa');

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: http://localhost/2901817PHP/2901817/bingo/login/");
    exit;
}

// Obtener los datos del usuario desde la base de datos
$id_usuario = $_SESSION['id_usuario'];
$stmt = $conexion->prepare("SELECT nombre_usuario, foto_perfil FROM usuarios WHERE id = ?");
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

$nombre_usuario = $usuario['nombre_usuario'];
$foto_perfil = $usuario['foto_perfil'] ? $usuario['foto_perfil'] : 'img/default-avatar.png';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Jugador - Bingo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>
    <div class="contenedor">
        <div class="encabezado">
            <button onclick="window.history.back();">
                <i class="fas fa-arrow-left"></i>
            </button>
            <button onclick="window.location.href='inicio.php';">
                <i class="fas fa-gamepad"></i>
                Partida de Bingo
            </button>
        </div>
        <div class="perfil">
            <form action="actualizar_perfil.php" method="POST" enctype="multipart/form-data">
                <div class="perfil-contenido">
                    <img alt="Avatar del jugador" id="avatar-preview" src="<?php echo $foto_perfil; ?>" onclick="document.getElementById('foto_perfil').click();" />
                    <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" onchange="previewImage(event)" style="display:none;" />
                    <div class="informacion">
                        <div class="nombre">
                            <input type="text" name="nombre_usuario" value="<?php echo htmlspecialchars($nombre_usuario); ?>" required />
                        </div>
                        <button type="submit">
                            <i class="fas fa-pen"></i>
                            Guardar cambios
                        </button>
                        <div class="insignia">Nivel Plata</div>
                    </div>
                </div>
            </form>
        </div>
        <div class="estadisticas">
            <div class="seccion">
                <h3>Estadísticas de Bingo:</h3>
                <div class="contenido">
                    <p>Cartones ganados: 10</p>
                    <p>Partidas jugadas: 50</p>
                    <p>Tasa de victorias: 20%</p>
                    <p>Racha de victorias: 2</p>
                    <p>Última partida ganada: hace 3 días</p>
                </div>
            </div>
            <div class="seccion">
                <h3>Progreso de nivel:</h3>
                <div class="barra-progreso">
                    <div class="progreso" style="width: 70%;"></div>
                </div>
                <p>Nivel: 12</p>
            </div>
        </div>
        <div class="historial">
            <h3>Historial de Partidas</h3>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Modalidad</th>
                        <th>Cartones</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>05/10/2024</td>
                        <td>Con Poderes</td>
                        <td>3</td>
                        <td>Ganó</td>
                    </tr>
                    <tr>
                        <td>04/10/2024</td>
                        <td>Sin Poderes</td>
                        <td>1</td>
                        <td>Perdió</td>
                    </tr>
                    <tr>
                        <td>03/10/2024</td>
                        <td>Con Muchos Cartones</td>
                        <td>5</td>
                        <td>Ganó</td>
                    </tr>
                    <tr>
                        <td>01/10/2024</td>
                        <td>Con Poderes</td>
                        <td>2</td>
                        <td>Perdió</td>
                    </tr>
                    <tr>
                        <td>30/09/2024</td>
                        <td>Sin Poderes</td>
                        <td>4</td>
                        <td>Ganó</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('avatar-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
