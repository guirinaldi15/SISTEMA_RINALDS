<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">Clientes</h2>
            <p class="text-muted mb-0">
                Gerencie os clientes da Chácara Rinald's
            </p>
        </div>

        <a href="{{ route('clientes.create') }}" class="btn btn-success">
            + Novo Cliente
        </a>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="mb-3">
                <input
                    type="text"
                    wire:model.live="search"
                    class="form-control"
                    placeholder="Pesquisar por nome ou telefone..."
                >
            </div>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Cidade</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($clientes as $cliente)

                            <tr>

                                <td class="fw-semibold">
                                    {{ $cliente->nome }}
                                </td>

                                <td>
                                    {{ $cliente->telefone }}
                                </td>

                                <td>
                                    {{ $cliente->email ?? '-' }}
                                </td>

                                <td>
                                    {{ $cliente->cidade ?? '-' }}
                                    {{ $cliente->estado ? '/' . $cliente->estado : '' }}
                                </td>

                                <td class="text-end">

                                    <a
                                        href="{{ route('clientes.edit', $cliente->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Editar
                                    </a>

                                    <a
                                        href="{{ route('clientes.delete', $cliente->id) }}"
                                        class="btn btn-sm btn-outline-danger"
                                    >
                                        Excluir
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Nenhum cliente encontrado.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>