    <?php include __DIR__ . '/../layout/header.php'; ?>

    <div class="page-layout">
        <?php include __DIR__ . '/../layout/nav.php'; ?>

        <div class="content-panel">
            <div class="header-action">
                <h3>Editar Produtos</h3>
            </div>

            <form action="/lp3_projeto/produtos/editar?id=<?= $dado['id'] ?>" method="POST" class="card-form">
                <div class="form-group">
                    <label for="produto">Produto:</label>
                    <input type="text" id="produto" name="produto" value="<?= htmlspecialchars($dado['produto']) ?>" required class="form-control">
                </div>
            
                <div class="form-group">
                    <label for="valor">Valor:</label>
                    <input type="number" id="valor" name="valor" step="0.01" value="<?= htmlspecialchars($dado['valor']) ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="categoria_id">Categoria:</label>
                    <select name="categoria_id" id="categoria_id" class="form-select" required>
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?= $categoria['id'] ?>"
                        <?php if ($categoria['id'] == $dado['categoria_id']) echo 'selected'; ?>>
                        <?= htmlspecialchars($categoria['categoria']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea class="form-control" name="descricao" id="descricao"><?= htmlspecialchars($dado['descricao']) ?></textarea>
                </div>

                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-warning">Atualizar</button>
                    <a href="/lp3_projeto/usuarios" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>

    <?php include __DIR__ . '/../layout/footer.php'; ?>