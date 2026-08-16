<div class="container py-4">

    <div class="mb-4">

        <a
            href="{{ route('usuarios.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>


        <h2 class="fw-bold mt-3">
            Novo Usuário
        </h2>

        <p class="text-muted">
            Crie um novo acesso ao sistema.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="salvar">

                <div class="row g-3">


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nome *
                        </label>

                        <input
                            type="text"
                            wire:model="name"
                            class="form-control @error('name') is-invalid @enderror"
                        >

                        @error('name')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            E-mail *
                        </label>

                        <input
                            type="email"
                            wire:model="email"
                            class="form-control @error('email') is-invalid @enderror"
                        >

                        @error('email')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Perfil *
                        </label>

                        <select
                            wire:model="perfil"
                            class="form-select"
                        >

                            <option value="atendente">
                                Atendente
                            </option>

                            <option value="administrador">
                                Administrador
                            </option>

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select
                            wire:model="ativo"
                            class="form-select"
                        >

                            <option value="1">
                                Ativo
                            </option>

                            <option value="0">
                                Desativado
                            </option>

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Senha *
                        </label>

                        <input
                            type="password"
                            wire:model="password"
                            class="form-control @error('password') is-invalid @enderror"
                        >

                        @error('password')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Confirmar Senha *
                        </label>

                        <input
                            type="password"
                            wire:model="password_confirmation"
                            class="form-control"
                        >

                    </div>

                </div>


                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a
                        href="{{ route('usuarios.index') }}"
                        class="btn btn-light"
                    >
                        Cancelar
                    </a>


                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Salvar Usuário
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>