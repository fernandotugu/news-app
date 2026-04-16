<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SwaggerDocumentationController extends Controller
{
    public function ui()
    {
        return view('swagger.ui', [
            'specUrl' => route('swagger.openapi'),
        ]);
    }

    public function spec(): BinaryFileResponse
    {
        return response()->file(
            base_path('openapi/openapi.yaml'),
            ['Content-Type' => 'application/x-yaml; charset=UTF-8'],
        );
    }
}
