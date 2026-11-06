<?php
class CategoriaController {
    private $model;

    public function __construct()
    {
        $this->model = new Categoria();
    }

    public function index() {
        $dados = $this->model->listar();
        require __DIR__ . '/../views/categorias/index.php';
    }

    public function adicionar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

            if($categoria && $descricao) {
                $this->model->salvar($categoria, $descricao);
                header('Location: /lp3_projeto/categorias');
                exit;
            }
        }
        require __DIR__ . '/../views/categorias/criar.php';
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /lp3_projeto/categorias');
            exit;
        }

        // Verifica se houve post e faz a gravação dos dados no banco
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

            if($categoria && $descricao) {
                $this->model->atualizar($id, $categoria, $descricao);
                header('Location: /lp3_projeto/categorias');
                exit;
            }
        }

        // Busca dados do registro selecionado e carrega tela com os dados
        $dado = $this->model->buscarPorId($id);

        if(!$dado) {
            header('Location: /lp3_projeto/categorias');
            exit;
        }

        require __DIR__ . '/../views/categorias/editar.php';
    }

    public function excluir() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if($id) {
            $this->model->excluir($id);
        }

        header('Location: /lp3_projeto/categorias');
        exit;
    }
}
