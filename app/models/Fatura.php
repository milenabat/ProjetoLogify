<?php

require_once __DIR__ . '/../../config/conexao.php';

class Fatura
{
    private $conexao;

    public function __construct()
    {
        global $conexao;
        $this->conexao = $conexao;
    }

    public function listarTodos()
    {
        $sql = "SELECT f.id_fatura, f.valor, f.status, u.nome
                FROM faturas f
                LEFT JOIN usuarios u ON f.id_usuario = u.id_usuario
                ORDER BY f.id_fatura DESC";

        $resultado = $this->conexao->query($sql);

        $faturas = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $faturas[] = $linha;
            }
        }

        return $faturas;
    }

    public function cadastrar($id_usuario, $valor, $status)
    {
        $sql = "INSERT INTO faturas (id_usuario, valor, status) VALUES (?, ?, ?)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ids", $id_usuario, $valor, $status);

        if ($stmt->execute()) {
            // 🔥 CORREÇÃO MÁGICA: Agora devolve o número da fatura criada!
            return $stmt->insert_id;
        }
        return false;
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM faturas WHERE id_fatura = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function atualizar($id_fatura, $id_usuario, $valor, $status)
    {
        $sql = "UPDATE faturas SET id_usuario = ?, valor = ?, status = ? WHERE id_fatura = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("idsi", $id_usuario, $valor, $status, $id_fatura);

        return $stmt->execute();
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM faturas WHERE id_fatura = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function marcarComoPago($id_fatura)
    {
        $sql = "UPDATE faturas SET status = 'Pago' WHERE id_fatura = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id_fatura);

        return $stmt->execute();
    }

    public function anexarComprovante($id_fatura, $nome_arquivo)
    {
        $sql = "UPDATE faturas 
                SET status = 'Em Análise', arquivo_comprovante = ? 
                WHERE id_fatura = ?";
                
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("si", $nome_arquivo, $id_fatura);
        
        return $stmt->execute();
    }

    public function listarTodasAdmin()
    {
        $sql = "SELECT f.*, u.nome AS nome_cliente 
                FROM faturas f
                INNER JOIN usuarios u ON f.id_usuario = u.id_usuario
                ORDER BY f.id_fatura DESC";
                
        $resultado = $this->conexao->query($sql);
        $faturas = [];
        
        if ($resultado && $resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $faturas[] = $linha;
            }
        }
        return $faturas;
    }

    public function aprovar($id_fatura)
    {
        $sql = "UPDATE faturas SET status = 'Pago' WHERE id_fatura = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id_fatura);
        return $stmt->execute();
    }
}