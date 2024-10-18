<?php
// Cargar datos de bots desde el archivo JSON
$botsJson = file_get_contents('Json/bots.json');
$bots = json_decode($botsJson, true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de Jugadores</title>
    <link rel="stylesheet" href="css/estilos.css">
    
</head>
<body>
    <div id="carga" class="carga">
        <p>Cargando jugadores...</p>
    </div>
    <div id="listaBots" class="hidden gato">
        <h2>Buscando emparejamiento...</h2>
        <div id="decorativa" class="decorativa">
            <img src="img/R (1).gif" alt="Imagen decorativa">
        </div>
        <div id="botsContainer" class="bots-container">
            <?php foreach ($bots as $bot): ?>
                <div class="bot-card">
                    <div class="bot-name"><?php echo $bot['nombre']; ?></div>
                    <div class="bot-level">Nivel: <?php echo $bot['nivel']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="js/script.js"></script>
</body> 
</html>
