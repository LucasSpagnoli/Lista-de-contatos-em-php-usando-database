<?php
// Arquivo que vai usar o contatoDAO pra imprimir as informações em formato JSON
// Define que a página vai ser um JSON, não HTML
    header('Content-type: application/json');

    // Chama a conexão já feita
    require_once '../models/contatoDAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $contatoDAO = new ContatoDAO; // Vira um objeto que tem acesso ao banco de dados
    $contatos = $contatoDAO->getAll(); // Chama a função de pegar todos os contatos

    echo json_encode($contatos); // Converte o array (lá do contatosDAO) em JSON e exibe na tela

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // caso o JS esteja enviando um contato

    $json = file_get_contents('php://input'); // pega o json do novo contato da página
    $novoContato = json_decode($json); // transforma o json em array

    if ((empty($novoContato->nome) || (empty($novoContato->email)) || (empty($novoContato->telefone)))) {
        $resposta = ['status' => 'error', 'message' => 'Todos os campos são obrigatórios.']; // mensagem que vai aparecer dependendo do resultado (nesse caso de erro)

        http_response_code(400); // faz dar erro
        echo json_encode($resposta); // mostra mensagem (de erro)
        exit(); // para execução

    } 
        $contatoDAO = new ContatoDAO;
        $contatoCriado = $contatoDAO->create($novoContato);
        if ($contatoCriado){
            $resposta = ['status' => 'success', 'message' => 'Contato adicionado com sucesso']; // cria mensagem de sucesso
            echo json_encode($resposta); // mostra mensagem
        } else {
            $resposta = ['status' => 'error', 'message' => 'Erro ao salvar contato no banco de dados.']; // cria mensagem de erro
            http_response_code(500); // faz dar erro
            echo json_encode($resposta); // mostra mensagem
        }
}