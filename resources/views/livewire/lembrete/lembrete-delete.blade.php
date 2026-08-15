<div class="container py-4">

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h3 class="fw-bold text-danger mb-3">
                Excluir Lembrete
            </h3>

            <p>
                Tem certeza que deseja excluir este lembrete?
            </p>


            <div class="alert alert-warning">

                <strong>Cliente:</strong>

                {{ $lembrete->atendimento->cliente->nome }}

                <br>

                <strong>Lembrete:</strong>

                {{ $lembrete->titulo }}

                <br>

                <strong>Data:</strong>

                {{ $lembrete->lembrar_em->format('d/m/Y H:i') }}

            </div>


            <div class="d-flex gap-2">

                <a
                    href="{{ route('lembretes.index') }}"
                    class="btn btn-light"
                >
                    Cancelar
                </a>

                <button
                    wire:click="excluir"
                    class="btn btn-danger"
                >
                    Excluir Lembrete
                </button>

            </div>

        </div>

    </div>

</div>