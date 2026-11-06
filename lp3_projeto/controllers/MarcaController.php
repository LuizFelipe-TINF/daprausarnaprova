
<?php

class MarcaController {

    private $model;

    public function __construct()
    {
        $this->model = new Marca();
    }

    public function index() {

        $dados = $this->model->listar();

        require __DIR__ . '/../views/marcas/index.php';

    }

    public function adicionar() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($nome) {

                $this->model->salvar($nome);

                header('Location: /lp3_projeto/marcas');
                exit;

            }
        }

        require __DIR__ . '/../views/marcas/criar.php';

    }

    public function editar() {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {

            header('Location: /lp3_projeto/marcas');
            exit;

        }

        // Verifica se houve POST e grava os dados no banco
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($nome) {

                $this->model->atualizar($id, $nome);

                header('Location: /lp3_projeto/marcas');
                exit;

            }
        }

        // Busca os dados do gênero selecionado
        $dado = $this->model->buscarPorId($id);

        if (!$dado) {

            header('Location: /lp3_projeto/marcas');
            exit;

        }

        require __DIR__ . '/../views/marcas/editar.php';

    }

    public function excluir() {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {

            $this->model->excluir($id);

        }

        header('Location: /lp3_projeto/marcas');
        exit;

    }

}
