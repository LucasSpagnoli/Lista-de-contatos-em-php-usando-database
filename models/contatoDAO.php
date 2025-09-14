<?php
// Arquivo que vai interagir com o banco de dados

// Puxa o arquivo que vai ter a conexão
require_once "database.php";

class ContatoDAO {
    private $connection; // vai receber a conexão

    // Construtor do objeto, vai ser executado toda vez que usar new ContatoDAO()
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
            $statement = $this->connection->prepare($sql); // Prepara essa ordem
            $statement->execute(); // executa a ordem

            return $statement->fetchAll(PDO::FETCH_ASSOC); // retorna os resultados. O fetchAll retorna todas as linhas encontradas, e o PDO::FETCH_ASSOC faz essas linhas virarem um array associativo, um formato fácil de se trabalhar.

        } catch (PDOException $e) {
            // Caso dê erro de conexão, interrompe a execução
            echo "Erro ao buscar contatos: " . $e->getMessage();
            exit();
        }
    }
}