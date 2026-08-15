<div class="container py-4">

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <h3 class="fw-bold text-danger mb-3">
                Excluir Orçamento
            </h3>

            <p>
                Tem certeza que deseja excluir este orçamento?
            </p>


            <div class="alert alert-warning">

                <strong>
                    Número:
                </strong>

                {{ $orcamento->numero }}

                <br>

                <strong>
                    Cliente:
                </strong>

                {{ $orcamento
                    ->atendimento
                    ->cliente
                    ->nome }}

                <br>

                <strong>
                    Total:
                </strong>

                R$

                {{ number_format(
                    $orcamento->valor_total,
                    2,
                    ',',
                    '.'
                ) }}

            </div>


            <div class="d-flex gap-2">

                <a
                    href="{{ route('orcamentos.index') }}"
                    class="btn btn-light"
                >
                    Cancelar
                </a>

                <button
                    wire:click="excluir"
                    class="btn btn-danger"
                >
                    Excluir Orçamento
                </button>

            </div>

        </div>

    </div>

</div>