<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginAuthRequest $request)
    {
        $data = $request->validated();
        $employee = Employee::where('email', $data['email'])->first();

        if (!$employee || $data['password'] !== $employee->password) {
            return response([
                'message' => 'Неправильный логин и/или пароль',
            ], 401);
        }

        $token = $employee->createToken('app')->plainTextToken;

        $response = [
            'employee' => $employee,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        /** @var \App\Models\Employee $user **/
        $user = auth()->user();
        $user->tokens()->delete();

        return [
            'message' => 'Выполнен выход из системы'
        ];
    }
}
