<?php

require_once __DIR__ . '/../../config/conexao.php';

class Usuario
{
    private $conexao;

    public function __construct()
    {
        global $conexao;
        $this->conexao = $conexao;
    }

    public function listarTodos()
    {
        $sql = "SELECT * FROM usuarios ORDER BY id_usuario DESC";
        $resultado = $this->conexao->query($sql);

        $usuarios = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $usuarios[] = $linha;
            }
        }

        return $usuarios;
    }

    public function cadastrar($nome, $email, $senha, $plano)
    {
        $sql = "INSERT INTO usuarios (nome, email, senha, plano) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, $senha, $plano);

        return $stmt->execute();
    }

    public function buscarPorId($id)
{
    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
    $stmt = $this->conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();
    return $resultado->fetch_assoc();
}

public function atualizar($id, $nome, $email, $senha, $plano)
{
    $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ?, plano = ? WHERE id_usuario = ?";
    $stmt = $this->conexao->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $email, $senha, $plano, $id);

    return $stmt->execute();
}
public function excluir($id)
{
    $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt = $this->conexao->prepare($sql);
    $stmt->bind_param("i", $id);

    return $stmt->execute();
}
}