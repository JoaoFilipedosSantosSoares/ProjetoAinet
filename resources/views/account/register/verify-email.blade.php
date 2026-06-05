@extends('layouts.auth-layout', [
    'title' => 'Verifique o seu E-mail',
    'description' => 'Falta pouco para ativar a sua conta!'
])

@section('auth-form')
<div class="text-center space-y-4">
    <p class="text-zinc-600 text-sm">
        Obrigado por se registar! Antes de começar, por favor confirme o seu endereço de e-mail clicando no link que acabámos de lhe enviar.
    </p>

    <p class="text-zinc-500 text-xs italic">
        Se não recebeu o e-mail, verifique a pasta de Spam ou a sua caixa de entrada no Mailtrap.
    </p>

    <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
        @csrf
        <button type="submit" class="w-full rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
            Reenviar E-mail de Verificação
        </button>
    </form>
</div>
@endsection