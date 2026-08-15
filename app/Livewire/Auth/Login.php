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


    public function entrar()
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDAR
        |--------------------------------------------------------------------------
        */

        $this->validate();


        /*
        |--------------------------------------------------------------------------
        | NORMALIZAR E-MAIL
        |--------------------------------------------------------------------------
        */

        $email = strtolower(
            trim(
                $this->email
            )
        );


        /*
        |--------------------------------------------------------------------------
        | AUTENTICAR
        |--------------------------------------------------------------------------
        */

        $autenticado = Auth::attempt(
            [
                'email' =>
                    $email,

                'password' =>
                    $this->password,
            ],
            $this->remember
        );


        /*
        |--------------------------------------------------------------------------
        | ERRO
        |--------------------------------------------------------------------------
        */

        if (!$autenticado) {

            throw ValidationException::withMessages([

                'email' =>
                    'E-mail ou senha incorretos.',

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
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->intended(
                route(
                    'dashboard.index'
                )
            );
    }


    public function render()
    {
        return view(
            'livewire.auth.login'
        );
    }
}