
<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Filmes Cadastrados</h3>
            <a href="/lp3_projeto/filmes/adicionar" class="btn btn-success btn-sm">+ Adicionar</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Filme</th>
                    <th>Diretor</th>
                    <th>Duração (minutos)</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dados)): ?>
                    <?php foreach ($dados as $linha): ?>
                        <tr>
                            <td><?= $linha['id'] ?></td>

                            <td>
                                <?php if (!empty($linha['imagem'])): ?>
                                    <img src="/lp3_projeto/uploads/filmes/<?= rawurlencode($linha['imagem']) ?>"
                                         alt="Imagem do filme"
                                         style="width: 60px; height: 80px; object-fit: cover;">
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($linha['filme']) ?></td>
                            <td><?= htmlspecialchars($linha['diretor']) ?></td>
                            <td><?= $linha['duracao'] !== null ? $linha['duracao'] . ' min' : '-' ?></td>

                            <td class="text-center">
                                <a href="/lp3_projeto/filmes/editar?id=<?= $linha['id'] ?>" class="btn btn-warning btn-sm">Editar</a>

                                <a href="/lp3_projeto/filmes/excluir?id=<?= $linha['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Tem certeza que deseja excluir este filme?');">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Nenhum filme cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
