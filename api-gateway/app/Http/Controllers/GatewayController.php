<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    protected $client;

    public function __construct()
    {
        // Configura los URLs base de tus microservicios
        $this->authorsServiceUrl = env('AUTHORS_SERVICE_URL', 'http://localhost:9001');
        $this->booksServiceUrl   = env('BOOKS_SERVICE_URL', 'http://localhost:9002');

        $this->client = new Client();
    }

    /**
     * Redirige peticiones relacionadas con Authors.
     */
    public function authors(Request $request, $authorId = null)
    {
        $url = $this->authorsServiceUrl . '/authors';

        if ($authorId) {
            $url .= '/' . $authorId;
        }

        return $this->handleRequest($request, $url);
    }

    /**
     * Redirige peticiones relacionadas con Books.
     */
    public function books(Request $request, $bookId = null)
    {
        $url = $this->booksServiceUrl . '/books';

        if ($bookId) {
            $url .= '/' . $bookId;
        }

        return $this->handleRequest($request, $url);
    }

    /**
     * Maneja la petición y la reenvía con Guzzle al microservicio correspondiente.
     */
    private function handleRequest(Request $request, $url)
    {
        // Determinar el método (GET, POST, PUT, DELETE, etc.)
        $method = $request->getMethod();

        // Separa los headers que necesites reenviar (Auth, etc.)
        $headers = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ];

        // Construye las opciones
        $options = [
            'headers' => $headers,
            'json'    => $request->all(),
            'query'   => $request->query(),
        ];

        try {
            $response = $this->client->request($method, $url, $options);
            return response($response->getBody(), $response->getStatusCode())
                ->header('Content-Type', $response->getHeaderLine('Content-Type'));
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}