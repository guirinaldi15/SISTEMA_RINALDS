<div class="container py-4">

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h3 class="fw-bold text-danger">
                Excluir Pagamento
            </h3>

            <p>
                Tem certeza que deseja excluir este pagamento?
            </p>


            <div class="alert alert-warning">

                <strong>Cliente:</strong>

                {{ $pagamento
                    ->reserva
                    ->cliente
                    ->nome }}

                <br>

                <strong>Descrição:</strong>

                {{ $pagamento->descricao }}

                <br>

                <strong>Valor:</strong>

                R$

                {{ number_format(
                    $pagamento->valor,
                    2,
                    ',',
                    '.'
                ) }}

            </div>


            <div class="d-flex gap-2">

                <a
                    href="{{ route('pagamentos.index') }}"
                    class="btn btn-light"
                >
                    Cancelar
                </a>

                <button
                    wire:click="excluir"
                    class="btn btn-danger"
                >
                    Excluir Pagamento
                </button>

            </div>

        </div>

    </div>

</div>