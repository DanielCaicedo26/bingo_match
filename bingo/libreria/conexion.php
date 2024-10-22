<?php 

class Conexion {
    private $servidor;
    private $usuario;
    private $password;
    private $puerto;
    private $baseDatos;

    public function __construct() {
        $this->servidor = "localhost";
        $this->usuario = "postgres"; // Cambia según tu configuración
        $this->password = "3204155185"; // Cambia según tu configuración
        $this->puerto = "5432";
        $this->baseDatos = "usuario"; // Nombre de tu base de datos
    }

    public function conectar() {
        try {
            $dsn = "pgsql:host=$this->servidor;port=$this->puerto;dbname=$this->baseDatos";
            $pdo = new PDO($dsn, $this->usuario, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Error en la conexión: ' . $e->getMessage();
            return null;
        }
    }

    public function ejecutar($sql, $valores) {
        $sentencia = $this->conectar()->prepare($sql);
        $sentencia->execute($valores);
    }

    public function listar($sql) {
        $stmt = $this->conectar()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>
