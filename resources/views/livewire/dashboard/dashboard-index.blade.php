<div class="container-fluid py-4 px-4">

    {{-- CABEÇALHO --}}

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Dashboard</h2>
            <p class="text-muted mb-0">
                Visão geral da Chácara Rinald's
            </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('atendimentos.create') }}" class="btn btn-outline-success">
                + Atendimento
            </a>

            <a href="{{ route('reservas.create') }}" class="btn btn-success">
                + Nova Reserva
            </a>
        </div>
    </div>

    {{-- ALERTAS --}}

    @if ($totalAtrasados > 0 || $quantidadePagamentosAtrasados > 0)

        <div class="row g-3 mb-4">

            @if ($totalAtrasados > 0)
                <div class="col-lg-6">
                    <div class="alert alert-danger d-flex justify-content-between align-items-center gap-3 mb-0">
                        <div>
                            <strong>
                                {{ $totalAtrasados }}
                                retorno(s) atrasado(s)
                            </strong>
                            <div class="small">
                                Existem clientes aguardando retorno.
                            </div>
                        </div>

                        <a href="{{ route('lembretes.index') }}" class="btn btn-danger btn-sm">
                            Ver
                        </a>
                    </div>
                </div>
            @endif

            @if ($quantidadePagamentosAtrasados > 0 && auth()->user()?->isAdmin())
                <div class="col-lg-6">
                    <div class="alert alert-warning d-flex justify-content-between align-items-center gap-3 mb-0">
                        <div>
                            <strong>
                                {{ $quantidadePagamentosAtrasados }}
                                pagamento(s) atrasado(s)
                            </strong>
                            <div class="small">
                                R$ {{ number_format($valorAtrasado, 2, ',', '.') }}
                                em atraso
                            </div>
                        </div>

                        <a href="{{ route('pagamentos.index') }}" class="btn btn-warning btn-sm">
                            Ver
                        </a>
                    </div>
                </div>
            @endif

        </div>

    @endif

    {{-- VISÃO GERAL --}}

    <h5 class="fw-bold mb-3">Visão geral</h5>

    <div class="row g-3 mb-4">

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <small class="text-muted text-uppercase fw-semibold">
                        Clientes
                    </small>
                    <h2 class="fw-bold mt-2 mb-1">
                        {{ $totalClientes }}
                    </h2>
                    <small class="text-success">
                        +{{ $clientesNovosMes }} neste mês
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <small class="text-muted text-uppercase fw-semibold">
                        Atendimentos ativos
                    </small>
                    <h2 class="fw-bold mt-2 mb-1">
                        {{ $atendimentosAtivos }}
                    </h2>
                    <small class="text-muted">
                        {{ $novosAtendimentos }} novos
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <small class="text-muted text-uppercase fw-semibold">
                        Retornos hoje
                    </small>
                    <h2 class="fw-bold mt-2 mb-1">
                        {{ $totalRetornosHoje }}
                    </h2>
                    <small class="{{ $totalAtrasados > 0 ? 'text-danger' : 'text-success' }}">
                        {{ $totalAtrasados }} atrasados
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <small class="text-muted text-uppercase fw-semibold">
                        Reservas no mês
                    </small>
                    <h2 class="fw-bold mt-2 mb-1">
                        {{ $reservasMes }}
                    </h2>
                    <small class="text-muted">
                        {{ $reservasConfirmadas }} confirmadas no total
                    </small>
                </div>
            </div>
        </div>

    </div>

    {{-- ÁREA FINANCEIRA --}}

    @if (auth()->user()?->isAdmin())

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Financeiro</h5>

            <a href="{{ route('pagamentos.index') }}" class="btn btn-sm btn-outline-secondary">
                Abrir Financeiro
            </a>
        </div>

        <div class="row g-3 mb-4">

            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <small class="text-muted text-uppercase fw-semibold">
                            Recebido no mês
                        </small>
                        <h3 class="fw-bold text-success mt-2 mb-1">
                            R$ {{ number_format($recebidoMes, 2, ',', '.') }}
                        </h3>
                        <small class="text-muted">
                            Pagamentos recebidos
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <small class="text-muted text-uppercase fw-semibold">
                            Pagamentos pendentes
                        </small>
                        <h3 class="fw-bold mt-2 mb-1">
                            R$ {{ number_format($totalAReceber, 2, ',', '.') }}
                        </h3>
                        <small class="text-muted">
                            Cobranças cadastradas
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <small class="text-muted text-uppercase fw-semibold">
                            Em atraso
                        </small>
                        <h3 class="fw-bold text-danger mt-2 mb-1">
                            R$ {{ number_format($valorAtrasado, 2, ',', '.') }}
                        </h3>
                        <small class="text-danger">
                            {{ $quantidadePagamentosAtrasados }}
                            cobranças
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <small class="text-muted text-uppercase fw-semibold">
                            Reservas quitadas
                        </small>
                        <h2 class="fw-bold mt-2 mb-1">
                            {{ $reservasQuitadas }}
                        </h2>
                        <small class="text-success">
                            Saldo totalmente pago
                        </small>
                    </div>
                </div>
            </div>

        </div>

        {{-- SALDO E FATURAMENTO --}}

        <div class="row g-3 mb-4">

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <small class="text-muted text-uppercase fw-semibold">
                            Saldo devedor das reservas
                        </small>

                        <h2 class="fw-bold text-warning mt-2 mb-1">
                            R$ {{ number_format($saldoTotalReservas, 2, ',', '.') }}
                        </h2>

                        <small class="text-muted">
                            {{ $reservasComSaldoDevedor }}
                            reserva(s) com valores a receber
                        </small>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <small class="text-muted text-uppercase fw-semibold">
                            Recebido nos últimos 12 meses
                        </small>

                        <h2 class="fw-bold text-success mt-2 mb-1">
                            R$ {{ number_format($totalPeriodo, 2, ',', '.') }}
                        </h2>

                        <small class="text-muted">
                            Total recebido no período
                        </small>

                    </div>
                </div>
            </div>

        </div>

        {{-- GRÁFICO DE FATURAMENTO --}}

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">
                    Faturamento mensal
                </h5>

                <p class="text-muted small mb-4">
                    Pagamentos recebidos nos últimos 12 meses.
                </p>

                @if ($totalPeriodo > 0)

                    <div class="table-responsive">

                        <div class="d-flex align-items-end gap-2" style="min-width: 720px; height: 260px;">

                            @foreach ($faturamentoMensal as $mes)
                                @php
                                    $altura = $maiorFaturamento > 0 ? ($mes['valor'] / $maiorFaturamento) * 180 : 0;
                                @endphp

                                <div class="d-flex flex-column justify-content-end align-items-center flex-fill h-100">

                                    <small class="text-muted mb-2" style="font-size: 10px;">
                                        {{ number_format($mes['valor'], 0, ',', '.') }}
                                    </small>

                                    <div class="w-75 bg-success rounded-top"
                                        title="R$ {{ number_format($mes['valor'], 2, ',', '.') }}"
                                        style="height: {{ $altura }}px;
                                                min-height: {{ $mes['valor'] > 0 ? 3 : 0 }}px;">
                                    </div>

                                    <small class="text-muted mt-2 text-nowrap">
                                        {{ $mes['mes'] }}
                                    </small>

                                </div>
                            @endforeach

                        </div>

                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="fs-2 mb-2">📊</div>

                        <h6 class="fw-semibold">
                            Nenhum recebimento no período
                        </h6>

                        <p class="text-muted small mb-0">
                            O gráfico aparecerá quando houver
                            pagamentos recebidos.
                        </p>
                    </div>

                @endif

            </div>
        </div>

        {{-- RESUMO FINANCEIRO POR ESPAÇO --}}

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-1">
                    Resumo financeiro por espaço
                </h5>

                <p class="text-muted small mb-4">
                    Reservas confirmadas ou realizadas,
                    incluindo cadastros sem espaço definido.
                </p>

                <div class="table-responsive">
                    <table class="table align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Espaço</th>
                                <th>Reservas</th>
                                <th>Recebido</th>
                                <th>Saldo devedor</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($resumoEspacos as $espaco)
                                <tr>
                                    <td class="fw-semibold">

                                        {{ $espaco['nome'] }}

                                        @if ($espaco['sem_espaco'])
                                            <span class="badge bg-warning text-dark ms-2">
                                                Cadastro incompleto
                                            </span>
                                        @endif

                                    </td>

                                    <td>
                                        {{ $espaco['reservas'] }}
                                    </td>

                                    <td class="text-success fw-semibold">
                                        R$ {{ number_format($espaco['recebido'], 2, ',', '.') }}
                                    </td>

                                    <td class="fw-semibold">
                                        R$ {{ number_format($espaco['saldo'], 2, ',', '.') }}
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Nenhum espaço encontrado.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td>Total geral</td>

                                <td>
                                    {{ $resumoEspacos->sum('reservas') }}
                                </td>

                                <td class="text-success">
                                    R$ {{ number_format($resumoEspacos->sum('recebido'), 2, ',', '.') }}
                                </td>

                                <td>
                                    R$ {{ number_format($resumoEspacos->sum('saldo'), 2, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>

                    </table>
                </div>

            </div>
        </div>

    @endif

    {{-- RETORNOS E PRÓXIMO EVENTO --}}

    <div class="row g-4 mb-4">

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <h5 class="fw-bold mb-1">
                                Retornos de hoje
                            </h5>
                            <small class="text-muted">
                                Clientes aguardando atendimento
                            </small>
                        </div>

                        <a href="{{ route('lembretes.index') }}" class="btn btn-sm btn-outline-secondary">
                            Ver todos
                        </a>

                    </div>
                </div>

                <div class="card-body px-4">

                    @forelse($retornosHoje as $lembrete)
                        @php
                            $clienteRetorno = $lembrete->atendimento?->cliente;
                            $telefone = preg_replace('/\D/', '', $clienteRetorno?->telefone ?? '');
                        @endphp

                        <div class="d-flex justify-content-between align-items-center border-bottom py-3 gap-3">

                            <div>
                                <div class="fw-semibold">
                                    {{ $clienteRetorno?->nome ?? 'Cliente não informado' }}
                                </div>

                                <small class="text-muted">
                                    {{ $lembrete->titulo }}
                                </small>
                            </div>

                            <div class="d-flex align-items-center gap-3">

                                <strong>
                                    {{ $lembrete->lembrar_em?->format('H:i') }}
                                </strong>

                                @if ($telefone)
                                    <a href="https://wa.me/55{{ $telefone }}" target="_blank"
                                        rel="noopener noreferrer" class="btn btn-success btn-sm">
                                        WhatsApp
                                    </a>
                                @endif

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-5">
                            <h6 class="fw-bold">
                                Nenhum retorno para hoje
                            </h6>

                            <small class="text-muted">
                                Seus atendimentos estão em dia.
                            </small>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">
                        Próximo evento
                    </h5>

                    @if ($proximoEvento)
                        <div class="text-center py-3">
                            <h1 class="fw-bold text-success mb-0">
                                {{ $proximoEvento->data_evento->format('d') }}
                            </h1>

                            <div class="text-muted text-capitalize">
                                {{ $proximoEvento->data_evento->locale('pt_BR')->translatedFormat('F Y') }}
                            </div>
                        </div>

                        <hr>

                        <small class="text-muted">Evento</small>
                        <div class="fw-semibold mb-3">
                            {{ $proximoEvento->tipo_evento }}
                        </div>

                        <small class="text-muted">Cliente</small>
                        <div class="fw-semibold mb-3">
                            {{ $proximoEvento->cliente?->nome ?? 'Não informado' }}
                        </div>

                        <small class="text-muted">Espaço</small>
                        <div class="fw-semibold mb-3">
                            {{ $proximoEvento->espaco?->nome ?? 'Não definido' }}
                        </div>

                        <small class="text-muted">Convidados</small>
                        <div class="fw-semibold mb-3">
                            {{ $proximoEvento->quantidade_convidados ?? 'Não informado' }}
                        </div>

                        <a href="{{ route('reservas.show', $proximoEvento->id) }}"
                            class="btn btn-outline-success w-100">
                            Visualizar reserva
                        </a>
                    @else
                        <div class="text-center text-muted py-5">
                            Nenhum evento futuro cadastrado.
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>

    {{-- PRÓXIMOS EVENTOS --}}

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Próximos eventos</h5>

                <a href="{{ route('agenda.index') }}" class="btn btn-sm btn-outline-secondary">
                    Abrir Agenda
                </a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Data</th>
                            <th>Cliente</th>
                            <th>Evento</th>
                            <th>Espaço</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($proximosEventos as $evento)
                            <tr>
                                <td>
                                    {{ $evento->data_evento->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ $evento->cliente?->nome ?? 'Não informado' }}
                                </td>

                                <td>
                                    {{ $evento->tipo_evento }}
                                </td>

                                <td>
                                    {{ $evento->espaco?->nome ?? 'Não definido' }}
                                </td>

                                <td>
                                    @if ($evento->status === 'confirmada')
                                        <span class="badge bg-success">
                                            Confirmada
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            Pré-reserva
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('reservas.show', $evento->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Ver
                                    </a>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Nenhum evento futuro encontrado.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

    {{-- PAGAMENTOS --}}

    @if (auth()->user()?->isAdmin())

        <div class="row g-4 mb-4">

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-3">
                            Próximos pagamentos
                        </h5>

                        @forelse($proximosPagamentos as $pagamento)
                            <div class="border-bottom py-3">
                                <div class="d-flex justify-content-between gap-2">

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $pagamento->reserva?->cliente?->nome ?? 'Cliente não informado' }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $pagamento->descricao }}
                                        </small>
                                    </div>

                                    <strong>
                                        R$ {{ number_format($pagamento->valor, 2, ',', '.') }}
                                    </strong>

                                </div>

                                <small class="text-muted">
                                    Vencimento:
                                    {{ $pagamento->data_vencimento?->format('d/m/Y') }}
                                </small>
                            </div>

                        @empty

                            <p class="text-muted mb-0">
                                Nenhum pagamento pendente com vencimento futuro.
                            </p>
                        @endforelse

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <h5 class="fw-bold text-danger mb-3">
                            Pagamentos atrasados
                        </h5>

                        @forelse($pagamentosAtrasados as $pagamento)
                            <div class="border-bottom py-3">
                                <div class="d-flex justify-content-between gap-2">

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $pagamento->reserva?->cliente?->nome ?? 'Cliente não informado' }}
                                        </div>

                                        <small class="text-danger">
                                            Venceu em
                                            {{ $pagamento->data_vencimento?->format('d/m/Y') }}
                                        </small>
                                    </div>

                                    <strong class="text-danger">
                                        R$ {{ number_format($pagamento->valor, 2, ',', '.') }}
                                    </strong>

                                </div>
                            </div>

                        @empty

                            <p class="text-muted mb-0">
                                Nenhum pagamento atrasado.
                            </p>
                        @endforelse

                    </div>
                </div>
            </div>

        </div>

    @endif

    {{-- ATENDIMENTOS E CLIENTES RECENTES --}}

    <div class="row g-4 mb-4">

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            Atendimentos recentes
                        </h5>

                        <a href="{{ route('atendimentos.index') }}" class="btn btn-sm btn-outline-secondary">
                            Ver todos
                        </a>
                    </div>

                    @forelse($atendimentosRecentes as $atendimento)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3 gap-3">

                            <div>
                                <div class="fw-semibold">
                                    {{ $atendimento->cliente?->nome ?? 'Não informado' }}
                                </div>

                                <small class="text-muted">
                                    {{ $atendimento->tipo_evento ?? 'Evento não definido' }}
                                </small>
                            </div>

                            <span class="badge bg-secondary">
                                {{ str_replace('_', ' ', $atendimento->status) }}
                            </span>

                        </div>

                    @empty

                        <p class="text-muted">
                            Nenhum atendimento encontrado.
                        </p>
                    @endforelse

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            Clientes recentes
                        </h5>

                        <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-outline-secondary">
                            Ver todos
                        </a>
                    </div>

                    @forelse($clientesRecentes as $cliente)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3 gap-3">

                            <div>
                                <div class="fw-semibold">
                                    {{ $cliente->nome }}
                                </div>

                                <small class="text-muted">
                                    {{ $cliente->telefone }}
                                </small>
                            </div>

                            <small class="text-muted">
                                {{ $cliente->created_at?->format('d/m/Y') }}
                            </small>

                        </div>

                    @empty

                        <p class="text-muted">
                            Nenhum cliente encontrado.
                        </p>
                    @endforelse

                </div>
            </div>
        </div>

    </div>

</div>
