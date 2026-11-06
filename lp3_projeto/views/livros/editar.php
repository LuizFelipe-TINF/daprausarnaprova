
<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Editar Livro</h3>
        </div>

        <form action="/lp3_projeto/livros/editar?id=<?= $dado['id'] ?>" method="POST" enctype="multipart/form-data" class="card-form">

            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($dado['titulo']) ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" value="<?= htmlspecialchars($dado['autor']) ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($dado['isbn'] ?? '') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="ano_publicacao">Ano de publicação:</label>
                <input type="number" id="ano_publicacao" name="ano_publicacao" value="<?= htmlspecialchars($dado['ano_publicacao'] ?? '') ?>" class="form-control" min="1">
            </div>

            <div class="form-group">
                <label for="sinopse">Sinopse:</label>
                <textarea id="sinopse" name="sinopse" class="form-control" rows="4"><?= htmlspecialchars($dado['sinopse'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label for="id_genero">Gênero:</label>
                <select id="id_genero" name="id_genero" class="form-control">
                    <option value="">Selecione um gênero</option>

                    <?php foreach ($generos as $genero): ?>
                        <option value="<?= $genero['id'] ?>"
                            <?= ($dado['id_genero'] == $genero['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($genero['nome']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="form-group">
                <label for="capa">Capa do livro:</label>

                <?php if (!empty($dado['capa'])): ?>
                    <div class="mb-2">
                        <img src="/lp3_projeto/uploads/livros/<?= htmlspecialchars($dado['capa']) ?>"
                             alt="Capa atual do livro"
                             style="max-width: 150px; height: auto;">
                    </div>
                <?php endif; ?>

                <input type="file" id="capa" name="capa" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
                <small class="text-muted">Selecione uma nova imagem somente se quiser trocar a capa atual.</small>
            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-warning">Atualizar</button>
                <a href="/lp3_projeto/livros" class="btn btn-secondary">Voltar</a>
            </div>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>