<?php

namespace App\Controllers;

class ErrorController {
    public static function notFound(): void {
        http_response_code(404);
        loadView("error", [
            'status' => '404 Error',
            'message' => 'This page does not exist',
        ]);
    }

    public static function forbidden(): void {
        http_response_code(403);
        loadView("error", [
            'status' => '403 Error',
            'message' => 'You are not authorized to view this page',
        ]);
    }
}
