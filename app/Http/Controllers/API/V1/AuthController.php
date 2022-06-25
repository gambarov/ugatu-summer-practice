<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'patronymic' => 'required|string|max:255',
            'role_id' => 'required|integer:exists:roles,id',
            'email' => 'required|string|email|max:255|unique:employees',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $employee = Employee::create($data + []);
        $token = $employee->createToken('employee')->plainTextToken;

        return response()->json([
            'employee' => $employee,
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'sometimes|boolean',
        ]);

        $employee = Employee::where('email', $data['email'])->first();

        if (!$employee || $data['password'] !== $employee->password) {
            return response([
                'message' => 'Неправильный логин и/или пароль',
            ], 401);
        }

        $remember_me = $data['remember_me'] ?? false;
        auth()->login($employee, $remember_me);

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
