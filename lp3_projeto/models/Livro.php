
<?php
require_once __DIR__ . '/../config/Database.php';

class Livro {

    private $db;
    private $tabela = "livros";

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listar() {

        $sql = "select livros.*, generos.nome as genero from $this->tabela left join generos on livros.id_genero = generos.id order by livros.id asc";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();

    }

    public function salvar( string $titulo, string $autor, ?string $isbn, ?int $ano_publicacao, ?string $sinopse, ?string $capa, ?int $id_genero
    ) {

        $sql = "insert into $this->tabela(titulo, autor, isbn, ano_publicacao, sinopse, capa, id_genero) values (:titulo, :autor, :isbn, :ano_publicacao, :sinopse, :capa, :id_genero)";

        $stmt = $this->db->prepare($sql);

        $values = [
        ':titulo' => $titulo,
        ':autor' => $autor,
        ':isbn' => $isbn,
        ':ano_publicacao' => $ano_publicacao,
        ':sinopse' => $sinopse,
        ':capa' => $capa,
        ':id_genero' => $id_genero
        ];

        return $stmt->execute($values);

    }

    public function atualizar( int $id, string $titulo, string $autor, ?string $isbn, ?int $ano_publicacao, ?string $sinopse, ?string $capa, ?int $id_genero) {

        $sql = "update $this->tabela set titulo = :titulo, autor = :autor, isbn = :isbn, ano_publicacao = :ano_publicacao, sinopse = :sinopse, capa = :capa, id_genero = :id_genero where id = :id";

        $stmt = $this->db->prepare($sql);

        $values = [ ':titulo' => $titulo, ':autor' => $autor, ':isbn' => $isbn, ':ano_publicacao' => $ano_publicacao, ':sinopse' => $sinopse, ':capa' => $capa, ':id_genero' => $id_genero, ':id' => $id
        
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
