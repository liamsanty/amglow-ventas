<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\View\View;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function editPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();

        // Solo se puede cambiar la contraseña de la propia cuenta
        if ($user && $user->id === Auth::id()) {
            return view('auth.edit-password', [
                'email' => $user->email,
                'error' => session('error'),
            ]);
        } else {
            return redirect()->back()
                ->withErrors(['email' => 'Solo puedes cambiar la contraseña de tu propia cuenta.'])
                ->withInput();
        }
    }



    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if ($request->password != $request->confirmPassword || strlen((string) $request->password) < 8) {
            $errors = new MessageBag([
                'message' => ['Las contraseñas no coinciden o tienen menos de 8 caracteres.']
            ]);
            return view('auth.edit-password', [
                'email' => $user->email,
                'errors' => $errors
            ]);
        }

        $password = Hash::make($request->password);

        // Se ignora el email del formulario: se actualiza solo el usuario con sesión iniciada
        DB::table('users')
            ->where('id', $user->id)
            ->update(['password' => $password]);

        return redirect()->route('panel')->with('success', 'Contraseña actualizada');
    }
}
