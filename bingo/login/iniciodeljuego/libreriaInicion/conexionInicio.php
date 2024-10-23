<?php 

class Conexion {
    private $servidor;
    private $usuario;
    private $password;
    private $puerto;
    private $baseDatos;

    public function __construct() {
        $this->servidor = "localhost";
        $this->usuario = "postgres";
        $this->password = "daniel"; // Cambia esta contraseña según tu configuración
        $this->puerto = "5432";
        $this->baseDatos = "usuarios"; 
    }

    public function conectar() {
        try {
            // Crear una instancia de PDO
            $dsn = "pgsql:host=$this->servidor;port=$this->puerto;dbname=$this->baseDatos";
            $pdo = new PDO($dsn, $this->usuario, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Mostrar errores
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Establecer el modo de fetch a asociativo
            ]);

        } catch (PDOException $e) {
            echo 'Error en la conexión: ' . $e->getMessage();
            exit;
        }

        return $pdo;
    }

    public function ejecutar($sql, $valores) {
        $stmt = $this->conectar()->prepare($sql);
        $stmt->execute($valores);
    }

    public function listar($sql) {
        $stmt = $this->conectar()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(); // Obtener todos los registros
    }
}

?>
