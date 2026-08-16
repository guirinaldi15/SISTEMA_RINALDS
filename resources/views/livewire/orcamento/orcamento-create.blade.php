<div class="container-fluid py-4 px-4">

    <div class="mb-4">

        <a
            href="{{ route('orcamentos.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3 mb-1">
            Novo Orçamento
        </h2>

        <p class="text-muted">
            Crie uma proposta comercial para o cliente.
        </p>

    </div>


    @if($atendimento_id)

        <div class="alert alert-success">

            <strong>
                ✓ Orçamento originado de um atendimento
            </strong>

            <div class="small">
                O atendimento já foi selecionado automaticamente.
            </div>

        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="salvar">

                <div class="row g-3">


                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Atendimento *
                        </label>

                        <select
                            wire:model="atendimento_id"
                            class="form-select
                            @error('atendimento_id')
                                is-invalid
                            @enderror"
                        >

                            <option value="">
                                Selecione um atendimento
                            </option>


                            @foreach(
                                $atendimentos
                                as $atendimento
                            )

                                <option
                                    value="{{ $atendimento->id }}"
                                >

                                    {{
                                        $atendimento
                                            ->cliente
                                            ->nome
                                    }}

                                    -

                                    {{
                                        $atendimento
                                            ->tipo_evento
                                        ?? 'Evento não informado'
                                    }}

                                </option>

                            @endforeach

                        </select>


                        @error('atendimento_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Número *
                        </label>

                        <input
                            type="text"
                            wire:model="numero"
                            class="form-control"
                            readonly
                        >

                    </div>


                    {{-- ESPAÇO --}}
                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Espaço *
                        </label>

                        <select
                            wire:model.live="espaco_id"
                            class="form-select
                            @error('espaco_id')
                                is-invalid
                            @enderror"
                        >

                            <option value="">
                                Selecione um espaço
                            </option>


                            @foreach($espacos as $espaco)

                                <option
                                    value="{{ $espaco->id }}"
                                >

                                    {{ $espaco->nome }}

                                    @if(
                                        $espaco->capacidade_maxima
                                    )

                                        -
                                        até
                                        {{
                                            $espaco
                                                ->capacidade_maxima
                                        }}
                                        pessoas

                                    @endif

                                </option>

                            @endforeach

                        </select>


                        @error('espaco_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-4">

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
                            Quantidade de convidados
                        </label>

                        <input
                            type="number"
                            wire:model="quantidade_convidados"
                            class="form-control"
                            min="1"
                        >

                    </div>


                    <div class="col-md-6">

                        @if($espaco_id)

                            @php

                                $espacoSelecionado =
                                    $espacos->firstWhere(
                                        'id',
                                        $espaco_id
                                    );

                            @endphp


                            @if($espacoSelecionado)

                                <div class="alert alert-light border mb-0">

                                    <strong>
                                        {{ $espacoSelecionado->nome }}
                                    </strong>

                                    <div class="small text-muted">

                                        Capacidade:
                                        {{
                                            $espacoSelecionado
                                                ->capacidade_maxima
                                            ?? 'Não informada'
                                        }}

                                        |

                                        Mesas:
                                        {{
                                            $espacoSelecionado
                                                ->quantidade_mesas
                                        }}

                                        |

                                        Cadeiras:
                                        {{
                                            $espacoSelecionado
                                                ->quantidade_cadeiras
                                        }}

                                    </div>

                                </div>

                            @endif

                        @endif

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Valor da Locação
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                R$
                            </span>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
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
                                min="0"
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
                                min="0"
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
                            Valor Total
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                R$
                            </span>

                            <input
                                type="text"
                                value="{{
                                    number_format(
                                        (float) $valor_total,
                                        2,
                                        ',',
                                        '.'
                                    )
                                }}"
                                class="form-control fw-bold"
                                readonly
                            >

                        </div>

                    </div>


                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Observações
                        </label>

                        <textarea
                            wire:model="observacoes"
                            class="form-control"
                            rows="4"
                            placeholder="Condições, serviços inclusos e observações..."
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
                        wire:loading.attr="disabled"
                        wire:target="salvar"
                    >

                        <span
                            wire:loading.remove
                            wire:target="salvar"
                        >
                            Salvar Orçamento
                        </span>

                        <span
                            wire:loading
                            wire:target="salvar"
                        >
                            Salvando...
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>