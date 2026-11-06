<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Marcas Cadastrados</h3>
            <a href="/lp3_projeto/marcas/adicionar" class="btn btn-success btn-sm">+ Adicionar</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($dados)): ?>
                    <?php foreach ($dados as $linha): ?>
                        <tr>
                            <td><?= $linha['id'] ?></td>
                            <td><?= htmlspecialchars($linha['nome']) ?></td>

                            <td class="text-center">
                                <a href="/lp3_projeto/marcas/editar?id=<?= $linha['id'] ?>" class="btn btn-warning btn-sm">Editar</a>

                                <a href="/lp3_projeto/marcas/excluir?id=<?= $linha['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Tem certeza que deseja excluir esta marca?');">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Nenhuma marca cadastrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>