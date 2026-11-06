<?php

class ProdutoController {

    private $model;
    private $categoriaModel;

    public function __construct()
    {
        $this->model = new Produto();
        $this->categoriaModel = new Categoria();
    }

    public function index() {

        $dados = $this->model->listar();

        require __DIR__ . '/../views/produtos/index.php';

    }

    public function adicionar() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $produto = filter_input( INPUT_POST, 'produto', FILTER_SANITIZE_SPECIAL_CHARS);

        $valor = filter_input( INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);

        // Corrigido: o nome deve corresponder ao campo do formulário
        $categoria_id = filter_input( INPUT_POST, 'categoria_id', FILTER_VALIDATE_INT);

        $descricao = filter_input( INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($produto && $valor !== false && $valor !== null && $categoria_id !== false && $categoria_id !== null && $categoria_id > 0 && $descricao) {

        $this->model->salvar($produto, $valor, $categoria_id, $descricao );

        header('Location: /lp3_projeto/produtos'); 
        exit;
        }
    }

    $categorias = $this->categoriaModel->listar();

    require __DIR__ . '/../views/produtos/criar.php';
}

    public function editar() {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if(!$id) {

            header('Location: /lp3_projeto/produtos');
            exit;

        }

        // Verifica se houve post e faz a gravação dos dados no banco

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $produto = filter_input(INPUT_POST, 'produto', FILTER_SANITIZE_SPECIAL_CHARS);
            $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
            $categoria_id = filter_input(INPUT_POST, 'categoria_id', FILTER_VALIDATE_INT);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

            if($produto && $valor !== false && $descricao) {

                $this->model->atualizar($id, $produto, $valor, $categoria_id, $descricao);

                header('Location: /lp3_projeto/produtos');
                exit;

            }
        }

        // Busca dados do registro selecionado e carrega tela com os dados

        $dado = $this->model->buscarPorId($id);

        if(!$dado) {

            header('Location: /lp3_projeto/produtos');
            exit;

        }
        $categorias = $this->categoriaModel->listar();
        require __DIR__ . '/../views/produtos/editar.php';

    }

    public function excluir() {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if($id) {

            $this->model->excluir($id);

        }

        header('Location: /lp3_projeto/produtos');
        exit;

    }

}