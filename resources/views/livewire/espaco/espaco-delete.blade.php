<div class="container py-4">

    <div
        class="card border-0 shadow-sm mx-auto"
        style="max-width:650px;"
    >

        <div class="card-body p-4">

            <h3 class="fw-bold text-danger mb-3">
                Excluir Espaço
            </h3>

            <p>
                Tem certeza que deseja excluir este espaço?
            </p>


            <div class="alert alert-warning">

                <strong>
                    Espaço:
                </strong>

                {{ $espaco->nome }}

                <br>


                <strong>
                    Capacidade:
                </strong>

                {{ $espaco->capacidade_maxima ?? 'Não informada' }}

                <br>


                <strong>
                    Valor base:
                </strong>

                @if($espaco->valor_base)

                    R$
                    {{
                        number_format(
                            $espaco->valor_base,
                            2,
                            ',',
                            '.'
                        )
                    }}

                @else

                    Não informado

                @endif

            </div>


            <div
                class="d-flex justify-content-end gap-2"
            >

                <a
                    href="{{ route('espacos.index') }}"
                    class="btn btn-light"
                >
                    Cancelar
                </a>


                <button
                    wire:click="excluir"
                    wire:confirm="Tem certeza que deseja excluir este espaço?"
                    class="btn btn-danger"
                >
                    Excluir Espaço
                </button>

            </div>

        </div>

    </div>

</div>