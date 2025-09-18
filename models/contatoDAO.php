<?php
// Arquivo que vai interagir com o banco de dados

// Puxa o arquivo que vai ter a conexão
require_once "database.php";

class ContatoDAO
{
    private $connection; // vai receber a conexão

    // Construtor do objeto, vai ser executado toda vez que usar new ContatoDAO()
    public function __construct()
    {
        // Classe do arquivo database.php
        $database = new Database();
        $this->connection = $database->getConn();
    }

    // Função que vai receber todos os contatos do banco de dados
    public function getAll()
    {
        try {

            $sql = "SELECT * FROM contatos ORDER BY id ASC"; // Cria ordem em SQL pro banco de dados
            $statement = $this->connection->prepare($sql); // Prepara essa ordem
            $statement->execute(); // executa a ordem

            return $statement->fetchAll(PDO::FETCH_ASSOC); // retorna os resultados. O fetchAll retorna todas as linhas encontradas, e o PDO::FETCH_ASSOC faz essas linhas virarem um array associativo, um formato fácil de se trabalhar.

        } catch (PDOException $e) {
            // Caso dê erro de conexão, interrompe a execução
            echo "Erro ao buscar contatos: " . $e->getMessage();
            exit();
        }
    }

    // Função que cria novo contato
    public function create($contato)
    {
        try {
            $sql = "INSERT INTO contatos (id, nome, email, telefone) VALUES (NULL, ?, ?, ?)"; // Cria ordem em SQL pro banco de dados, tem ponto de interrogação por motivos de segurança
            $statement = $this->connection->prepare($sql);
            $success = $statement->execute([
                $contato->nome,
                $contato->email,
                $contato->telefone
            ]);
            return $success;
        } catch (PDOException $e) {
            error_log("Erro ao criar contato: " . $e->getMessage());
            return false;
        }
    }

    // Função que deleta contato
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM contatos WHERE id = ?";
            $statement = $this->connection->prepare(($sql));
            $success = $statement->execute([
                $id
            ]);
            return $success;
        } catch (PDOException $e) {
            error_log(("Erro ao deletar contato: " . $e->getMessage()));
            return false;
        }
    }

    public function update($contato)
    {
        $sql_parts = [];
        $params = [];

        if (isset($contato->nome)) {
            $sql_parts[] = 'nome = ?';
            $params[] = $contato->nome;
        }
        if (isset($contato->email)) {
            $sql_parts[] = 'email = ?';
            $params[] = $contato->email;
        }
        if (isset($contato->telefone)) {
            $sql_parts[] = 'telefone = ?';
            $params[] = $contato->telefone;
        }

        if (count($params) === 0) {
            return false;
        }

        $sql = 'UPDATE contatos SET ' . implode(', ', $sql_parts) . " WHERE id = ?";
        $params[] = $contato->id;

        try {
            $statement = $this->connection->prepare($sql);
            return $statement->execute($params);
        } catch (PDOException $e) {
            error_log(("Erro ao atualizar contato: " . $e->getMessage()));
            return false;
        };
    }
}
