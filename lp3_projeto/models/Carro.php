
<?php
require_once __DIR__ . '/../config/Database.php';

class Carro {

    private $db;
    private $tabela = "carros";

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar() {

        $sql = "select carros.*, marcas.nome as marca from $this->tabela left join marcas on carros.marca_id = marcas.id order by carros.id asc";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();

    }

    public function salvar( int $ano, string $modelo, ?int $marca_id) {

        $sql = "insert into $this->tabela(ano, modelo, marca_id) values (:ano, :modelo, :marca_id)";

        $stmt = $this->db->prepare($sql);

        $values = [
        ':ano' => $ano,
        ':modelo' => $modelo,
        ':marca_id' => $marca_id,
        ];

        return $stmt->execute($values);

    }

    public function atualizar( int $id, int $ano, string $modelo, ?int $marca_id) {

        $sql = "update $this->tabela set ano = :ano, modelo = :modelo, marca_id = :marca_id where id = :id";

        $stmt = $this->db->prepare($sql);

        $values = [ ':ano' => $ano, ':modelo' => $modelo, ':marca_id' => $marca_id, ':id' => $id ];

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
