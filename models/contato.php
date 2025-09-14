<?php class Contato
{
    private $id;
    private $nome;
    private $email;
    private $telefone;
    public function __construct($nome, $email, $telefone, $id = null)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setNome($nome)
    {
        $this->nome = htmlspecialchars($nome);
    }
    public function setEmail($email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException('Email inválido!');
        }
        $this->email = $email;
    }
    public function setTelefone($telefone) {
    // Aceita apenas 10 ou 11 dígitos
    if (!preg_match('/^\d{10,11}$/', $telefone)) {
        throw new InvalidArgumentException("Telefone inválido!");
    }
    $this->telefone = $telefone;
}
}
