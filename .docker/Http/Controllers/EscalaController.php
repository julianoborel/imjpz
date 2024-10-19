<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
class EscalaController extends Controller
{
    public function checkEscala(Request $request)
    {
        // Valida a requisição para garantir que a data foi enviada
        $validated = $request->validate([
            'data' => 'required|date_format:Y-m-d', // Esperando a data no formato 'YYYY-MM-DD'
        ]);

        // Pega a data da requisição
        $data = $validated['data'];

        // Cria um objeto DateTime com a data fornecida
        $dataObj = new DateTime($data);

        // Subtrai 4 dias
        $dataObj->modify('-4 days');

        // Retorna a data formatada como 'dd/mm/YYYY'
        return response()->json([
            'data_original' => $data,
            'data_modificada' => $dataObj->format('d/m/Y'),
        ]);
    }

}
