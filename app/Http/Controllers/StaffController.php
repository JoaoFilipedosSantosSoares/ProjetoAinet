<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function Index(Request $request): View
    {
        $filterByType = $request->query('type');
        $filterBySearch = $request->query('search');

        $usersQuery = User::where('user_type', '!=', 'C');

        if ($filterByType !== null) {
            $usersQuery->where('user_type', $filterByType);
        }

        if ($filterBySearch !== null) {
            $usersQuery->where(function ($q) use ($filterBySearch) {
                $q->where('name', 'like', "%$filterBySearch%")
                    ->orWhere('email', 'like', "%$filterBySearch%");
            });
        }

        $users = $usersQuery
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('staff.index', compact('users', 'filterByType', 'filterBySearch'));
    }

    public function create()
    {
        return view('staff.new');
    }

    public function show(User $user)
    {
        if ($user->user_type === 'C') {
            return redirect()->route('staff.index')
                ->with('error', 'Não é possível ver o perfil privado de um cliente.');
        }

        return view('staff.show', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'user_type' => 'required|in:A,F',
            'gender' => 'required|in:M,F',
        ], [
            'email.unique' => 'Este e-mail já está registado na plataforma.',
            'password.min' => 'A password provisória deve ter pelo menos 8 caracteres.',
            'user_type.in' => 'O cargo selecionado é inválido.',
            'gender.in' => 'O género selecionado é inválido.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
            'gender' => $validated['gender'],
            'email_verified_at' => now(),
            'blocked' => 0,
        ]);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Membro de staff adicionado com sucesso!');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_type' => 'required|in:A,F',
            'gender' => 'required|in:M,F',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'name.required' => 'O nome completo é obrigatório.',
            'user_type.in' => 'O cargo selecionado é inválido.',
            'gender.in' => 'O género selecionado é inválido.',
            'photo.image' => 'O ficheiro tem de ser uma imagem válida.',
            'photo.mimes' => 'A imagem deve ser do tipo: PNG, JPG ou WEBP.',
            'photo.max' => 'A imagem não pode ter mais do que 2MB.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'user_type' => $validated['user_type'],
            'gender' => $validated['gender'],
        ];

        if ($request->hasFile('photo')) {

            $extension = $request->file('photo')->getClientOriginalExtension();

            $newFileName = 'profilePicUser' . $user->id . '.' . $extension;

            if ($user->photo_url && Storage::disk('public')->exists('photos/' . $user->photo_url)) {
                Storage::disk('public')->delete('photos/' . $user->photo_url);
            }

            $request->file('photo')->storeAs('photos', $newFileName, 'public');

            $updateData['photo_url'] = $newFileName;
        }

        $user->update($updateData);

        return redirect()
            ->route('staff.index')
            ->with('success', 'Membro de staff atualizado com sucesso!');
    }



    public function destroy(User $user): RedirectResponse
    {
        try {
            DB::transaction(function () use ($user) {
                $user->delete();
            });

            $alertType = 'success';
            $alertMsg = "O utilizador <b>{$user->name}</b> foi eliminado com sucesso!";

            return redirect()->route('staff.index')
                ->with('alert-type', $alertType)
                ->with('alert-msg', $alertMsg);
        } catch (\Exception $error) {
            return redirect()->back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Não foi possível eliminar o utilizador porque existem registos associados.");
        }
    }
}
