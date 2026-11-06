
<?php
require_once __DIR__ . '/../config/Database.php';

class Genero {

    private $db;
    private $tabela = "generos";

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar() {

        $stmt = $this->db->query("select * from $this->tabela order by id desc");

        return $stmt->fetchAll();

    }

    public function salvar(string $nome, ?string $descricao) {

        $sql = "insert into $this->tabela (nome, descricao) values (:nome, :descricao)";

        $stmt = $this->db->prepare($sql);

        $values = [
            ':nome' => $nome,
            ':descricao' => $descricao
        ];

        return $stmt->execute($values);

    }

    public function atualizar(int $id, string $nome, ?string $descricao) {

        $sql = "update $this->tabela set nome = :nome, descricao = :descricao where id = :id";

        $stmt = $this->db->prepare($sql);

        $values = [
            ':nome' => $nome,
            ':descricao' => $descricao,
            ':id' => $id
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
