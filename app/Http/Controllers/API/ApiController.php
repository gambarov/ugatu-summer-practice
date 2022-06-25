<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\JsonRespondController;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use JsonRespondController;

    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            // Если метод не GET или DELETE, значит должно иметься поле тело запроса
            if ($request->method() != 'GET' && $request->method() != 'DELETE') {
                if (is_null(json_encode($request->getContent()))) {
                    return $this->setHTTPStatusCode(400)
                        ->setErrorCode(37)
                        ->respondWithError('Неверный формат данных');
                }
            }

            return $next($request);
        });
    }
}
