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
        $sql = "SELECT p.id_projeto, p.nome_projeto, u.nome 
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
    $sql = "INSERT INTO projetos (nome_projeto, id_usuario) VALUES (?, ?)";
    $stmt = $this->conexao->prepare($sql);
    $stmt->bind_param("si", $nome_projeto, $id_usuario);

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
    $sql = "UPDATE projetos SET nome_projeto = ?, id_usuario = ? WHERE id_projeto = ?";
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
}