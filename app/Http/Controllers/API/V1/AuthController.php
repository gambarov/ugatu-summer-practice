<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Resources\Employee\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function login(LoginAuthRequest $request)
    {
        $data = $request->validated();
        $employee = Employee::where('email', $data['email'])->first();

        if (!$employee || $data['password'] !== $employee->password) {
            return $this->respondUnauthorized('Неправильный логин и/или пароль');
        }

        $token = $employee->createToken('app')->plainTextToken;

        $response = [
            'employee' => EmployeeResource::make($employee),
            'token' => $token
        ];

        return $this->setHTTPStatusCode(201)->respond($response);
    }

    public function logout() {
        /** @var \App\Models\Employee $user **/
        $user = auth()->user();
        $user->tokens()->delete();

        return $this->setHTTPStatusCode(204)->respond([]);
    }
}
