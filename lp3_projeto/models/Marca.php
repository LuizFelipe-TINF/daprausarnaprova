
<?php
require_once __DIR__ . '/../config/Database.php';

class Marca {

    private $db;
    private $tabela = "marcas";

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar() {

        $stmt = $this->db->query("select * from $this->tabela order by id desc");

        return $stmt->fetchAll();

    }

    public function salvar(string $nome) {

        $sql = "insert into $this->tabela (nome) values ( :nome)";

        $stmt = $this->db->prepare($sql);

        $values = [

            ':nome' => $nome,
            
        ];

        return $stmt->execute($values);

    }

    public function atualizar(int $id, string $nome) {

        $sql = "update $this->tabela set nome = :nome where id = :id";

        $stmt = $this->db->prepare($sql);

        $values = [
            ':nome' => $nome,
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
