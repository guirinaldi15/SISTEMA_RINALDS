<div class="container py-4">

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h3 class="fw-bold text-danger">
                Excluir Cliente
            </h3>

            <p class="mt-3">
                Tem certeza que deseja excluir este cliente?
            </p>

            <div class="alert alert-warning">

                <strong>Nome:</strong>
                {{ $cliente->nome }}

                <br>

                <strong>Telefone:</strong>
                {{ $cliente->telefone }}

            </div>

            <div class="d-flex gap-2">

                <a
                    href="{{ route('clientes.index') }}"
                    class="btn btn-light"
                >
                    Cancelar
                </a>

                <button
                    wire:click="excluir"
                    class="btn btn-danger"
                >
                    Excluir
                </button>

            </div>

        </div>

    </div>

</div>