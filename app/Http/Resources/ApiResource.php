<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource
{
    /**
     * Crée une réponse JSON standardisée pour les succès
     *
     * @param mixed|null $data Les données à retourner
     * @param string|null $message Message de succès
     * @param int $code Code HTTP
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(mixed $data = null, ?string $message = null, int $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, $code);
    }

    /**
     * Crée une réponse JSON standardisée pour les erreurs
     *
     * @param string|null $message Message d'erreur
     * @param mixed|null $errors Détails des erreurs
     * @param int $code Code HTTP
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(?string $message = null, mixed $errors = null, int $code = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ];

        return response()->json($response, $code);
    }
}
