<div class="container-fluid py-4 px-4">

    <div
        class="d-flex justify-content-between align-items-center mb-4"
    >

        <div>

            <a
                href="{{ route('espacos.index') }}"
                class="text-decoration-none"
            >
                ← Voltar
            </a>

            <h2 class="fw-bold mt-3 mb-1">
                {{ $espaco->nome }}
            </h2>

            <span
                class="badge {{ $espaco->ativo ? 'bg-success' : 'bg-secondary' }}"
            >

                {{ $espaco->ativo ? 'Ativo' : 'Inativo' }}

            </span>

        </div>


        <a
            href="{{ route(
                'espacos.edit',
                $espaco->id
            ) }}"
            class="btn btn-primary"
        >
            Editar
        </a>

    </div>


    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h5 class="fw-bold">
                        Sobre o espaço
                    </h5>

                    <p class="text-muted">
                        {{ $espaco->descricao ?: 'Sem descrição.' }}
                    </p>


                    <hr>


                    <div class="row g-3">

                        <div class="col-md-4">

                            <small class="text-muted">
                                Capacidade
                            </small>

                            <div class="fw-bold">

                                {{
                                    $espaco->capacidade_maxima
                                    ?: '—'
                                }}

                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Mesas
                            </small>

                            <div class="fw-bold">
                                {{ $espaco->quantidade_mesas }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Cadeiras
                            </small>

                            <div class="fw-bold">
                                {{ $espaco->quantidade_cadeiras }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h5 class="fw-bold">
                        Valor base
                    </h5>

                    <div class="fs-3 fw-bold text-success">

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

                            A consultar

                        @endif

                    </div>

                </div>

            </div>

        </div>


        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Estrutura
                    </h5>


                    <div class="row g-3">

                        @php

                            $recursos = [

                                'possui_cozinha'
                                    => '🍳 Cozinha',

                                'possui_piscina'
                                    => '🏊 Piscina',

                                'possui_churrasqueira'
                                    => '🔥 Churrasqueira',

                                'possui_bar_molhado'
                                    => '🍹 Bar molhado',

                                'possui_ar_condicionado'
                                    => '❄️ Ar-condicionado',

                                'possui_estacionamento'
                                    => '🚗 Estacionamento',

                                'possui_wifi'
                                    => '📶 Wi-Fi',

                                'possui_acomodacao'
                                    => '🛏️ Acomodação',

                            ];

                        @endphp


                        @foreach(
                            $recursos
                            as $campo => $nome
                        )

                            <div class="col-md-3">

                                <div
                                    class="border rounded p-3"
                                >

                                    {{ $nome }}

                                    <div>

                                        @if($espaco->{$campo})

                                            <span class="text-success">
                                                Disponível
                                            </span>

                                        @else

                                            <span class="text-muted">
                                                Não disponível
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>