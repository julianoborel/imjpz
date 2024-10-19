<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WppController extends Controller
{

    public function addParticipant(Request $request)
    {
        // Valida os dados recebidos
        /*$request->validate([
            'groupId' => 'required|string',
            'phones' => 'required|array',
            'phones.*' => 'required|string', // Cada telefone deve ser uma string
            'autoInvite' => 'required|boolean', // autoInvite deve ser um booleano
        ]);*/

        // Obtém os dados da requisição
        //$groupId = $request->input('groupId');
        $action = $request->input('action');
        $participants = $request->input('participants');

        // Configura a requisição para a API
        $instanceId = "3D6A65F564DFE06459B43E72838DD104";
        $token = "350BDBD7DFC613945D291028";
        $apiUrl = "http://localhost:8080/group/updateParticipant/teste?groupJid=120363326147593595@g.us";

        // Inicializa o cliente Guzzle
        $client = new Client();

        try {
            // Envia a requisição
            $response = $client->put($apiUrl, [
                'json' => [
                    'action' => $action,
                    'participants' => $participants,
                ]
            ]);

            // Retorna a resposta
            return response()->json(json_decode($response->getBody(), true));
        } catch (RequestException $ex) {
            // Em caso de erro, captura a exceção e retorna a mensagem de erro
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function sendText(Request $request)
    {
        // Valida os dados recebidos
        $request->validate([
            'phone' => 'required|string', // O telefone deve ser uma string
            'message' => 'required|string', // A mensagem deve ser uma string
        ]);

        // Obtém os dados da requisição
        $phone = $request->input('phone');
        $message = $request->input('message');

        // Configura a requisição para a API
        $instanceId = "3D6A65F564DFE06459B43E72838DD104";
        $token = "350BDBD7DFC613945D291028";
        $apiUrl = "https://api.z-api.io/instances/{$instanceId}/token/{$token}/send-text";

        // Inicializa o cliente Guzzle
        $client = new Client();

        try {
            // Envia a requisição
            $response = $client->post($apiUrl, [
                'json' => [
                    'phone' => $phone,
                    'message' => $message,
                ],
                'headers' => [
                    'content-type' => 'application/json',
                    'client-token' => 'Fab0ad4bf396a4eb8b17825e5faa3d590S', // Substitua pelo token correto
                ],
            ]);

            // Retorna a resposta
            return response()->json(json_decode($response->getBody(), true));
        } catch (RequestException $ex) {
            // Em caso de erro, captura a exceção e retorna a mensagem de erro
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

}
