
    <?php

    class CarroController {

        private $model;
        private $marcaModel;

        public function __construct()
        {
            $this->model = new Carro();
            $this->marcaModel = new Marca();
        }

        public function index() {

            $dados = $this->model->listar();

            require __DIR__ . '/../views/carros/index.php';

        }

        public function adicionar() {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $modelo = filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_SPECIAL_CHARS);
                $ano = filter_input(INPUT_POST, 'ano', FILTER_VALIDATE_INT);
                $marca_id = filter_input(INPUT_POST, 'marca_id', FILTER_VALIDATE_INT);

                if ($ano && $modelo) {

                    $this->model->salvar(
                        ($ano !== false && $ano !== null) ? $ano : null,
                        $modelo,
                        ($marca_id !== false && $marca_id > 0) ? $marca_id : null );

                    header('Location: /lp3_projeto/carros');
                    exit;

                }
            }

            $marcas = $this->marcaModel->listar();

            require __DIR__ . '/../views/carros/criar.php';

        }

        public function editar() {

            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            if (!$id) {

                header('Location: /lp3_projeto/carros');
                exit;

            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $modelo = filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_SPECIAL_CHARS);
                $ano = filter_input(INPUT_POST, 'ano', FILTER_VALIDATE_INT);
                $marca_id = filter_input(INPUT_POST, 'marca_id', FILTER_VALIDATE_INT);

                // Busca os dados atuais do livro
                $dadoAtual = $this->model->buscarPorId($id);

                if (!$dadoAtual) {

                    header('Location: /lp3_projeto/carros');
                    exit;

                }
                

                if ($ano && $modelo) {

                    $this->model->atualizar(
                        $id,
                        ($ano !== false && $ano !== null) ? $ano : null,
                        $modelo,
                        ($marca_id !== false && $marca_id > 0) ? $marca_id : null
                    );

                    header('Location: /lp3_projeto/carros');
                    exit;

                }
            }

            // Busca os dados do livro para carregar a tela de edição
            $dado = $this->model->buscarPorId($id);

            if (!$dado) {

                header('Location: /lp3_projeto/carros');
                exit;

            }

            $marcas = $this->marcaModel->listar();

            require __DIR__ . '/../views/carros/editar.php';

        }

        public function excluir() {

            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            if ($id) {

                $dado = $this->model->buscarPorId($id);

                $this->model->excluir($id);

            }

            header('Location: /lp3_projeto/carros');
            exit;

        }

    }