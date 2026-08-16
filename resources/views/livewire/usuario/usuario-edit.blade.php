<div class="container py-4">

    <div class="mb-4">

        <a
            href="{{ route('usuarios.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>


        <h2 class="fw-bold mt-3">
            Editar Usuário
        </h2>

        <p class="text-muted">
            Atualize os dados e permissões.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="atualizar">

                <div class="row g-3">


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nome *
                        </label>

                        <input
                            type="text"
                            wire:model="name"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            E-mail *
                        </label>

                        <input
                            type="email"
                            wire:model="email"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Perfil *
                        </label>

                        <select
                            wire:model="perfil"
                            class="form-select"
                        >

                            <option value="administrador">
                                Administrador
                            </option>

                            <option value="atendente">
                                Atendente
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


                    <div class="col-12">

                        <hr>

                        <h5 class="fw-bold">
                            Alterar senha
                        </h5>

                        <small class="text-muted">
                            Deixe em branco para manter a senha atual.
                        </small>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nova senha
                        </label>

                        <input
                            type="password"
                            wire:model="password"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Confirmar nova senha
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
                        Salvar Alterações
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>