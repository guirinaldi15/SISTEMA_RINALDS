
<div class="container-fluid py-4 px-4">

    {{-- CABEÇALHO --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Agenda de Eventos</h2>
            <p class="text-muted mb-0">
                Consulte a ocupação do Salão Social e do Refúgio Rinald's.
            </p>
        </div>

        <a href="{{ route('reservas.create') }}"
           class="btn btn-success">
            + Nova Reserva
        </a>
    </div>

    {{-- FILTRO DE ESPAÇOS --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <label class="form-label fw-semibold">
                Visualizar espaço
            </label>

            <select wire:model.live="espaco_id"
                    class="form-select">
                <option value="">
                    Todos os espaços
                </option>

                @foreach($espacos as $espaco)
                    <option value="{{ $espaco->id }}">
                        {{ $espaco->nome }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- NAVEGAÇÃO --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <button type="button"
                        wire:click="mesAnterior"
                        class="btn btn-outline-secondary">
                    ← Anterior
                </button>

                <div class="text-center">
                    <h3 class="fw-bold mb-0 text-capitalize">
                        {{ $inicioMes->translatedFormat('F Y') }}
                    </h3>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="button"
                            wire:click="hoje"
                            class="btn btn-outline-success">
                        Hoje
                    </button>

                    <button type="button"
                            wire:click="proximoMes"
                            class="btn btn-outline-secondary">
                        Próximo →
                    </button>
                </div>

            </div>

        </div>
    </div>

    {{-- LEGENDA --}}
    <div class="d-flex flex-wrap gap-3 mb-3">
        <span class="badge bg-success">Sem reservas</span>
        <span class="badge bg-warning text-dark">Pré-reserva</span>
        <span class="badge bg-danger">Confirmada</span>
        <span class="badge bg-secondary">Realizada</span>
    </div>

    {{-- CALENDÁRIO --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered mb-0 text-center align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Segunda</th>
                            <th>Terça</th>
                            <th>Quarta</th>
                            <th>Quinta</th>
                            <th>Sexta</th>
                            <th>Sábado</th>
                            <th>Domingo</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php
                            $totalCelulas = $primeiroDiaSemana - 1 + $diasNoMes;
                            $totalSemanas = (int) ceil($totalCelulas / 7);
                        @endphp

                        @for($semana = 0; $semana < $totalSemanas; $semana++)

                            <tr>

                                @for($diaSemana = 1; $diaSemana <= 7; $diaSemana++)

                                    @php
                                        $posicao = ($semana * 7) + $diaSemana;
                                        $numeroDia = $posicao - $primeiroDiaSemana + 1;
                                        $diaValido = $numeroDia >= 1 && $numeroDia <= $diasNoMes;
                                    @endphp

                                    @if(!$diaValido)

                                        <td class="bg-light"
                                            style="height: 150px; min-width: 160px;">
                                        </td>

                                    @else

                                        @php
                                            $dataAtual = \Carbon\Carbon::create(
                                                $ano,
                                                $mes,
                                                $numeroDia
                                            );

                                            $dataChave = $dataAtual->toDateString();

                                            $reservasDia = $reservasPorDia->get(
                                                $dataChave,
                                                collect()
                                            );

                                            $temConfirmada = $reservasDia
                                                ->where('status', 'confirmada')
                                                ->isNotEmpty();

                                            $temPreReserva = $reservasDia
                                                ->where('status', 'pre_reserva')
                                                ->isNotEmpty();

                                            $temRealizada = $reservasDia
                                                ->where('status', 'realizada')
                                                ->isNotEmpty();
                                        @endphp

                                        <td
                                            style="height: 150px; min-width: 160px; vertical-align: top;"
                                            class="
                                                @if($temConfirmada)
                                                    table-danger
                                                @elseif($temPreReserva)
                                                    table-warning
                                                @elseif($temRealizada)
                                                    table-secondary
                                                @else
                                                    table-success
                                                @endif
                                            "
                                        >

                                            <div class="d-flex justify-content-between mb-2">
                                                <span class="fw-bold">
                                                    {{ $numeroDia }}
                                                </span>

                                                @if($dataAtual->isToday())
                                                    <span class="badge bg-dark">
                                                        Hoje
                                                    </span>
                                                @endif
                                            </div>

                                            @if($reservasDia->isEmpty())

                                                <small class="text-success fw-semibold">
                                                    Sem reservas
                                                </small>

                                            @else

                                                @foreach($reservasDia as $reserva)

                                                    <a
                                                        href="{{ route('reservas.show', $reserva->id) }}"
                                                        class="d-block bg-white border rounded p-2 mb-2 text-start text-decoration-none text-dark"
                                                    >

                                                        <div class="fw-bold small">
                                                            {{ $reserva->espaco?->nome ?? 'Espaço não informado' }}
                                                        </div>

                                                        <div class="small">
                                                            {{ $reserva->tipo_evento }}
                                                        </div>

                                                        <div class="small text-muted">
                                                            {{ $reserva->cliente?->nome ?? 'Cliente não informado' }}
                                                        </div>

                                                        <div class="mt-1">
                                                            @switch($reserva->status)

                                                                @case('confirmada')
                                                                    <span class="badge bg-danger">
                                                                        Confirmada
                                                                    </span>
                                                                    @break

                                                                @case('pre_reserva')
                                                                    <span class="badge bg-warning text-dark">
                                                                        Pré-reserva
                                                                    </span>
                                                                    @break

                                                                @case('realizada')
                                                                    <span class="badge bg-secondary">
                                                                        Realizada
                                                                    </span>
                                                                    @break

                                                            @endswitch
                                                        </div>

                                                    </a>

                                                @endforeach

                                            @endif

                                        </td>

                                    @endif

                                @endfor

                            </tr>

                        @endfor

                    </tbody>

                </table>

            </div>
        </div>
    </div>

    <p class="text-muted small mt-3">
        Com "Todos os espaços" selecionado, o calendário
        mostra as reservas dos dois ambientes.
        Para consultar a disponibilidade específica,
        selecione um espaço no filtro.
    </p>

</div>
