<?php

class MercadoPagoService
{
    private $accessToken = "SEU_ACCESS_TOKEN_AQUI";

    public function criarPagamento($valor, $descricao)
    {
        $url = "https://api.mercadopago.com/checkout/preferences";

        $data = [
            "items" => [
                [
                    "title" => $descricao,
                    "quantity" => 1,
                    "unit_price" => (float)$valor
                ]
            ],
            "back_urls" => [
                "success" => "http://localhost/ProjetoLogify/public/?acao=pagamento_sucesso",
                "failure" => "http://localhost/ProjetoLogify/public/?acao=pagamento_falha"
            ],
            "auto_return" => "approved"
        ];

        $headers = [
            "Authorization: Bearer " . $this->accessToken,
            "Content-Type: application/json"
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        curl_close($ch);

        return json_decode($response, true);
    }
}