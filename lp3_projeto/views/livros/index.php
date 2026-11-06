<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Livros Cadastrados</h3>
            <a href="/lp3_projeto/livros/adicionar" class="btn btn-success btn-sm">+ Adicionar</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Capa</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>ISBN</th>
                    <th>Ano de publicação</th>
                    <th>Gênero</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dados)): ?>
                    <?php foreach ($dados as $linha): ?>
                        <tr>
                            <td><?= $linha['id'] ?></td>

                            <td>
                                <?php if (!empty($linha['capa'])): ?>
                                    <img src="/lp3_projeto/uploads/livros/<?= rawurlencode($linha['capa']) ?>"
                                         alt="Capa do livro"
                                         style="width: 60px; height: 80px; object-fit: cover;">
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($linha['titulo']) ?></td>
                            <td><?= htmlspecialchars($linha['autor']) ?></td>
                            <td><?= htmlspecialchars($linha['isbn'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($linha['ano_publicacao'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($linha['genero'] ?? '-') ?></td>

                            <td class="text-center">
                                <a href="/lp3_projeto/livros/editar?id=<?= $linha['id'] ?>" class="btn btn-warning btn-sm">Editar</a>

                                <a href="/lp3_projeto/livros/excluir?id=<?= $linha['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Tem certeza que deseja excluir este livro?');">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center;">Nenhum livro cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>