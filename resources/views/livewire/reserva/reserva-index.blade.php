<div class="container-fluid py-4 px-4">

    {{-- ====================================================== --}}
    {{-- CABEÇALHO --}}
    {{-- ====================================================== --}}

    <div
        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
    >

        <div>

            <h2 class="fw-bold mb-1">
                Reservas
            </h2>

            <p class="text-muted mb-0">
                Gerencie as reservas da Chácara Rinald's.
            </p>

        </div>

        <a
            href="{{ route('reservas.create') }}"
            class="btn btn-success"
        >
            + Nova Reserva
        </a>

    </div>


    {{-- ====================================================== --}}
    {{-- MENSAGEM DE SUCESSO --}}
    {{-- ====================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- FILTROS --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                {{-- Pesquisa --}}
                <div class="col-md-8">

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar pelo nome do cliente..."
                    >

                </div>


                {{-- Status --}}
                <div class="col-md-4">

                    <select
                        wire:model.live="status"
                        class="form-select"
                    >

                        <option value="">
                            Todos os status
                        </option>

                        <option value="pre_reserva">
                            Pré-reserva
                        </option>

                        <option value="confirmada">
                            Confirmada
                        </option>

                        <option value="cancelada">
                            Cancelada
                        </option>

                        <option value="realizada">
                            Realizada
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- TABELA --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Evento</th>
                            <th>Convidados</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th class="text-end">
                                Ações
                            </th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($reservas as $reserva)

                            <tr>

                                {{-- CLIENTE --}}
                                <td>

                                    <div class="fw-semibold">
                                        {{ $reserva->cliente->nome }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $reserva->cliente->telefone }}
                                    </small>

                                </td>


                                {{-- DATA --}}
                                <td>

                                    <div class="fw-semibold">

                                        {{ $reserva
                                            ->data_evento
                                            ->format('d/m/Y') }}

                                    </div>

                                    @if(
                                        $reserva->horario_inicio
                                        || $reserva->horario_fim
                                    )

                                        <small class="text-muted">

                                            @if($reserva->horario_inicio)

                                                {{ substr(
                                                    $reserva->horario_inicio,
                                                    0,
                                                    5
                                                ) }}

                                            @endif

                                            @if(
                                                $reserva->horario_inicio
                                                && $reserva->horario_fim
                                            )

                                                às

                                            @endif

                                            @if($reserva->horario_fim)

                                                {{ substr(
                                                    $reserva->horario_fim,
                                                    0,
                                                    5
                                                ) }}

                                            @endif

                                        </small>

                                    @endif

                                </td>


                                {{-- EVENTO --}}
                                <td>

                                    {{ $reserva->tipo_evento }}

                                </td>


                                {{-- CONVIDADOS --}}
                                <td>

                                    {{ $reserva
                                        ->quantidade_convidados
                                        ?? '-' }}

                                </td>


                                {{-- VALOR --}}
                                <td>

                                    @if($reserva->valor_total)

                                        <div class="fw-semibold">

                                            R$

                                            {{ number_format(
                                                $reserva->valor_total,
                                                2,
                                                ',',
                                                '.'
                                            ) }}

                                        </div>

                                    @else

                                        <span class="text-muted">
                                            Não informado
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @switch($reserva->status)

                                        @case('pre_reserva')

                                            <span
                                                class="badge bg-warning text-dark"
                                            >
                                                Pré-reserva
                                            </span>

                                        @break


                                        @case('confirmada')

                                            <span
                                                class="badge bg-success"
                                            >
                                                Confirmada
                                            </span>

                                        @break


                                        @case('cancelada')

                                            <span
                                                class="badge bg-danger"
                                            >
                                                Cancelada
                                            </span>

                                        @break


                                        @case('realizada')

                                            <span
                                                class="badge bg-secondary"
                                            >
                                                Realizada
                                            </span>

                                        @break

                                    @endswitch

                                </td>


                                {{-- ====================================================== --}}
                                {{-- AÇÕES --}}
                                {{-- ====================================================== --}}

                                <td class="text-end">

                                    <div
                                        class="d-flex justify-content-end gap-1 flex-wrap"
                                    >

                                        {{-- PAGAMENTO --}}
                                        @if(
                                            $reserva->status
                                            !== 'cancelada'
                                        )

                                            <a
                                                href="{{ route(
                                                    'pagamentos.create',
                                                    [
                                                        'reserva'
                                                        =>
                                                        $reserva->id
                                                    ]
                                                ) }}"
                                                class="btn btn-sm btn-outline-success"
                                            >
                                                💳 Pagamento
                                            </a>

                                        @endif


                                        {{-- EDITAR --}}
                                        <a
                                            href="{{ route(
                                                'reservas.edit',
                                                $reserva->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Editar
                                        </a>


                                        {{-- EXCLUIR --}}
                                        <a
                                            href="{{ route(
                                                'reservas.delete',
                                                $reserva->id
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

                                    <div class="fs-1 mb-3">
                                        🎉
                                    </div>

                                    <div class="fw-semibold">
                                        Nenhuma reserva encontrada
                                    </div>

                                    <p class="text-muted mb-3">
                                        Cadastre uma reserva para começar.
                                    </p>

                                    <a
                                        href="{{ route('reservas.create') }}"
                                        class="btn btn-success"
                                    >
                                        + Nova Reserva
                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>