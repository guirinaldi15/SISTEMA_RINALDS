<div class="container py-4">

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h3 class="fw-bold text-danger mb-3">
                Excluir Reserva
            </h3>

            <p>
                Tem certeza que deseja excluir esta reserva?
            </p>

            <div class="alert alert-warning">

                <strong>Cliente:</strong>
                {{ $reserva->cliente->nome }}

                <br>

                <strong>Evento:</strong>
                {{ $reserva->tipo_evento }}

                <br>

                <strong>Data:</strong>
                {{ $reserva->data_evento->format('d/m/Y') }}

            </div>

            <div class="d-flex gap-2">

                <a
                    href="{{ route('reservas.index') }}"
                    class="btn btn-light"
                >
                    Cancelar
                </a>

                <button
                    wire:click="excluir"
                    class="btn btn-danger"
                >
                    Excluir Reserva
                </button>

            </div>

        </div>

    </div>

</div>