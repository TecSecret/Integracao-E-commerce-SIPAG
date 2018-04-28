<?php

//EXEMPLO VENDA
$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">';
    $xml .= '<SOAP-ENV:Header />';
    $xml .= '<SOAP-ENV:Body>';
        $xml .= '<ipgapi:IPGApiOrderRequest xmlns:v1="http://ipg-online.com/ipgapi/schemas/v1" xmlns:ipgapi="http://ipg-online.com/ipgapi/schemas/ipgapi">';
            $xml .= '<v1:Transaction>';
                $xml .= '<v1:CreditCardTxType>';
                    $xml .= '<v1:Type>sale</v1:Type>';
                $xml .= '</v1:CreditCardTxType>';
                $xml .= '<v1:cardFunction>credit</v1:cardFunction>';
                $xml .= '<v1:Payment>';
                    $xml .= '<v1:ChargeTotal>20</v1:ChargeTotal>';
                    $xml .= '<v1:Currency>986</v1:Currency>';
                $xml .= '</v1:Payment>';
            $xml .= '</v1:Transaction>';
        $xml .= '</ipgapi:IPGApiOrderRequest>';
    $xml .= '</SOAP-ENV:Body>';
$xml .= '</SOAP-ENV:Envelope>';

//EXEMPLO RETORNAR TRANSAÇÕES
$xml2  = '<?xml version="1.0" encoding="UTF-8"?>';
$xml2 .= '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">';
    $xml2 .= '<SOAP-ENV:Header />';
    $xml2 .= '<SOAP-ENV:Body>';
    $xml2 .= '<ipgapi:IPGApiActionRequest xmlns:ipgapi="http://ipg-online.com/ipgapi/schemas/ipgapi" xmlns:a1="http://ipg-online.com/ipgapi/schemas/a1" xmlns:v1="http://ipg-online.com/ipgapi/schemas/v1">';
        $xml2 .= '<a1:Action>';
            $xml2 .= '<a1:GetLastTransactions>';
                    $xml2 .= '<a1:count>20</a1:count>';
                $xml2 .= '</a1:GetLastTransactions>';         
            $xml2 .= '</a1:Action>';
        $xml2 .= '</ipgapi:IPGApiActionRequest>';
    $xml2 .= '</SOAP-ENV:Body>';
$xml2 .= '</SOAP-ENV:Envelope>';

//Conexão via CURL - deve estar habilitado no php.ini
$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, "https://test.ipg-online.com/ipgapi/services"); //Teste
curl_setopt($ch, CURLOPT_URL, "https://www2.ipg-online.com/ipgapi/services"); //Produção
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
curl_setopt($ch, CURLOPT_HTTPAUTH, 'CURLAUTH_BASIC');
curl_setopt($ch, CURLOPT_USERPWD, 'loja_id:senha_usuario'); //Loja e Senha do usuário fornecido pela sipag/firstdata
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSLCERT, './loja_id.pem'); //Caminho do certificado assume que está no mesmo diretório
curl_setopt($ch, CURLOPT_SSLKEY, './loja_id.key'); //Caminho da chave do certificado assume que está no mesmo diretório
curl_setopt($ch, CURLOPT_SSLKEYPASSWD, 'senha_certificado'); //Senha do certificado fornecido pela sipag/firstdata
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

//LOG DE CONEXÃO CURL - Cria um arquivo TXT com o log da conexão
//curl_setopt($ch, CURLOPT_VERBOSE, true);
//$verbose = fopen('temp.txt', 'w+');
//curl_setopt($ch, CURLOPT_STDERR, $verbose);

$resposta = curl_exec($ch);

//Erros e informação de conexão
//print_r(curl_errno($ch));
//print_r(curl_error($ch));
//print_r(curl_getinfo($ch), 1);

//Exibe a resposta
print_r($resposta);

curl_close ($ch);