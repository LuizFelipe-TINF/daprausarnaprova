<?php

class ClienteController
{

    private $model;

    public function __construct()
    {
        $this->model = new Cliente();
    }

    public function index()
    {   

        $clientes = $this->model->listar();
        require_once __DIR__ . '/../views/clientes/index.php';
    }

    public function adicionar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
            $salario = filter_input(INPUT_POST, 'salario', FILTER_VALIDATE_FLOAT);
            $sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_SPECIAL_CHARS);
            $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_SPECIAL_CHARS);
            $obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($nome && $email && $cpf && $salario && $sexo && $data && $obs) {

                $this->model->salvar($nome, $email, $cpf, $salario, $sexo, $data, $obs);

                header('Location: /lp3_projeto/clientes');
                exit;
            }
        }

        require_once __DIR__ . '/../views/clientes/criar.php';
    }

    public function editar()
    {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {

            header('Location: /lp3_projeto/clientes');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {            

            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
            $salario = filter_input(INPUT_POST, 'salario', FILTER_VALIDATE_FLOAT);
            $sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_SPECIAL_CHARS);
            $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_SPECIAL_CHARS);
            $obs = filter_input(INPUT_POST, 'obs', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($nome && $email && $cpf && $salario && $sexo && $data && $obs) {

                $this->model->atualizar($nome, $email, $cpf, $salario, $sexo, $data, $obs, $id);

                header('Location: /lp3_projeto/clientes');
                exit;
            }
        }

        $cliente = $this->model->buscarPorId($id);

        if (!$cliente) {
            header('Location: /lp3_projeto/clientes');
            exit;
        }

        require_once __DIR__ . '/../views/clientes/editar.php';
    }

    public function excluir()
    {

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {

            $this->model->excluir($id);
        }

        header('Location: /lp3_projeto/clientes');
        exit;
    }
}
