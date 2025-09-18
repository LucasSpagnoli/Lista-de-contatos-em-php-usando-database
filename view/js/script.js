// Pega as variáveis que serão usadas
let tabela = document.querySelector("#tabela-contatos")
let addForm = document.querySelector('#formAdd')
let editForm = document.querySelector('#formEdit')
let url = '../controllers/contatoController.php' // URL do contatoController.php

function validarCampos(nome, telefone) {
    for (let char of nome) {
        if (!((char >= 'A' && char <= 'Z') || (char >= 'a' && char <= 'z') || char === ' ')) {
            window.alert('Digite um nome válido (somente letras)')
            return true
        }
    }
    if (isNaN(telefone) || (telefone.length !== 10 && telefone.length !== 11)) {
        window.alert('Digite um telefone válido (apenas números, com DDD, 10 ou 11 dígitos)')
        return true
    }
}

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
                <button class="preUpdBtn btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id='${contato.id}' data-nome='${contato.nome}' data-email='${contato.email}' data-telefone='${contato.telefone}'>✏️</button>
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

    // declaração das variáveis dos inputs e seus valores (por algum motivo não funciona se o .value estiver junto nos primeiors)
    const nomeInput = (document.querySelector('#nomeAdd'))
    const emailInput = (document.querySelector('#emailAdd'))
    const telefoneInput = (document.querySelector('#telefoneAdd'))
    let nome = nomeInput.value.trim()
    let email = emailInput.value.trim()
    let telefone = telefoneInput.value.trim()

    // Validação dos campos de nome e telefone
    if (validarCampos(nome, telefone)) {
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
    const preUpdBtn = e.target.closest('.preUpdBtn')

    if (delBtn) {
        let contatoId = delBtn.dataset.id
        let deletar = window.confirm('Tem certeza que deseja continuar?')
        if (deletar) {
            deletarContato(contatoId)
        } 
    } else if (preUpdBtn) {
            const nomeInput = (document.querySelector('#nomeUpd'))
            const emailInput = (document.querySelector('#emailUpd'))
            const telefoneInput = (document.querySelector('#telefoneUpd'))

            nomeInput.value = preUpdBtn.dataset.nome
            emailInput.value = preUpdBtn.dataset.email
            telefoneInput.value = preUpdBtn.dataset.telefone
        }
    }
)

async function deletarContato(contatoId) {
    const postFetch = {
        method: 'DELETE',
        headers: { 'Content-type': 'application/json' },
        body: JSON.stringify({ id: contatoId })
    }

    try {
        const response = await fetch(url, postFetch)
        if (response.ok) {
            delBtn.closest('tr').remove() // vai remover a linha, ao invés de precisar carregar os contatos novamente
        } else {
            console.log('Erro ao deletar contato')
        }
    } catch (error) {
        console.log("Erro ao deletar contato: ", error)
        alert('Não possível deletar, erro no servidor.')
    }
}

editForm.addEventListener('submit', async (e) => {
    e.preventDefault()
    const nomeInput = (document.querySelector('#nomeUpd'))
    const emailInput = (document.querySelector('#emailUpd'))
    const telefoneInput = (document.querySelector('#telefoneUpd'))

    const preUpdBtn = document.querySelector('.preUpdBtn')
    let contatoId = preUpdBtn.dataset.id

    let nome = nomeInput.value.trim()
    let email = emailInput.value.trim()
    let telefone = telefoneInput.value.trim()

    const contatoUpd = {
        id: contatoId,
        nome,
        email,
        telefone
    }

    const postFetch = {
        method: 'PUT',
        headers: { 'Content-type': 'application/json' },
        body: JSON.stringify(contatoUpd)
    }

    try {
        const response = await fetch(url, postFetch)
        if (response.ok) {
            const modalEdit = bootstrap.Modal.getInstance(document.querySelector('#modalEdit'))
            modalEdit.hide()
            carregarContatos()
        } else {
            console.log('Erro ao atualizar contato')
        }
    } catch (error) {
        console.log('Erro: ', error)
        alert('Não foi possível atualizar contato, erro no servidor.')
    }
})