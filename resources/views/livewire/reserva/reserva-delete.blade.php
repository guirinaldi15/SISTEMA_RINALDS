<div class="container py-4">

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            {{-- TÍTULO --}}

            <h3 class="fw-bold text-danger mb-3">
                Excluir Reserva
            </h3>

            <p class="text-muted">
                Tem certeza que deseja excluir esta reserva?
                Verifique as informações antes de continuar.
            </p>

            {{-- INFORMAÇÕES DA RESERVA --}}

            <div class="alert alert-warning">

                <strong>Cliente:</strong>
                {{ $reserva->cliente?->nome ?? 'Não informado' }}

                <br>

                <strong>Evento:</strong>
                {{ $reserva->tipo_evento }}

                <br>

                <strong>Data:</strong>
                {{ $reserva->data_evento?->format('d/m/Y') ?? 'Não informada' }}

                <br>

                <strong>Status:</strong>

                @switch($reserva->status)
                    @case('pre_reserva')
                        Pré-reserva
                    @break

                    @case('confirmada')
                        Confirmada
                    @break

                    @case('realizada')
                        Realizada
                    @break

                    @case('cancelada')
                        Cancelada
                    @break

                    @default
                        {{ $reserva->status }}
                @endswitch

                <br>

                <strong>Valor total:</strong>
                R$
                {{ number_format((float) $reserva->valor_total, 2, ',', '.') }}

            </div>

            {{-- AVISO DE SEGURANÇA --}}

            <div class="alert alert-info">

                <strong>Atenção!</strong>

                <p class="mb-0 mt-2">
                    Reservas confirmadas ou realizadas não podem
                    ser excluídas diretamente.
                    Reservas que possuem pagamentos vinculados
                    também não podem ser excluídas, para
                    preservar o histórico financeiro.
                </p>

            </div>

            {{-- ERRO DE EXCLUSÃO --}}

            @error('exclusao')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror

            {{-- BOTÕES --}}

            <div class="d-flex gap-2 flex-wrap">

                <a href="{{ route('reservas.index') }}" class="btn btn-light border">
                    Voltar
                </a>

                <button type="button" wire:click="excluir" wire:loading.attr="disabled" wire:target="excluir"
                    class="btn btn-danger">

                    <span wire:loading.remove wire:target="excluir">
                        Excluir Reserva
                    </span>

                    <span wire:loading wire:target="excluir">
                        Excluindo...
                    </span>

                </button>

            </div>

        </div>

    </div>

</div>
