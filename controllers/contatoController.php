<?php
// Arquivo que vai usar o contatoDAO pra imprimir as informações em formato JSON


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Define que a página vai ser um JSON, não HTML
    header('Content-type: application/json');

    // Chama a conexão já feita
    require_once '../models/contatoDAO.php';

    $contatoDAO = new ContatoDAO; // Vira um objeto que tem acesso ao banco de dados
    $contatos = $contatoDAO->getAll(); // Chama a função de pegar todos os contatos

    echo json_encode($contatos); // Converte o array (lá do contatosDAO) em JSON e exibe na tela
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $novoContato = json_decode($json);
}