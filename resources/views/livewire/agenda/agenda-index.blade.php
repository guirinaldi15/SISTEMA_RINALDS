<div class="container py-4">

    {{-- Cabeçalho --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Agenda
            </h2>

            <p class="text-muted mb-0">
                Visualize as datas disponíveis e reservadas da Chácara Rinald's.
            </p>
        </div>

        <a
            href="{{ route('reservas.create') }}"
            class="btn btn-success"
        >
            + Nova Reserva
        </a>

    </div>


    {{-- Navegação do calendário --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <button
                    wire:click="mesAnterior"
                    class="btn btn-outline-secondary"
                >
                    ← Mês anterior
                </button>

                <div class="text-center">

                    <h3 class="fw-bold mb-0 text-capitalize">
                        {{ $inicioMes->translatedFormat('F Y') }}
                    </h3>

                </div>

                <div class="d-flex gap-2">

                    <button
                        wire:click="hoje"
                        class="btn btn-outline-success"
                    >
                        Hoje
                    </button>

                    <button
                        wire:click="proximoMes"
                        class="btn btn-outline-secondary"
                    >
                        Próximo mês →
                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- Legenda --}}
    <div class="mb-3 d-flex gap-3 flex-wrap">

        <span class="badge bg-success">
            Disponível
        </span>

        <span class="badge bg-warning text-dark">
            Pré-reserva
        </span>

        <span class="badge bg-danger">
            Confirmada
        </span>

        <span class="badge bg-secondary">
            Realizada
        </span>

    </div>


    {{-- Calendário --}}
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

                            $diaAtual = 1;

                            $totalCelulas =
                                $primeiroDiaSemana - 1
                                + $diasNoMes;

                            $totalSemanas =
                                ceil($totalCelulas / 7);

                        @endphp


                        @for($semana = 0; $semana < $totalSemanas; $semana++)

                            <tr>

                                @for($diaSemana = 1; $diaSemana <= 7; $diaSemana++)

                                    @php

                                        $numeroCelula =
                                            ($semana * 7)
                                            + $diaSemana;

                                    @endphp


                                    {{-- Espaços antes do primeiro dia --}}
                                    @if(
                                        $numeroCelula
                                        < $primeiroDiaSemana
                                    )

                                        <td
                                            style="height: 130px;"
                                            class="bg-light"
                                        ></td>

                                    @elseif(
                                        $diaAtual
                                        <= $diasNoMes
                                    )

                                        @php

                                            $dataAtual =
                                                \Carbon\Carbon::create(
                                                    $ano,
                                                    $mes,
                                                    $diaAtual
                                                );

                                            $dataChave =
                                                $dataAtual
                                                    ->format('Y-m-d');

                                            $reservasDia =
                                                $reservasPorDia[
                                                    $dataChave
                                                ] ?? collect();

                                            $temConfirmada =
                                                $reservasDia
                                                ->where(
                                                    'status',
                                                    'confirmada'
                                                )
                                                ->isNotEmpty();

                                            $temPreReserva =
                                                $reservasDia
                                                ->where(
                                                    'status',
                                                    'pre_reserva'
                                                )
                                                ->isNotEmpty();

                                            $temRealizada =
                                                $reservasDia
                                                ->where(
                                                    'status',
                                                    'realizada'
                                                )
                                                ->isNotEmpty();

                                        @endphp


                                        <td
                                            style="
                                                height: 130px;
                                                min-width: 140px;
                                                vertical-align: top;
                                            "
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

                                            <div
                                                class="d-flex justify-content-between mb-2"
                                            >

                                                <span class="fw-bold">
                                                    {{ $diaAtual }}
                                                </span>

                                                @if(
                                                    $dataAtual->isToday()
                                                )

                                                    <span
                                                        class="badge bg-dark"
                                                    >
                                                        Hoje
                                                    </span>

                                                @endif

                                            </div>


                                            @if(
                                                $reservasDia->isEmpty()
                                            )

                                                <small
                                                    class="text-success fw-semibold"
                                                >
                                                    Disponível
                                                </small>

                                            @else

                                                @foreach(
                                                    $reservasDia
                                                    as $reserva
                                                )

                                                    <div
                                                        class="border rounded p-1 mb-1 bg-white text-start"
                                                    >

                                                        <div
                                                            class="fw-semibold small"
                                                        >
                                                            {{ $reserva->tipo_evento }}
                                                        </div>

                                                        <div
                                                            class="small"
                                                        >
                                                            {{ $reserva->cliente->nome }}
                                                        </div>

                                                        <div>

                                                            @if(
                                                                $reserva->status
                                                                == 'confirmada'
                                                            )

                                                                <span
                                                                    class="badge bg-danger"
                                                                >
                                                                    Confirmada
                                                                </span>

                                                            @elseif(
                                                                $reserva->status
                                                                == 'pre_reserva'
                                                            )

                                                                <span
                                                                    class="badge bg-warning text-dark"
                                                                >
                                                                    Pré-reserva
                                                                </span>

                                                            @elseif(
                                                                $reserva->status
                                                                == 'realizada'
                                                            )

                                                                <span
                                                                    class="badge bg-secondary"
                                                                >
                                                                    Realizada
                                                                </span>

                                                            @endif

                                                        </div>

                                                    </div>

                                                @endforeach

                                            @endif

                                        </td>

                                        @php
                                            $diaAtual++;
                                        @endphp

                                    @else

                                        <td
                                            style="height: 130px;"
                                            class="bg-light"
                                        ></td>

                                    @endif

                                @endfor

                            </tr>

                        @endfor

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>