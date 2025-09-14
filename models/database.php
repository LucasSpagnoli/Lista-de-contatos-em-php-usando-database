<?php
// Arquivo que vai gerar a conexão com o banco de dados

// Classe do banco de dados (em PDO)
class Database {
    private $db_server = "localhost"; // nome do host
    private $db_user = "root"; // nome do usuário do phpMyAdmin
    private $db_pass = ""; // senha
    private $db_name = "contatos"; // nome do banco de dados
    private $db_conn;
    public function getConn(){
        $this->db_conn = null;

        // tenta fazer a conexão
        try {
            // faz a variável conexão virar um objeto PDO
            $this->db_conn = new PDO(
                "mysql:host={$this->db_server}; dbname={$this->db_name};", 
                $this->db_user,
                $this->db_pass // Cria conexão com banco
            );
            $this->db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Define exceções caso haja erro na conexão
        } catch (PDOException $e) {
            echo "Erro ao conectar-se com o banco de dados: " . $e->getMessage();
            exit();
        }
        // retorna a conexão com o banco de dados
        return $this->db_conn;
    }
}
?>