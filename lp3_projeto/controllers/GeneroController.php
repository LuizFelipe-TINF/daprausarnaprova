
<?php

class GeneroController {

    private $model;

    public function __construct()
    {
        $this->model = new Genero();
    }

    public function index() {

        $dados = $this->model->listar();

        require __DIR__ . '/../views/generos/index.php';

    }

    public function adicionar() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($nome) {

                $this->model->salvar($nome, $descricao ?: null);

                header('Location: /lp3_projeto/generos');
                exit;

            }
        }

        require __DIR__ . '/../views/generos/criar.php';

    }

    public function editar() {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {

            header('Location: /lp3_projeto/generos');
            exit;

        }

        // Verifica se houve POST e grava os dados no banco
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($nome) {

                $this->model->atualizar($id, $nome, $descricao ?: null);

                header('Location: /lp3_projeto/generos');
                exit;

            }
        }

        // Busca os dados do gênero selecionado
        $dado = $this->model->buscarPorId($id);

        if (!$dado) {

            header('Location: /lp3_projeto/generos');
            exit;

        }

        require __DIR__ . '/../views/generos/editar.php';

    }

    public function excluir() {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {

            $this->model->excluir($id);

        }

        header('Location: /lp3_projeto/generos');
        exit;

    }

}
