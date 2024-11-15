<?php

require_once 'model.php';
require_once 'config.php';

class User_model
{
    private $db;

    public function __construct()
    {
        // Conexión a la base de datos
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=auto;charset=utf8', 'root', '');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configurar manejo de errores
            $this->_deploy();  // Verificar y crear tabla si no existe
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Verifica si la tabla 'usuario' existe y la crea si no
    public function _deploy() {
        $query = $this->db->query("SHOW TABLES LIKE 'usuario'");
        $usuarioExists = $query->fetchAll();

        if (count($usuarioExists) == 0) {
            $this->crearTablaUsuario();
        }
    }

    // Crea la tabla 'usuario'
    private function crearTablaUsuario() {
        $sql = "CREATE TABLE IF NOT EXISTS usuario (
                    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
                    user VARCHAR(100) NOT NULL UNIQUE,  -- Asegura que 'user' sea único
                    password VARCHAR(255) NOT NULL
                )";
        $this->db->exec($sql);

        // Insertar datos iniciales de usuario si la tabla está vacía
        $this->insertarDatosInicialesUsuario();
    }

    // Inserta datos iniciales de usuario
    private function insertarDatosInicialesUsuario() {
        $nombreUsuario = 'webadmin';
        $passwordHash = password_hash('admin', PASSWORD_DEFAULT); 

        // Verificar si el usuario ya existe antes de insertarlo
        $query = $this->db->prepare("SELECT * FROM usuario WHERE user = ?");
        $query->execute([$nombreUsuario]);
        if ($query->rowCount() == 0) {
            $sql = "INSERT INTO usuario (user, password) VALUES (?, ?)";
            $query = $this->db->prepare($sql);
            $query->execute([$nombreUsuario, $passwordHash]);
        }
    }

    // Obtiene el usuario por nombre
    public function getUserByName($user)
    {
        // Cambiamos 'user' por 'name' en la consulta
        $query = $this->db->prepare('SELECT * FROM usuario WHERE name = ?');
        $query->execute([$user]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    
}    