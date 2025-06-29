<?php

namespace Bits\MmShopBundle\Payment;

class Paypal
{
    private $session;
    private string $clientId;
    private string $secret;
    private string $apiBase;
    private HttpClientInterface $client;

    public function __construct($session,HttpClientInterface $client, string $clientId, string $secret, string $apiBase)
    {
        $this->session = $session;
        $this->client = $client;
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->apiBase = $apiBase;
    }

    private function getAccessToken(): string
    {
        $response = $this->client->request('POST', $this->apiBase . '/v1/oauth2/token', [
            'auth_basic' => [$this->clientId, $this->secret],
            'body' => 'grant_type=client_credentials',
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        $data = $response->toArray();
        return $data['access_token'];
    }

    public function createOrder(float $amount, string $currency, string $returnUrl, string $cancelUrl): string
    {
        $accessToken = $this->getAccessToken();

        $response = $this->client->request('POST', $this->apiBase . '/v2/checkout/orders', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => $amount,//number_format($amount, 2, '.', ''),
                    ]
                ]],
                'application_context' => [
                    'return_url' => $returnUrl,
                    'cancel_url' => $cancelUrl,
                ],
            ],
        ]);

        $data = $response->toArray();
        //save paypal_order_id
        $this->session->set('paypal_order_id',$data['id']);
        foreach ($data['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return $link['href']; // Hierhin umleiten!
            }
        }

        throw new \RuntimeException('Keine PayPal Approve URL gefunden.');
    }
}
