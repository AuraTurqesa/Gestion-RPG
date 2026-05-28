<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    // Muestra el formulario (WEB)
    public function showRegister() { return view('auth.register'); }
    public function showLogin() { return view('auth.login'); }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'player',
        ]);

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('api-token')->plainTextToken
            ], 201);
        }

        Auth::login($user);
        return redirect()->route('character.index');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (!$this->shouldReturnJson($request)) {
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $request->filled('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended(route('character.index'));
            }
            return back()->withErrors(['email' => 'Credenciales inválidas.'])->withInput();
        }

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas.'], 401);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('api-token')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        if ($this->shouldReturnJson($request)) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(null, 204);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function me(Request $request)
    {
        $user = $request->user()->load(['characters.inventoryMovements.item']);

        $characters = $user->characters->map(function ($character) {
            $movements = $character->inventoryMovements
                ->whereIn('type', ['EQUIP', 'UNEQUIP'])
                ->sortByDesc(fn ($movement) => $movement->executed_at ?? $movement->created_at);

            $currentlyEquipped = $movements->unique('item_id')
                ->filter(fn ($movement) => $movement->type === 'EQUIP');

            $characterData = $character->toArray();
            $characterData['equipped'] = [
                'head' => optional($currentlyEquipped->first(fn ($movement) => $movement->item?->slot === 'head'))->item,
                'body' => optional($currentlyEquipped->first(fn ($movement) => $movement->item?->slot === 'body'))->item,
                'weapon' => optional($currentlyEquipped->first(fn ($movement) => $movement->item?->slot === 'weapon'))->item,
            ];

            return $characterData;
        });

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'characters' => $characters,
        ]);
    }
}