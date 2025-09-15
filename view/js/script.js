// Pega as variáveis que serão usadas
let tabela = document.querySelector("#tabela-contatos")
const addForm = document.querySelector('#addForm')
let url = '../controllers/contatoController.php' // URL do contatoController.php

// Cria função assíncrona que vai receber os dados (em JSON) do contatoController
async function getData(request) {
    try {
        // Espera os dados virem
        const response = await fetch(`${request}`)
        // Pega eles em JSON
        const data = await response.json()
        return data
    } catch (error) {
        console.log(`Erro: ${error}`)
        return { error }
    }
}

// Função que vai carregar os contatos
(async function carregarContatos() {
    const contatos = await getData(url) // cria uma array de contatos com as informações do banco de dados

    tabela.innerHTML = '' // esvazia a lista

    // for que percorre toda a array de contatos
    for (const contato of contatos) {
        tabela.innerHTML +=
        `
        <tr>
            <td>${contato.nome}</td>
            <td>${contato.email}</td>
            <td>${contato.telefone}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit">✏️</button>
                <button class="btn btn-sm btn-outline-danger" data-id='${contato.id}'>🗑️</button>
            </td>
        </tr>
        `
    }
})()

// Evento de submit no forms, vai salavar os dados em JSON e enviar ao controller pra ser usado no php
addCttBtn.addEventListener('submit', async (event) =>{
    event.preventDefault() // previne que a página recarregue

    let nomeInput = document.querySelector('#nome')
    let emailInput = document.querySelector('#email')
    let telefoneInput = document.querySelector('#telefone')

    const dadosContato = {
        nome: nomeInput.value,
        email: emailInput.value,
        telefone: telefoneInput.value
    }
    
    // Vai servir para transformar os dados em JSON e enviar ao controller, para então o PHP pegar esses dados e usá-los
    const postFetch = { 
        method: 'POST', 
        Headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify(dadosContato)
    }

    // Aqui, o fetch vai ser enviado
    try {
        const response = await fetch(url, postFetch)

        // Aqui vamos verificar se tudo ocorreu corretamente
        if (response.ok){
            console.log('Contato adicionado')

            // Aqui vai fechar o pop-up de adicionar contatos
            const modalAdd = bootstrap.Modal.getInstance(document.querySelector('#modalAdd'))
            modalAdd.hide()

            // limpa os campos do form
            addForm.reset()

            carregarContatos()
        } else {
            console.log('Erro ao adicionar contato')
        }
    } catch(error){
        console.log('Erro na requisição: ', error)
    } 
})