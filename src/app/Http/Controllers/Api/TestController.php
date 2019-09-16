<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    /**
     * @return Illuminate\Http\JsonResponse
     */
    public function index() : JsonResponse
    {
        return new JsonResponse(['Hello World'], Response::HTTP_OK);
    }
}