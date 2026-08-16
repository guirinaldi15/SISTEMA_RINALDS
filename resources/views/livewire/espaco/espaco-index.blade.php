<div class="container-fluid py-4 px-4">

    <div
        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
    >

        <div>

            <h2 class="fw-bold mb-1">
                Espaços
            </h2>

            <p class="text-muted mb-0">
                Gerencie os ambientes disponíveis para eventos.
            </p>

        </div>


        <a
            href="{{ route('espacos.create') }}"
            class="btn btn-success"
        >
            + Novo Espaço
        </a>

    </div>


    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
        >

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

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
                        placeholder="Buscar espaço..."
                    >

                </div>


                <div class="col-md-4">

                    <select
                        wire:model.live="status"
                        class="form-select"
                    >

                        <option value="">
                            Todos
                        </option>

                        <option value="1">
                            Ativos
                        </option>

                        <option value="0">
                            Inativos
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>
                                Espaço
                            </th>

                            <th>
                                Capacidade
                            </th>

                            <th>
                                Mesas
                            </th>

                            <th>
                                Cadeiras
                            </th>

                            <th>
                                Valor base
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Ações
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($espacos as $espaco)

                            <tr>

                                <td>

                                    <div class="fw-semibold">
                                        {{ $espaco->nome }}
                                    </div>

                                    <small class="text-muted">

                                        {{
                                            \Illuminate\Support\Str::limit(
                                                $espaco->descricao,
                                                60
                                            )
                                        }}

                                    </small>

                                </td>


                                <td>

                                    @if($espaco->capacidade_maxima)

                                        {{ $espaco->capacidade_maxima }}
                                        pessoas

                                    @else

                                        —

                                    @endif

                                </td>


                                <td>
                                    {{ $espaco->quantidade_mesas }}
                                </td>


                                <td>

                                    {{ $espaco->quantidade_cadeiras }}

                                    @if($espaco->tipo_cadeira)

                                        <br>

                                        <small class="text-muted">
                                            {{ $espaco->tipo_cadeira }}
                                        </small>

                                    @endif

                                </td>


                                <td>

                                    @if($espaco->valor_base)

                                        R$
                                        {{
                                            number_format(
                                                $espaco->valor_base,
                                                2,
                                                ',',
                                                '.'
                                            )
                                        }}

                                    @else

                                        A consultar

                                    @endif

                                </td>


                                <td>

                                    @if($espaco->ativo)

                                        <span class="badge bg-success">
                                            Ativo
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Inativo
                                        </span>

                                    @endif

                                </td>


                                <td class="text-end">

                                    <div
                                        class="d-flex justify-content-end gap-1"
                                    >

                                        <a
                                            href="{{ route(
                                                'espacos.show',
                                                $espaco->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-secondary"
                                        >
                                            Ver
                                        </a>


                                        <a
                                            href="{{ route(
                                                'espacos.edit',
                                                $espaco->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Editar
                                        </a>


                                        <a
                                            href="{{ route(
                                                'espacos.delete',
                                                $espaco->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-danger"
                                        >
                                            Excluir
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center py-5"
                                >

                                    <div class="fs-1 mb-2">
                                        🏡
                                    </div>

                                    <div class="fw-semibold">
                                        Nenhum espaço cadastrado.
                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>