
<div class="container-fluid py-4 px-4">

    <div class="mb-4">
        <h2 class="fw-bold mb-1">
            Espaços da Chácara
        </h2>

        <p class="text-muted mb-0">
            Consulte e atualize as informações dos
            ambientes da Chácara Rinald's.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="alert alert-info border-0">
        A chácara possui dois espaços cadastrados.
        Para alterar capacidades, estrutura ou valores,
        utilize a opção <strong>Editar</strong>.
    </div>

    <div class="row g-4">

        @forelse($espacos as $espaco)

            <div class="col-lg-6">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between
                                    align-items-start gap-2 mb-3">

                            <h4 class="fw-bold mb-0">
                                {{ $espaco->nome }}
                            </h4>

                            @if($espaco->ativo)
                                <span class="badge bg-success">
                                    Ativo
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Inativo
                                </span>
                            @endif

                        </div>

                        <p class="text-muted">
                            {{ $espaco->descricao ?: 'Sem descrição.' }}
                        </p>

                        <hr>

                        <div class="row g-3 mb-3">

                            <div class="col-6">
                                <small class="text-muted">
                                    Capacidade
                                </small>
                                <div class="fw-semibold">
                                    {{ $espaco->capacidade_maxima ?? '—' }}
                                    pessoas
                                </div>
                            </div>

                            <div class="col-6">
                                <small class="text-muted">
                                    Valor base
                                </small>
                                <div class="fw-semibold">
                                    @if((float) $espaco->valor_base > 0)
                                        R$ {{ number_format(
                                            $espaco->valor_base,
                                            2,
                                            ',',
                                            '.'
                                        ) }}
                                    @else
                                        A definir
                                    @endif
                                </div>
                            </div>

                            <div class="col-6">
                                <small class="text-muted">
                                    Mesas
                                </small>
                                <div class="fw-semibold">
                                    {{ $espaco->quantidade_mesas ?? '—' }}
                                </div>
                            </div>

                            <div class="col-6">
                                <small class="text-muted">
                                    Cadeiras
                                </small>
                                <div class="fw-semibold">
                                    {{ $espaco->quantidade_cadeiras ?? '—' }}
                                </div>
                            </div>

                        </div>

                        <h6 class="fw-bold">
                            Estrutura disponível
                        </h6>

                        <div class="d-flex flex-wrap gap-2 mb-4">

                            @if($espaco->possui_piscina)
                                <span class="badge bg-light text-dark border">
                                    Piscina
                                </span>
                            @endif

                            @if($espaco->possui_churrasqueira)
                                <span class="badge bg-light text-dark border">
                                    Churrasqueira
                                </span>
                            @endif

                            @if($espaco->possui_cozinha)
                                <span class="badge bg-light text-dark border">
                                    Cozinha
                                </span>
                            @endif

                            @if($espaco->possui_ar_condicionado)
                                <span class="badge bg-light text-dark border">
                                    Ar-condicionado
                                </span>
                            @endif

                            @if($espaco->possui_bar_molhado)
                                <span class="badge bg-light text-dark border">
                                    Bar molhado
                                </span>
                            @endif

                            @if($espaco->possui_estacionamento)
                                <span class="badge bg-light text-dark border">
                                    Estacionamento
                                </span>
                            @endif

                            @if($espaco->possui_wifi)
                                <span class="badge bg-light text-dark border">
                                    Wi-Fi
                                </span>
                            @endif

                            @if($espaco->possui_acomodacao)
                                <span class="badge bg-light text-dark border">
                                    Acomodação
                                </span>
                            @endif

                        </div>

                        <div class="d-flex gap-2">

                            <a
                                href="{{ route('espacos.show', $espaco->id) }}"
                                class="btn btn-outline-secondary"
                            >
                                Visualizar
                            </a>

                            <a
                                href="{{ route('espacos.edit', $espaco->id) }}"
                                class="btn btn-success"
                            >
                                Editar informações
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-warning">
                    Nenhum espaço cadastrado.
                    Execute php artisan db:seed.
                </div>
            </div>

        @endforelse

    </div>

</div>
