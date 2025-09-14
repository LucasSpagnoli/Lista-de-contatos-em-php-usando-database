<?php
// Arquivo que vai interagir com o banco de dados

// Puxa o arquivo que vai ter a conexão
require_once "database.php";

class ContatoDAO {
    private $connection;

    // Construtor do objeto que vai receber a conexão
    public function __construct()
    {
        // Classe do arquivo database.php
        $database = new Database();
        $this->connection = $database->getConn();
    }

    // Função que vai receber todos os contatos do banco de dados
    public function getAll(){
        try {
            $sql = "SELECT * FROM contatos ORDER BY nome ASC"; // Cria ordem em SQL pro banco de dados
            $statement = $this->conn->prepare($sql); // Prepara essa ordem
        }
    }
}

// Criar instância do banco
$db = new Database();
$conn = $db->getConn();

if ($conn) {
    echo "Conexão estabelecida com sucesso!";
}
