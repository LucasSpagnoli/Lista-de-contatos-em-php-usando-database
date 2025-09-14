<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciador de Contatos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- bootstrap -->
  <link rel="stylesheet" href="./estilos/styles.css">
  <script defer src="js/script.js"></script> <!-- Javascript que conecta back com front end -->
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">Gerenciador de Contatos</a>
    </div>
  </nav>

  <!-- Container principal -->
  <div class="container my-5">

    <!-- Btn adicionar -->
    <div class="d-flex justify-content-between mb-3">
      <h3>Lista de Contatos</h3>
      <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Adicionar Contato</button>
    </div>

    <!-- Alertas (feedback de operações) -->
    <div id="alert-container"></div>

    <!-- Tabela de contatos -->
    <div class="card p-3">
      <table class="table table-hover align-middle">

        <thead>
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>

        <tbody id="tabela-contatos">

          <tr>
            <td>João Silva</td>
            <td>joao@email.com</td>
            <td>(11) 99999-0000</td>
            <td class="text-center">
              <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit">✏️</button>
              <button class="btn btn-sm btn-outline-danger">🗑️</button>
            </td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>

  <!-- Adicionar -->
  <div class="modal fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formAdd">
          <div class="modal-header">
            <h5 class="modal-title">Adicionar Contato</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control" id="nome" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="text" class="form-control" id="telefone" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" id="saveBtn" class="btn btn-custom">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Editar -->
  <div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formEdit">
          <div class="modal-header">
            <h5 class="modal-title">Editar Contato</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="edit-id">
            <div class="mb-3">
              <label for="edit-nome" class="form-label">Nome</label>
              <input type="text" class="form-control" id="edit-nome" required>
            </div>
            <div class="mb-3">
              <label for="edit-email" class="form-label">Email</label>
              <input type="email" class="form-control" id="edit-email" required>
            </div>
            <div class="mb-3">
              <label for="edit-telefone" class="form-label">Telefone</label>
              <input type="text" class="form-control" id="edit-telefone" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-custom">Atualizar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>