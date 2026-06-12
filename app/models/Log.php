<?php

require_once __DIR__ . '/../../config/conexao.php';

class Log
{
    private $conexao;

    public function __construct()
    {
        global $conexao;
        $this->conexao = $conexao;
    }

    public function listarTodos()
    {
        $sql = "SELECT l.id_log, l.mensagem, p.nome_projeto
                FROM logs_erro l
                INNER JOIN projetos p ON l.id_projeto = p.id_projeto
                ORDER BY l.id_log DESC";

        $resultado = $this->conexao->query($sql);

        $logs = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $logs[] = $linha;
            }
        }

        return $logs;
    }

    public function listarPorProjeto($id_projeto)
    {
        $sql = "SELECT l.id_log, l.mensagem, p.nome_projeto
                FROM logs_erro l
                INNER JOIN projetos p ON l.id_projeto = p.id_projeto
                WHERE l.id_projeto = ?
                ORDER BY l.id_log DESC";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id_projeto);
        $stmt->execute();

        $resultado = $stmt->get_result();

        $logs = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $logs[] = $linha;
            }
        }

        return $logs;
    }

    // 🔥 Ajustado para receber o ID do projeto primeiro, o nível e a mensagem
    public function cadastrar($id_projeto, $nivel, $mensagem)
    {
        $sql = "INSERT INTO logs_erro (id_projeto, nivel, mensagem) VALUES (?, ?, ?)";
        $stmt = $this->conexao->prepare($sql);
        
        // 'iss' significa: Integer, String, String
        $stmt->bind_param("iss", $id_projeto, $nivel, $mensagem);

        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM logs_erro WHERE id_log = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function atualizar($id_log, $mensagem, $id_projeto)
    {
        $sql = "UPDATE logs_erro SET mensagem = ?, id_projeto = ? WHERE id_log = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("sii", $mensagem, $id_projeto, $id_log);

        return $stmt->execute();
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM logs_erro WHERE id_log = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function contarLogsPorUsuario($id_usuario)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM logs_erro l
                INNER JOIN projetos p ON l.id_projeto = p.id_projeto
                WHERE p.id_usuario = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $linha = $resultado->fetch_assoc();

        return $linha['total'] ?? 0;
    }
}