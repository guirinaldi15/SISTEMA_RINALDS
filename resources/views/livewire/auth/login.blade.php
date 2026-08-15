<div class="login-page">

    <div>

        {{-- VOLTAR PARA O SITE --}}
        <div class="text-center mb-4">

            <a
                href="{{ route('site.home') }}"
                class="back-site"
            >
                ← Voltar para o site
            </a>

        </div>


        <div class="card login-card">

            <div class="card-body p-4 p-md-5">


                {{-- LOGO --}}
                <div class="text-center mb-4">

                    <div
                        class="mb-2"
                        style="
                            font-size: 2.5rem;
                        "
                    >
                        🌿
                    </div>


                    <h2
                        class="login-logo fw-bold mb-1"
                    >
                        RINALD'S
                    </h2>


                    <div
                        class="text-uppercase small"
                        style="
                            color: #c99a3d;
                            letter-spacing: 3px;
                        "
                    >
                        Gestão
                    </div>


                    <p
                        class="login-subtitle mt-3 mb-0"
                    >
                        Sistema de gerenciamento
                        da Chácara Rinald's
                    </p>

                </div>


                {{-- ERROS GERAIS --}}
                @if($errors->any())

                    <div
                        class="alert alert-danger"
                    >

                        <div class="fw-semibold">
                            Não foi possível entrar
                        </div>

                        <small>
                            Verifique seus dados e tente novamente.
                        </small>

                    </div>

                @endif


                <form
                    wire:submit="entrar"
                >


                    {{-- E-MAIL --}}
                    <div class="mb-3">

                        <label
                            class="form-label fw-semibold"
                        >
                            E-mail
                        </label>


                        <div class="input-group">

                            <span
                                class="input-group-text bg-white"
                            >
                                <i
                                    class="bi bi-envelope"
                                ></i>
                            </span>


                            <input
                                type="email"
                                wire:model="email"
                                class="form-control
                                    @error('email')
                                        is-invalid
                                    @enderror"
                                placeholder="seuemail@email.com"
                                autocomplete="email"
                                autofocus
                            >


                            @error('email')

                                <div
                                    class="invalid-feedback"
                                >
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- SENHA --}}
                    <div class="mb-3">

                        <label
                            class="form-label fw-semibold"
                        >
                            Senha
                        </label>


                        <div class="input-group">

                            <span
                                class="input-group-text bg-white"
                            >
                                <i
                                    class="bi bi-lock"
                                ></i>
                            </span>


                            <input
                                type="password"
                                wire:model="password"
                                class="form-control
                                    @error('password')
                                        is-invalid
                                    @enderror"
                                placeholder="Digite sua senha"
                                autocomplete="current-password"
                            >


                            @error('password')

                                <div
                                    class="invalid-feedback"
                                >
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- LEMBRAR --}}
                    <div
                        class="form-check mb-4"
                    >

                        <input
                            type="checkbox"
                            wire:model="remember"
                            class="form-check-input"
                            id="remember"
                        >


                        <label
                            class="form-check-label"
                            for="remember"
                        >
                            Manter conectado
                        </label>

                    </div>


                    {{-- ENTRAR --}}
                    <button
                        type="submit"
                        class="btn btn-login w-100"
                        wire:loading.attr="disabled"
                        wire:target="entrar"
                    >

                        <span
                            wire:loading.remove
                            wire:target="entrar"
                        >
                            <i
                                class="bi bi-box-arrow-in-right me-1"
                            ></i>

                            Entrar
                        </span>


                        <span
                            wire:loading
                            wire:target="entrar"
                        >
                            Entrando...
                        </span>

                    </button>

                </form>


                <div
                    class="text-center mt-4"
                >

                    <small class="text-muted">

                        Acesso restrito à administração
                        da Chácara Rinald's.

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>