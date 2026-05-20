<?php

require_once __DIR__ . '/../../config/conexao.php';

class Projeto
{
    private $conexao;

    public function __construct()
    {
        global $conexao;
        $this->conexao = $conexao;
    }

    public function listarTodos()
    {
        $sql = "SELECT 
                    p.id_projeto,
                    p.nome_projeto,
                    p.api_key,
                    p.status,
                    u.nome
                FROM projetos p
                LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario
                ORDER BY p.id_projeto DESC";

        $resultado = $this->conexao->query($sql);

        $projetos = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $projetos[] = $linha;
            }
        }

        return $projetos;
    }

    public function cadastrar($nome_projeto, $id_usuario)
    {
        $api_key = "logify_" . bin2hex(random_bytes(16));
        $status = "ativo";

        $sql = "INSERT INTO projetos (nome_projeto, id_usuario, api_key, status)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("siss", $nome_projeto, $id_usuario, $api_key, $status);

        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM projetos WHERE id_projeto = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function atualizar($id_projeto, $nome_projeto, $id_usuario)
    {
        $sql = "UPDATE projetos 
                SET nome_projeto = ?, id_usuario = ?
                WHERE id_projeto = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("sii", $nome_projeto, $id_usuario, $id_projeto);

        return $stmt->execute();
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM projetos WHERE id_projeto = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function buscarPorApiKey($api_key)
    {
        $sql = "SELECT * FROM projetos 
                WHERE api_key = ? 
                AND status = 'ativo'";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("s", $api_key);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
}