<div class="container-fluid py-4 px-4">

    <div class="mb-4">

        <a
            href="{{ route('orcamentos.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3 mb-1">
            Editar Orçamento
        </h2>

        <p class="text-muted">
            Atualize a proposta comercial.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="atualizar">

                <div class="row g-3">


                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Atendimento
                        </label>

                        <select
                            wire:model="atendimento_id"
                            class="form-select"
                        >

                            @foreach(
                                $atendimentos
                                as $atendimento
                            )

                                <option
                                    value="{{ $atendimento->id }}"
                                >

                                    {{ $atendimento
                                        ->cliente
                                        ->nome }}

                                    -

                                    {{ $atendimento
                                        ->tipo_evento
                                        ?? 'Evento não informado' }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Número
                        </label>

                        <input
                            type="text"
                            wire:model="numero"
                            class="form-control"
                            readonly
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Validade
                        </label>

                        <input
                            type="date"
                            wire:model="validade"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Convidados
                        </label>

                        <input
                            type="number"
                            wire:model="quantidade_convidados"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Locação
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                R$
                            </span>

                            <input
                                type="number"
                                step="0.01"
                                wire:model.live="valor_locacao"
                                class="form-control"
                            >

                        </div>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Adicionais
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                R$
                            </span>

                            <input
                                type="number"
                                step="0.01"
                                wire:model.live="valor_adicionais"
                                class="form-control"
                            >

                        </div>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Desconto
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                R$
                            </span>

                            <input
                                type="number"
                                step="0.01"
                                wire:model.live="desconto"
                                class="form-control"
                            >

                        </div>

                    </div>


                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select
                            wire:model="status"
                            class="form-select"
                        >

                            <option value="rascunho">
                                Rascunho
                            </option>

                            <option value="enviado">
                                Enviado
                            </option>

                            <option value="aceito">
                                Aceito
                            </option>

                            <option value="recusado">
                                Recusado
                            </option>

                            <option value="expirado">
                                Expirado
                            </option>

                        </select>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Total
                        </label>

                        <input
                            type="text"
                            value="R$ {{ number_format(
                                (float) $valor_total,
                                2,
                                ',',
                                '.'
                            ) }}"
                            class="form-control fw-bold"
                            readonly
                        >

                    </div>


                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Observações
                        </label>

                        <textarea
                            wire:model="observacoes"
                            class="form-control"
                            rows="4"
                        ></textarea>

                    </div>

                </div>


                <div
                    class="d-flex justify-content-end gap-2 mt-4"
                >

                    <a
                        href="{{ route('orcamentos.index') }}"
                        class="btn btn-light"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Salvar Alterações
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>