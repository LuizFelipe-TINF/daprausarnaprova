
<?php

require_once __DIR__ . '/../models/Filme.php';

class FilmeController
{
    private $model;

    public function __construct()
    {
        $this->model = new Filme();
    }

    public function index()
    {
        $dados = $this->model->listar();

        require __DIR__ . '/../views/filmes/index.php';
    }

    public function adicionar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filme = filter_input(INPUT_POST, 'filme', FILTER_SANITIZE_SPECIAL_CHARS);
            $diretor = filter_input(INPUT_POST, 'diretor', FILTER_SANITIZE_SPECIAL_CHARS);
            $duracao = filter_input(INPUT_POST, 'duracao', FILTER_VALIDATE_INT);

            if ($filme && $diretor) {
                $imagem = $this->processarImagem($_FILES['imagem'] ?? null);

                $this->model->salvar(
                    $filme,
                    $diretor,
                    ($duracao !== false && $duracao !== null) ? $duracao : null,
                    $imagem
                );

                header('Location: /lp3_projeto/filmes');
                exit;
            }
        }

        require __DIR__ . '/../views/filmes/criar.php';
    }

    public function editar()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /lp3_projeto/filmes');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filme = filter_input(INPUT_POST, 'filme', FILTER_SANITIZE_SPECIAL_CHARS);
            $diretor = filter_input(INPUT_POST, 'diretor', FILTER_SANITIZE_SPECIAL_CHARS);
            $duracao = filter_input(INPUT_POST, 'duracao', FILTER_VALIDATE_INT);

            $dadoAtual = $this->model->buscarPorId($id);

            if (!$dadoAtual) {
                header('Location: /lp3_projeto/filmes');
                exit;
            }

            $imagem = $this->processarImagem(
                $_FILES['imagem'] ?? null,
                $dadoAtual['imagem']
            );

            if ($filme && $diretor) {
                $this->model->atualizar(
                    $id,
                    $filme,
                    $diretor,
                    ($duracao !== false && $duracao !== null) ? $duracao : null,
                    $imagem
                );

                header('Location: /lp3_projeto/filmes');
                exit;
            }
        }

        $dado = $this->model->buscarPorId($id);

        if (!$dado) {
            header('Location: /lp3_projeto/filmes');
            exit;
        }

        require __DIR__ . '/../views/filmes/editar.php';
    }

    public function excluir()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            $dado = $this->model->buscarPorId($id);

            if ($dado && !empty($dado['imagem'])) {
                $caminho = __DIR__ . '/../uploads/filmes/' . $dado['imagem'];

                if (file_exists($caminho)) {
                    unlink($caminho);
                }
            }

            $this->model->excluir($id);
        }

        header('Location: /lp3_projeto/filmes');
        exit;
    }

    private function processarImagem($arquivo, ?string $imagemAtual = null): ?string
    {
        if (!isset($arquivo) || empty($arquivo['name'])) {
            return $imagemAtual;
        }

        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            return $imagemAtual;
        }

        $permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($arquivo['type'], $permitidos, true)) {
            return $imagemAtual;
        }

        $diretorio = __DIR__ . '/../uploads/filmes';

        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $nomeArquivo = time() . '_' . uniqid() . '.' . strtolower($extensao);
        $destino = $diretorio . '/' . $nomeArquivo;

        if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
            if ($imagemAtual && file_exists($diretorio . '/' . $imagemAtual)) {
                unlink($diretorio . '/' . $imagemAtual);
            }

            return $nomeArquivo;
        }

        return $imagemAtual;
    }
}
