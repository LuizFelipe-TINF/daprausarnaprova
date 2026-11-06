<?php
require_once __DIR__ . '/../config/Database.php';

class Produto {
    private $db;
    private $tabela = "produtos";

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar() {
    $sql = "select produtos.*, categorias.categoria
            from produtos
            left join categorias
            on produtos.categoria_id = categorias.id
            order by produtos.id desc";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
}

    
public function salvar(string $produto, float $valor, int $categoria_id, string $descricao) {

    $sql = "insert into $this->tabela (produto, valor, descricao, categoria_id) values (:produto, :valor, :descricao, :categoria_id)";

    $stmt = $this->db->prepare($sql);

    $values = [
        ':produto' => $produto,
        ':valor' => $valor,
        ':descricao' => $descricao,
        ':categoria_id' => $categoria_id
    ];

    return $stmt->execute($values);
}


    public function atualizar(int $id, string $produto, float $valor, int $categoria_id, string $descricao) {

        $sql = "update $this->tabela set produto=:produto, valor=:valor, categoria_id=:categoria_id, descricao=:descricao where id=:id";
        $stmt = $this->db->prepare($sql);

        $values = [
            ':produto' => $produto,
            ':valor' => $valor,
            ':categoria_id' => $categoria_id,
            ':descricao' => $descricao,
            ':id' => $id,
        ];

        return $stmt->execute($values);

    }

    public function buscarPorId(int $id) {

        $sql = "select * from $this->tabela where id = :id";
        $stmt = $this->db->prepare($sql);

        $values = [':id' => $id];

        $stmt->execute($values);

        return $stmt->fetch();

    }

    public function excluir(int $id) {

        $sql = "delete from $this->tabela where id = :id";
        $stmt = $this->db->prepare($sql);

        $values = [':id' => $id];

        return $stmt->execute($values);

    }
}