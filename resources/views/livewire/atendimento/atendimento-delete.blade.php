<div class="container py-4">

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h3 class="fw-bold text-danger mb-3">
                Excluir Atendimento
            </h3>

            <p>
                Tem certeza que deseja excluir este atendimento?
            </p>


            <div class="alert alert-warning">

                <strong>Cliente:</strong>
                {{ $atendimento->cliente->nome }}

                <br>

                <strong>Telefone:</strong>
                {{ $atendimento->cliente->telefone }}

                <br>

                <strong>Status:</strong>
                {{ $atendimento->status }}

            </div>


            <div class="d-flex gap-2">

                <a
                    href="{{ route('atendimentos.index') }}"
                    class="btn btn-light"
                >
                    Cancelar
                </a>

                <button
                    wire:click="excluir"
                    class="btn btn-danger"
                >
                    Excluir Atendimento
                </button>

            </div>

        </div>

    </div>

</div>