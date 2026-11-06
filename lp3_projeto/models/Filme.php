<?php
require_once __DIR__ . '/../config/Database.php';

class Filme {
    private $db;
    private $tabela = "filmes";

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar() {

        $stmt = $this->db->query("select * from $this->tabela order by id desc");
        return $stmt->fetchAll();

    }

    public function salvar(string $filme, string $diretor, ?int $duracao, ?string $imagem) {

        $sql = "insert into $this->tabela (filme, diretor, duracao, imagem) values (:filme, :diretor, :duracao, :imagem)";
        $stmt = $this->db->prepare($sql);

        $values = [
            ':filme' => $filme,
            ':diretor' => $diretor,
            ':duracao' => $duracao,
            ':imagem' => $imagem
        ];

        return $stmt->execute($values);

    }

    public function atualizar(int $id, string $filme, string $diretor, ?int $duracao, ?string $imagem) {

        $sql = "update $this->tabela set filme=:filme, diretor=:diretor, duracao=:duracao, imagem=:imagem where id=:id";
        $stmt = $this->db->prepare($sql);

        $values = [
            ':filme' => $filme,
            ':diretor' => $diretor,
            ':duracao' => $duracao,
            ':imagem' => $imagem,
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