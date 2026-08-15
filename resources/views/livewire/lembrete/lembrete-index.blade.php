<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Lembretes
            </h2>

            <p class="text-muted mb-0">
                Controle os retornos de atendimento da Chácara Rinald's.
            </p>
        </div>

        <a
            href="{{ route('lembretes.create') }}"
            class="btn btn-success"
        >
            + Novo Lembrete
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

                <div class="col-md-6">

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar cliente..."
                    >

                </div>


                <div class="col-md-3">

                    <select
                        wire:model.live="status"
                        class="form-select"
                    >

                        <option value="">
                            Todos os status
                        </option>

                        <option value="pendente">
                            Pendente
                        </option>

                        <option value="concluido">
                            Concluído
                        </option>

                        <option value="cancelado">
                            Cancelado
                        </option>

                    </select>

                </div>


                <div class="col-md-3">

                    <select
                        wire:model.live="periodo"
                        class="form-select"
                    >

                        <option value="">
                            Todos os períodos
                        </option>

                        <option value="hoje">
                            Hoje
                        </option>

                        <option value="atrasados">
                            Atrasados
                        </option>

                        <option value="futuros">
                            Próximos
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
                            <th>Cliente</th>
                            <th>Lembrete</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Atendimento</th>
                            <th class="text-end">
                                Ações
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($lembretes as $lembrete)

                            @php

                                $atrasado =
                                    $lembrete->status === 'pendente'
                                    && $lembrete->lembrar_em->isPast();

                            @endphp

                            <tr
                                class="{{ $atrasado ? 'table-danger' : '' }}"
                            >

                                <td>

                                    <div class="fw-semibold">

                                        {{ $lembrete->atendimento->cliente->nome }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $lembrete->atendimento->cliente->telefone }}

                                    </small>

                                </td>


                                <td>

                                    <div class="fw-semibold">
                                        {{ $lembrete->titulo }}
                                    </div>

                                    @if($lembrete->descricao)

                                        <small class="text-muted">

                                            {{ \Illuminate\Support\Str::limit(
                                                $lembrete->descricao,
                                                80
                                            ) }}

                                        </small>

                                    @endif

                                </td>


                                <td>

                                    {{ $lembrete->lembrar_em->format('d/m/Y H:i') }}

                                    @if($atrasado)

                                        <div>

                                            <span class="badge bg-danger mt-1">
                                                Atrasado
                                            </span>

                                        </div>

                                    @endif

                                </td>


                                <td>

                                    @if($lembrete->status === 'pendente')

                                        <span class="badge bg-warning text-dark">
                                            Pendente
                                        </span>

                                    @elseif($lembrete->status === 'concluido')

                                        <span class="badge bg-success">
                                            Concluído
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Cancelado
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    {{ ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $lembrete->atendimento->status
                                        )
                                    ) }}

                                </td>


                                <td class="text-end">

                                    @php

                                        $telefone =
                                            preg_replace(
                                                '/\D/',
                                                '',
                                                $lembrete
                                                    ->atendimento
                                                    ->cliente
                                                    ->telefone
                                            );

                                    @endphp


                                    <a
                                        href="https://wa.me/55{{ $telefone }}"
                                        target="_blank"
                                        class="btn btn-sm btn-success"
                                    >
                                        WhatsApp
                                    </a>


                                    @if($lembrete->status === 'pendente')

                                        <button
                                            wire:click="concluir({{ $lembrete->id }})"
                                            class="btn btn-sm btn-outline-success"
                                        >
                                            Concluir
                                        </button>

                                    @elseif($lembrete->status === 'concluido')

                                        <button
                                            wire:click="reabrir({{ $lembrete->id }})"
                                            class="btn btn-sm btn-outline-warning"
                                        >
                                            Reabrir
                                        </button>

                                    @endif


                                    <a
                                        href="{{ route(
                                            'lembretes.edit',
                                            $lembrete->id
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Editar
                                    </a>


                                    <a
                                        href="{{ route(
                                            'lembretes.delete',
                                            $lembrete->id
                                        ) }}"
                                        class="btn btn-sm btn-outline-danger"
                                    >
                                        Excluir
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center text-muted py-4"
                                >
                                    Nenhum lembrete encontrado.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>