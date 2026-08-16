<div class="container-fluid py-4 px-4">

    <div
        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
    >

        <div>

            <h2 class="fw-bold mb-1">
                Usuários
            </h2>

            <p class="text-muted mb-0">
                Gerencie os acessos ao sistema.
            </p>

        </div>


        <a
            href="{{ route('usuarios.create') }}"
            class="btn btn-success"
        >
            + Novo Usuário
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-8">

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar nome ou e-mail..."
                    >

                </div>


                <div class="col-md-4">

                    <select
                        wire:model.live="perfil"
                        class="form-select"
                    >

                        <option value="">
                            Todos os perfis
                        </option>

                        <option value="administrador">
                            Administrador
                        </option>

                        <option value="atendente">
                            Atendente
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>

                            <th>Usuário</th>

                            <th>Perfil</th>

                            <th>Status</th>

                            <th>Criado em</th>

                            <th class="text-end">
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($usuarios as $usuario)

                            <tr>

                                <td>

                                    <div class="fw-semibold">
                                        {{ $usuario->name }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $usuario->email }}
                                    </small>

                                </td>


                                <td>

                                    @if(
                                        $usuario->perfil
                                        === 'administrador'
                                    )

                                        <span class="badge bg-dark">
                                            Administrador
                                        </span>

                                    @else

                                        <span class="badge bg-primary">
                                            Atendente
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    @if($usuario->ativo)

                                        <span class="badge bg-success">
                                            Ativo
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Desativado
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    {{ $usuario
                                        ->created_at
                                        ->format('d/m/Y') }}

                                </td>


                                <td class="text-end">

                                    <div
                                        class="d-flex justify-content-end gap-1"
                                    >

                                        <a
                                            href="{{ route(
                                                'usuarios.edit',
                                                $usuario->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Editar
                                        </a>


                                        @if(
                                            auth()->id()
                                            !== $usuario->id
                                        )

                                            <a
                                                href="{{ route(
                                                    'usuarios.delete',
                                                    $usuario->id
                                                ) }}"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                Excluir
                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center py-5 text-muted"
                                >

                                    Nenhum usuário encontrado.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>