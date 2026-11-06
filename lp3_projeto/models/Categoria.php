<?php
require_once __DIR__ . '/../config/Database.php';

class Categoria {
    private $db;
    private $tabela = "categorias";

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar() {
        $stmt = $this->db->query("select * from $this->tabela order by categoria asc");
        return $stmt->fetchAll();
    }

    public function salvar(string $categoria, string $descricao) {
        $sql = "insert into $this->tabela (categoria, descricao) values (:categoria, :descricao)";
        $stmt = $this->db->prepare($sql);
        $values = [
            ':categoria' => $categoria,
            ':descricao' => $descricao
        ];
        return $stmt->execute($values);
    }

    public function atualizar(int $id, string $categoria, string $descricao) {
        $sql = "update $this->tabela set categoria=:categoria, descricao=:descricao where id=:id";
        $stmt = $this->db->prepare($sql);
        $values = [
            ':categoria' => $categoria,
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