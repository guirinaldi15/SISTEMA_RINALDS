<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.guest')]
#[Title("Login | Rinald's Gestão")]
class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    /*
    |--------------------------------------------------------------------------
    | REGRAS DE VALIDAÇÃO
    |--------------------------------------------------------------------------
    */

    protected function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | MENSAGENS DE VALIDAÇÃO
    |--------------------------------------------------------------------------
    */

    protected function messages(): array
    {
        return [
            'email.required' =>
                'Informe seu e-mail.',

            'email.email' =>
                'Informe um e-mail válido.',

            'password.required' =>
                'Informe sua senha.',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | REALIZAR LOGIN
    |--------------------------------------------------------------------------
    */

    public function entrar()
    {
        $this->validate();

        /*
        |--------------------------------------------------------------------------
        | NORMALIZAR E-MAIL
        |--------------------------------------------------------------------------
        */

        $email = strtolower(
            trim($this->email)
        );

        /*
        |--------------------------------------------------------------------------
        | AUTENTICAR SOMENTE USUÁRIOS ATIVOS
        |--------------------------------------------------------------------------
        */

        $autenticado = Auth::attempt(
            [
                'email' => $email,
                'password' => $this->password,
                'ativo' => true,
            ],
            $this->remember
        );

        /*
        |--------------------------------------------------------------------------
        | TRATAR FALHA DE AUTENTICAÇÃO
        |--------------------------------------------------------------------------
        */

        if (!$autenticado) {
            throw ValidationException::withMessages([
                'email' =>
                    'E-mail ou senha incorretos, ou usuário desativado.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | REGENERAR SESSÃO
        |--------------------------------------------------------------------------
        */

        session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | REDIRECIONAR PARA O DASHBOARD
        |--------------------------------------------------------------------------
        */

        return redirect()->intended(
            route('dashboard.index')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RENDERIZAR TELA DE LOGIN
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view('livewire.auth.login');
    }
}
