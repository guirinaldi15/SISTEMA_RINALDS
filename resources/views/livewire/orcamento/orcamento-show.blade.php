<div class="container-fluid py-4 px-4">

    {{-- ====================================================== --}}
    {{-- BOTÕES SUPERIORES --}}
    {{-- ====================================================== --}}

    <div
        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 no-print"
    >

        <div>

            <a
                href="{{ route('orcamentos.index') }}"
                class="text-decoration-none"
            >
                ← Voltar para Orçamentos
            </a>

        </div>


        <div class="d-flex gap-2 flex-wrap">

            {{-- Editar --}}
            <a
                href="{{ route(
                    'orcamentos.edit',
                    $orcamento->id
                ) }}"
                class="btn btn-outline-primary"
            >
                ✏️ Editar
            </a>


            {{-- WhatsApp --}}
            @php

                $telefone = preg_replace(
                    '/\D/',
                    '',
                    $orcamento
                        ->atendimento
                        ->cliente
                        ->telefone
                );


                $cliente =
                    $orcamento
                        ->atendimento
                        ->cliente
                        ->nome;


                $evento =
                    $orcamento
                        ->atendimento
                        ->tipo_evento
                        ?? 'evento';


                $dataEvento =
                    $orcamento
                        ->atendimento
                        ->data_evento
                        ?->format('d/m/Y');


                $validade =
                    $orcamento
                        ->validade
                        ?->format('d/m/Y');


                $valor =
                    number_format(
                        $orcamento->valor_total,
                        2,
                        ',',
                        '.'
                    );


                $mensagem =
                    "Olá {$cliente}! Tudo bem?\n\n"
                    . "Preparamos o orçamento da Chácara Rinald's para seu {$evento}.\n\n"
                    . "📄 Orçamento: {$orcamento->numero}\n"
                    . ($dataEvento
                        ? "📅 Data do evento: {$dataEvento}\n"
                        : '')
                    . "💰 Valor total: R$ {$valor}\n"
                    . ($validade
                        ? "⏳ Validade da proposta: {$validade}\n"
                        : '')
                    . "\nQualquer dúvida, estamos à disposição!";


                $mensagemWhatsapp =
                    urlencode($mensagem);

            @endphp


            <a
                href="https://wa.me/55{{ $telefone }}?text={{ $mensagemWhatsapp }}"
                target="_blank"
                class="btn btn-success"
            >
                WhatsApp
            </a>


            {{-- Imprimir --}}
            <button
                type="button"
                onclick="window.print()"
                class="btn btn-dark"
            >
                🖨️ Imprimir / PDF
            </button>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- ORÇAMENTO --}}
    {{-- ====================================================== --}}

    <div
        class="card border-0 shadow-sm mx-auto orcamento-documento"
        style="max-width: 950px;"
    >

        <div class="card-body p-5">


            {{-- ====================================================== --}}
            {{-- CABEÇALHO DO DOCUMENTO --}}
            {{-- ====================================================== --}}

            <div
                class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4"
            >

                <div>

                    <h1
                        class="fw-bold mb-0"
                        style="color: #163b2b;"
                    >
                        RINALD'S
                    </h1>

                    <div class="text-muted">
                        Chácara • Festas & Eventos
                    </div>

                    <div class="small text-muted mt-2">
                        Presidente Epitácio - SP
                    </div>

                </div>


                <div class="text-end">

                    <div
                        class="text-uppercase text-muted fw-semibold"
                    >
                        Proposta Comercial
                    </div>

                    <h4 class="fw-bold mt-1">
                        {{ $orcamento->numero }}
                    </h4>


                    {{-- Status --}}
                    <div class="mt-2">

                        @switch($orcamento->status)

                            @case('rascunho')

                                <span class="badge bg-secondary">
                                    Rascunho
                                </span>

                            @break


                            @case('enviado')

                                <span class="badge bg-primary">
                                    Enviado
                                </span>

                            @break


                            @case('aceito')

                                <span class="badge bg-success">
                                    Aceito
                                </span>

                            @break


                            @case('recusado')

                                <span class="badge bg-danger">
                                    Recusado
                                </span>

                            @break


                            @case('expirado')

                                <span class="badge bg-warning text-dark">
                                    Expirado
                                </span>

                            @break

                        @endswitch

                    </div>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- CLIENTE --}}
            {{-- ====================================================== --}}

            <div class="mb-5">

                <h5
                    class="fw-bold mb-3"
                    style="color: #163b2b;"
                >
                    Dados do Cliente
                </h5>


                <div class="row g-4">

                    <div class="col-md-6">

                        <small class="text-muted">
                            Cliente
                        </small>

                        <div class="fw-semibold">

                            {{ $orcamento
                                ->atendimento
                                ->cliente
                                ->nome }}

                        </div>

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted">
                            Telefone
                        </small>

                        <div class="fw-semibold">

                            {{ $orcamento
                                ->atendimento
                                ->cliente
                                ->telefone }}

                        </div>

                    </div>


                    @if(
                        $orcamento
                            ->atendimento
                            ->cliente
                            ->email
                    )

                        <div class="col-md-6">

                            <small class="text-muted">
                                E-mail
                            </small>

                            <div>

                                {{ $orcamento
                                    ->atendimento
                                    ->cliente
                                    ->email }}

                            </div>

                        </div>

                    @endif


                    @if(
                        $orcamento
                            ->atendimento
                            ->cliente
                            ->cpf_cnpj
                    )

                        <div class="col-md-6">

                            <small class="text-muted">
                                CPF / CNPJ
                            </small>

                            <div>

                                {{ $orcamento
                                    ->atendimento
                                    ->cliente
                                    ->cpf_cnpj }}

                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- EVENTO --}}
            {{-- ====================================================== --}}

            <div class="mb-5">

                <h5
                    class="fw-bold mb-3"
                    style="color: #163b2b;"
                >
                    Informações do Evento
                </h5>


                <div class="row g-4">


                    <div class="col-md-4">

                        <small class="text-muted">
                            Tipo de Evento
                        </small>

                        <div class="fw-semibold">

                            {{ $orcamento
                                ->atendimento
                                ->tipo_evento
                                ?? 'Não informado' }}

                        </div>

                    </div>


                    <div class="col-md-4">

                        <small class="text-muted">
                            Data do Evento
                        </small>

                        <div class="fw-semibold">

                            @if(
                                $orcamento
                                    ->atendimento
                                    ->data_evento
                            )

                                {{ $orcamento
                                    ->atendimento
                                    ->data_evento
                                    ->format('d/m/Y') }}

                            @else

                                Não informada

                            @endif

                        </div>

                    </div>


                    <div class="col-md-4">

                        <small class="text-muted">
                            Quantidade de Convidados
                        </small>

                        <div class="fw-semibold">

                            {{ $orcamento
                                ->quantidade_convidados
                                ?? 'Não informada' }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- VALORES --}}
            {{-- ====================================================== --}}

            <div class="mb-5">

                <h5
                    class="fw-bold mb-3"
                    style="color: #163b2b;"
                >
                    Investimento
                </h5>


                <div class="table-responsive">

                    <table class="table">

                        <tbody>

                            <tr>

                                <td>
                                    Locação da Chácara
                                </td>

                                <td class="text-end fw-semibold">

                                    R$

                                    {{ number_format(
                                        $orcamento->valor_locacao,
                                        2,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                            </tr>


                            <tr>

                                <td>
                                    Serviços / Adicionais
                                </td>

                                <td class="text-end fw-semibold">

                                    R$

                                    {{ number_format(
                                        $orcamento->valor_adicionais,
                                        2,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                            </tr>


                            @if(
                                $orcamento->desconto > 0
                            )

                                <tr>

                                    <td class="text-success">
                                        Desconto
                                    </td>

                                    <td
                                        class="text-end fw-semibold text-success"
                                    >

                                        - R$

                                        {{ number_format(
                                            $orcamento->desconto,
                                            2,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>

                                </tr>

                            @endif


                            <tr
                                style="
                                    border-top:
                                    2px solid #163b2b;
                                "
                            >

                                <td>

                                    <h5 class="fw-bold mb-0">
                                        TOTAL
                                    </h5>

                                </td>

                                <td class="text-end">

                                    <h4
                                        class="fw-bold mb-0"
                                        style="color: #163b2b;"
                                    >

                                        R$

                                        {{ number_format(
                                            $orcamento->valor_total,
                                            2,
                                            ',',
                                            '.'
                                        ) }}

                                    </h4>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- OBSERVAÇÕES --}}
            {{-- ====================================================== --}}

            @if($orcamento->observacoes)

                <div class="mb-5">

                    <h5
                        class="fw-bold mb-3"
                        style="color: #163b2b;"
                    >
                        Observações
                    </h5>

                    <div
                        class="p-3 bg-light rounded"
                    >

                        {!! nl2br(
                            e(
                                $orcamento
                                    ->observacoes
                            )
                        ) !!}

                    </div>

                </div>

            @endif


            {{-- ====================================================== --}}
            {{-- VALIDADE --}}
            {{-- ====================================================== --}}

            <div
                class="border-top pt-4"
            >

                <div class="row">

                    <div class="col-md-6">

                        <small class="text-muted">
                            Data de emissão
                        </small>

                        <div class="fw-semibold">

                            {{ $orcamento
                                ->created_at
                                ->format('d/m/Y') }}

                        </div>

                    </div>


                    <div class="col-md-6 text-md-end">

                        <small class="text-muted">
                            Proposta válida até
                        </small>

                        <div class="fw-semibold">

                            @if($orcamento->validade)

                                {{ $orcamento
                                    ->validade
                                    ->format('d/m/Y') }}

                            @else

                                Não informada

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- RODAPÉ --}}
            {{-- ====================================================== --}}

            <div
                class="text-center mt-5 pt-4 border-top"
            >

                <div
                    class="fw-bold"
                    style="color: #163b2b;"
                >
                    Chácara Rinald's
                </div>

                <small class="text-muted">
                    Festas & Eventos • Presidente Epitácio - SP
                </small>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- CSS DE IMPRESSÃO --}}
    {{-- ====================================================== --}}

    <style>

        @media print {

            body {
                background: white !important;
            }

            .sidebar,
            .topbar,
            .no-print {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .container-fluid {
                padding: 0 !important;
            }

            .orcamento-documento {
                max-width: 100% !important;
                width: 100% !important;
                box-shadow: none !important;
                border: none !important;
            }

            .orcamento-documento .card-body {
                padding: 20px !important;
            }

            @page {
                size: A4;
                margin: 12mm;
            }

        }

    </style>

</div>