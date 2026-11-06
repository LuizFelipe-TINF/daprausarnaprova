<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Editar Filme</h3>
        </div>

        <form action="/lp3_projeto/filmes/editar?id=<?= $dado['id'] ?>" method="POST" enctype="multipart/form-data" class="card-form">

            <div class="form-group">
                <label for="filme">Filme:</label>
                <input type="text" id="filme" name="filme" value="<?= htmlspecialchars($dado['filme']) ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="diretor">Diretor:</label>
                <input type="text" id="diretor" name="diretor" value="<?= htmlspecialchars($dado['diretor']) ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="duracao">Duração (minutos):</label>
                <input type="number" id="duracao" name="duracao" value="<?= htmlspecialchars($dado['duracao'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="imagem">Imagem:</label>

                <?php if (!empty($dado['imagem'])): ?>
                    <div class="mb-2">
                        <img src="/lp3_projeto/uploads/filmes/<?= htmlspecialchars($dado['imagem']) ?>"
                             alt="imagem do filme"
                             style="max-width: 150px; height: auto;">
                    </div>
                <?php endif; ?>

                <input type="file" id="imagem" name="imagem" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
                <small class="text-muted">Selecione uma nova imagem somente se quiser trocar a atual.</small>
            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-warning">Atualizar</button>
                <a href="/lp3_projeto/filmes" class="btn btn-secondary">Voltar</a>
            </div>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>