// Pega as variáveis que serão usadas
let tabela = document.querySelector("#tabela-contatos")
let addForm = document.querySelector('#formAdd')

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
async function carregarContatos() {
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
                <button class="delBtn btn btn-sm btn-outline-danger" data-id='${contato.id}'>🗑️</button>
            </td>
        </tr>
        `
    }
}
carregarContatos()

// Evento de submit no forms, vai salavar os dados em JSON e enviar ao controller pra ser usado no php e adicionar novo contato
addForm.addEventListener('submit', async (event) => {
    event.preventDefault() // previne que a página recarregue

    let nome = (document.querySelector('#nome')).value
    let email = (document.querySelector('#email')).value
    let telefone = (document.querySelector('#telefone')).value

    // Validação dos campos de nome e telefone
    if (/\d/.test(nome)) { // regex pra ver se só tem letras
        window.alert('Digite um nome válido')
        return
    } else if ((telefone.length < 10) || (!/^\d{10,11}$/.test(telefone))) { // regex pra ver se só tem números
        window.alert('Digite um telefone válido (com dd e somente 10-11 números)')
        return
    }

    // objeto do novo contato
    const dadosContato = {
        nome: nome,
        email: email,
        telefone: telefone
    }

    // Vai servir para transformar os dados em JSON e enviar ao controller, para então o PHP pegar esses dados e usá-los
    const postFetch = {
        method: 'POST',
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify(dadosContato)
    }

    // Aqui, o fetch vai ser enviado
    try {
        const response = await fetch(url, postFetch)

        // Aqui vamos verificar se tudo ocorreu corretamente
        if (response.ok) {
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
    } catch (error) {
        console.log('Erro na requisição: ', error)
    }
})

// Evento de deletar contato
tabela.addEventListener('click', async (e) => {
    const delBtn = e.target.closest('.delBtn')

    // Verificação pra saber se é o botão de deltar mesmo, se não for, interrompe o resto
    if (!delBtn) {
        return
    }

    let contatoId = delBtn.dataset.id
    let deletar = window.confirm('Tem certeza que deseja continuar?')

    if (deletar) {

        const postFetch = {
            method: 'DELETE',
            headers: { 'Content-type': 'application/json' },
            body: JSON.stringify({ id: contatoId })
        }

        try {
            const response = await fetch(url, postFetch)
            if (response.ok) {
                console.log('Contato deletado com sucesso!')

                delBtn.closest('tr').remove() // vai remover a linha, ao invés de precisar carregar os contatos novamente
            } else {
                console.log('Erro ao deletar contato')
            }
        } catch (error) {
            console.log("Erro ao deletar contato: ", error)
            alert('Não possível deletar, erro no servidor.')
        }
    }
})