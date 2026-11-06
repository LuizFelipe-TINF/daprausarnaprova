<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="page-layout">
    <?php include __DIR__ . '/../layout/nav.php'; ?>

    <div class="content-panel">
        <div class="header-action">
            <h3>Editar Carro</h3>
        </div>

        <form action="/lp3_projeto/carros/editar?id=<?= $dado['id'] ?>" method="POST" enctype="multipart/form-data" class="card-form">

            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" value="<?= htmlspecialchars($dado['modelo']) ?>" required class="form-control">
            </div>

            <div class="form-group">
                <label for="ano">Ano:</label>
                <input type="number" id="ano" name="ano" value="<?= htmlspecialchars($dado['ano'] ?? '') ?>" class="form-control" min="1">
            </div>

            <div class="form-group">
                <label for="marca_id">Marca:</label>
                <select id="marca_id" name="marca_id" class="form-control">
                    <option value="">Selecione uma marca</option>

                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?= $marca['id'] ?>"
                            <?= ($dado['marca_id'] == $marca['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($marca['nome']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>


            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-warning">Atualizar</button>
                <a href="/lp3_projeto/carros" class="btn btn-secondary">Voltar</a>
            </div>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>