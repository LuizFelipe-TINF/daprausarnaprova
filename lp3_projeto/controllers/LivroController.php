
    <?php

    class LivroController {

        private $model;
        private $generoModel;

        public function __construct()
        {
            $this->model = new Livro();
            $this->generoModel = new Genero();
        }

        public function index() {

            $dados = $this->model->listar();

            require __DIR__ . '/../views/livros/index.php';

        }

        public function adicionar() {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
                $autor = filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_SPECIAL_CHARS);
                $isbn = filter_input(INPUT_POST, 'isbn', FILTER_SANITIZE_SPECIAL_CHARS);
                $ano_publicacao = filter_input(INPUT_POST, 'ano_publicacao', FILTER_VALIDATE_INT);
                $sinopse = filter_input(INPUT_POST, 'sinopse', FILTER_SANITIZE_SPECIAL_CHARS);
                $id_genero = filter_input(INPUT_POST, 'id_genero', FILTER_VALIDATE_INT);

                // Processa a capa enviada
                $capa = $this->processarImagem($_FILES['capa'] ?? null);

                if ($titulo && $autor) {

                    $this->model->salvar(
                        $titulo,
                        $autor,
                        $isbn ?: null,
                        ($ano_publicacao !== false && $ano_publicacao !== null) ? $ano_publicacao : null,
                        $sinopse ?: null,
                        $capa,
                        ($id_genero !== false && $id_genero > 0) ? $id_genero : null
                    );

                    header('Location: /lp3_projeto/livros');
                    exit;

                }
            }

            $generos = $this->generoModel->listar();

            require __DIR__ . '/../views/livros/criar.php';

        }

        public function editar() {

            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            if (!$id) {

                header('Location: /lp3_projeto/livros');
                exit;

            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
                $autor = filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_SPECIAL_CHARS);
                $isbn = filter_input(INPUT_POST, 'isbn', FILTER_SANITIZE_SPECIAL_CHARS);
                $ano_publicacao = filter_input(INPUT_POST, 'ano_publicacao', FILTER_VALIDATE_INT);
                $sinopse = filter_input(INPUT_POST, 'sinopse', FILTER_SANITIZE_SPECIAL_CHARS);
                $id_genero = filter_input(INPUT_POST, 'id_genero', FILTER_VALIDATE_INT);

                // Busca os dados atuais do livro
                $dadoAtual = $this->model->buscarPorId($id);

                if (!$dadoAtual) {

                    header('Location: /lp3_projeto/livros');
                    exit;

                }

                // Processa a nova capa ou mantém a atual
                $capa = $this->processarImagem(
                    $_FILES['capa'] ?? null,
                    $dadoAtual['capa']
                );

                if ($titulo && $autor) {

                    $this->model->atualizar(
                        $id,
                        $titulo,
                        $autor,
                        $isbn ?: null,
                        ($ano_publicacao !== false && $ano_publicacao !== null) ? $ano_publicacao : null,
                        $sinopse ?: null,
                        $capa,
                        ($id_genero !== false && $id_genero > 0) ? $id_genero : null
                    );

                    header('Location: /lp3_projeto/livros');
                    exit;

                }
            }

            // Busca os dados do livro para carregar a tela de edição
            $dado = $this->model->buscarPorId($id);

            if (!$dado) {

                header('Location: /lp3_projeto/livros');
                exit;

            }

            $generos = $this->generoModel->listar();

            require __DIR__ . '/../views/livros/editar.php';

        }

        public function excluir() {

            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            if ($id) {

                $dado = $this->model->buscarPorId($id);

                if ($dado && !empty($dado['capa'])) {

                    $caminho = __DIR__ . '/../uploads/livros/' . $dado['capa'];

                    if (file_exists($caminho)) {
                        unlink($caminho);
                    }

                }

                $this->model->excluir($id);

            }

            header('Location: /lp3_projeto/livros');
            exit;

        }

        private function processarImagem($arquivo, ?string $imagemAtual = null): ?string {

            // Verifica se o arquivo foi enviado
            if (!isset($arquivo) || empty($arquivo['name'])) {
                return $imagemAtual;
            }

            // Confere se não houve erro no upload
            if ($arquivo['error'] !== UPLOAD_ERR_OK) {
                return $imagemAtual;
            }

            // Permite apenas imagens válidas
            $permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

            if (!in_array($arquivo['type'], $permitidos, true)) {
                return $imagemAtual;
            }

            // Cria a pasta de upload, se necessário
            $diretorio = __DIR__ . '/../uploads/livros';

            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0777, true);
            }

            // Gera nome único para a imagem
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            $nomeArquivo = time() . '_' . uniqid() . '.' . strtolower($extensao);
            $destino = $diretorio . '/' . $nomeArquivo;

            // Move a imagem para a pasta e remove a antiga, se existir
            if (move_uploaded_file($arquivo['tmp_name'], $destino)) {

                if ($imagemAtual && file_exists($diretorio . '/' . $imagemAtual)) {
                    unlink($diretorio . '/' . $imagemAtual);
                }

                return $nomeArquivo;
            }

            // Se falhar, mantém a imagem atual
            return $imagemAtual;
        }

    }
