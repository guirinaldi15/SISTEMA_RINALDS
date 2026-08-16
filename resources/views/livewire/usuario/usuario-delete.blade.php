<div class="container py-4">

    <div
        class="card border-0 shadow-sm mx-auto"
        style="max-width:600px;"
    >

        <div class="card-body p-4">

            <h3 class="fw-bold text-danger mb-3">
                Excluir Usuário
            </h3>


            <p>
                Tem certeza que deseja excluir este usuário?
            </p>


            <div class="alert alert-warning">

                <strong>Nome:</strong>
                {{ $usuario->name }}

                <br>

                <strong>E-mail:</strong>
                {{ $usuario->email }}

                <br>

                <strong>Perfil:</strong>

                {{
                    $usuario->perfil
                    === 'administrador'
                    ? 'Administrador'
                    : 'Atendente'
                }}

            </div>


            <div
                class="d-flex justify-content-end gap-2"
            >

                <a
                    href="{{ route('usuarios.index') }}"
                    class="btn btn-light"
                >
                    Cancelar
                </a>


                <button
                    wire:click="excluir"
                    class="btn btn-danger"
                >
                    Excluir
                </button>

            </div>

        </div>

    </div>

</div>