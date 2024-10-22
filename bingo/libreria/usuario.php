<?php 

include('conexion.php');

class Usuario {
    private $conexion;
    private $nombre_usuario;
    private $correo;
    private $contrasena;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function setNombreUsuario($nombre_usuario) {
        $this->nombre_usuario = $nombre_usuario;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
    }

    public function registrar() {
        $sql = "INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES (:nombre_usuario, :correo, :contrasena)";
        $valores = [
            ':nombre_usuario' => $this->nombre_usuario,
            ':correo' => $this->correo,
            ':contrasena' => $this->contrasena
        ];
        $this->conexion->ejecutar($sql, $valores);
    }

    public function iniciarSesion($correo, $contrasena) {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $this->conexion->conectar()->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            return $usuario; // Retorna el usuario si la contraseña es correcta
        }
        return null; // Retorna null si no se encuentra o si la contraseña es incorrecta
    }
}

?>
