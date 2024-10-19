<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $client;
    protected $apiUrl;
    protected $baseUrl;
    protected $apiKey;
    protected $instance;

    public function __construct()
    {
        $this->client = new Client();
        $this->instance = "/apiwp"; // Instancia da API
        $this->baseUrl = "https://apiwp.zadmin.app.br"; // URL base do serviço
        $this->apiKey = env('WHATSAPP_API_KEY'); // Chave da API
    }

    public function updateParticipants(array $phoneNumbers, string $action)
    {
        try {
            $response = $this->client->post("{$this->baseUrl}/group/updateParticipant/" . $this->instance . "?groupJid=120363326147593595@g.us", [
                'json' => [
                    'action' => $action,
                    'participants' => $phoneNumbers,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'apikey' => $this->apiKey,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return json_decode($response->getBody(), true);
            }
        } catch (RequestException $e) {
            Log::error('Erro na requisição ao WhatsApp API: ' . $e->getMessage());
        }

        return false;
    }

    public function sendMessage(array $numbers, string $msg)
    {
        try {
            foreach ($numbers as $number) {
                $response = $this->client->post("{$this->baseUrl}/message/sendText/" . $this->instance, [
                    'json' => [
                        'number' => $number, // Enviar um número por vez
                        'text' => $msg, // Mensagem a ser enviada
                    ],
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'apikey' => $this->apiKey,
                    ],
                ]);

                if ($response->getStatusCode() !== 200) {
                    Log::error('Erro na requisição ao WhatsApp API para o número ' . $number . ': ' . $response->getBody());
                }
            }
            return true;
        } catch (RequestException $e) {
            Log::error('Erro na requisição ao WhatsApp API: ' . $e->getMessage());
            return false;
        }
    }

}
