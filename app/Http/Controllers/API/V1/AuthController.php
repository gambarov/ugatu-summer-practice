<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterAuthRequest $request)
    {
        $data = $request->validated();

        $employee = Employee::create($data + []);

        $token = $employee->createToken('employee')->plainTextToken;

        return response()->json([
            'employee' => $employee,
            'token' => $token,
        ]);
    }

    public function login(LoginAuthRequest $request)
    {
        $data = $request->validated();
        $employee = Employee::where('email', $data['email'])->first();

        if (!$employee || $data['password'] !== $employee->password) {
            return response([
                'message' => 'Неправильный логин и/или пароль',
            ], 401);
        }

        $token = $employee->createToken('employee')->plainTextToken;

        $response = [
            'employee' => $employee,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
