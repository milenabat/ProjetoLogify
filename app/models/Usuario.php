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

    public function contarProjetos($id_usuario)
    {
        $sql = "SELECT COUNT(*) AS total FROM projetos WHERE id_usuario = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $linha = $resultado->fetch_assoc();

        return $linha['total'];
    }

    public function contarFaturas($id_usuario)
    {
        $sql = "SELECT COUNT(*) AS total FROM faturas WHERE id_usuario = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $linha = $resultado->fetch_assoc();

        return $linha['total'];
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function atualizarPlano($id_usuario, $plano)
    {
        $sql = "UPDATE usuarios SET plano = ? WHERE id_usuario = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("si", $plano, $id_usuario);

        return $stmt->execute();
    }

    public function buscarPorEmail($email)
    {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $resultado = $stmt->get_result();

        return $resultado->fetch_assoc();
    }

    public function cadastrar($nome, $email, $senha)
    {
        // Forçamos o tipo de conta como usuário comum e o plano inicial
        $tipo = 'user';
        $plano = 'Free'; 
        
        // Criptografia nativa do PHP para não salvar senhas em texto puro
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

        // Sintaxe MySQLi usando pontos de interrogação
        $sql = "INSERT INTO usuarios (nome, email, senha, plano, tipo) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conexao->prepare($sql);
        
        // "sssss" indica que estamos passando 5 strings
        $stmt->bind_param("sssss", $nome, $email, $senha_criptografada, $plano, $tipo);

        return $stmt->execute();
    }
}