<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

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

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="row g-3 mb-4">

                <div class="col-md-8">

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar pelo nome do cliente..."
                    >

                </div>

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

                                <td class="fw-semibold">
                                    {{ $reserva->cliente->nome }}
                                </td>

                                <td>
                                    {{ $reserva->data_evento->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ $reserva->tipo_evento }}
                                </td>

                                <td>
                                    {{ $reserva->quantidade_convidados ?? '-' }}
                                </td>

                                <td>

                                    @if($reserva->valor_total)

                                        R$
                                        {{ number_format(
                                            $reserva->valor_total,
                                            2,
                                            ',',
                                            '.'
                                        ) }}

                                    @else

                                        -

                                    @endif

                                </td>

                                <td>

                                    @if($reserva->status == 'confirmada')

                                        <span class="badge bg-success">
                                            Confirmada
                                        </span>

                                    @elseif($reserva->status == 'pre_reserva')

                                        <span class="badge bg-warning text-dark">
                                            Pré-reserva
                                        </span>

                                    @elseif($reserva->status == 'cancelada')

                                        <span class="badge bg-danger">
                                            Cancelada
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Realizada
                                        </span>

                                    @endif

                                </td>

                                <td class="text-end">

                                    <a
                                        href="{{ route(
                                            'reservas.edit',
                                            $reserva->id
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Editar
                                    </a>

                                    <a
                                        href="{{ route(
                                            'reservas.delete',
                                            $reserva->id
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
                                    colspan="7"
                                    class="text-center text-muted py-4"
                                >
                                    Nenhuma reserva encontrada.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>