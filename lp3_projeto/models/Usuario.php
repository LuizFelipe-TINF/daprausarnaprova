<?php
require_once __DIR__ . '/../config/Database.php';

class Usuario {
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar() {
        $stmt = $this->db->query("select * from usuarios order by id desc");
        return $stmt->fetchAll();
    }

    public function salvar(string $nome, string $email) {
        $sql = "insert into usuarios (nome, email) values (:nome, :email)";
        $stmt = $this->db->prepare($sql);
        $values = [
            ':nome' => $nome,
            ':email' => $email
        ];
        return $stmt->execute($values);
    }

    public function atualizar(int $id, string $nome, string $email) {
        $sql = "update usuarios set nome=:nome, email=:email where id=:id";
        $stmt = $this->db->prepare($sql);
        $values = [
            ':nome' => $nome,
            ':email' => $email,
            ':id' => $id,
        ];
        return $stmt->execute($values);
    }

    public function buscarPorId(int $id) {
        $sql = "select * from usuarios where id = :id";
        $stmt = $this->db->prepare($sql);
        $values = [':id' => $id];
        $stmt->execute($values);
        return $stmt->fetch();
    }

    public function excluir(int $id) {
        $sql = "delete from usuarios where id = :id";
        $stmt = $this->db->prepare($sql);
        $values = [':id' => $id];
        return $stmt->execute($values);
    }
}