<div class="container py-4">

    <div class="mb-4">

        <a
            href="{{ route('atendimentos.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3">
            Editar Atendimento
        </h2>

        <p class="text-muted">
            Atualize o andamento da negociação.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="atualizar">

                <div class="row g-3">


                    <div class="col-md-8">

                        <label class="form-label">
                            Cliente
                        </label>

                        <select
                            wire:model="cliente_id"
                            class="form-select"
                        >

                            @foreach($clientes as $cliente)

                                <option value="{{ $cliente->id }}">
                                    {{ $cliente->nome }}
                                    - {{ $cliente->telefone }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Origem
                        </label>

                        <select
                            wire:model="origem"
                            class="form-select"
                        >

                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Telefone">Telefone</option>
                            <option value="Indicação">Indicação</option>
                            <option value="Presencial">Presencial</option>
                            <option value="Outro">Outro</option>

                        </select>

                    </div>


                    <div class="col-md-5">

                        <label class="form-label">
                            Evento
                        </label>

                        <select
                            wire:model="tipo_evento"
                            class="form-select"
                        >

                            <option value="">
                                Não informado
                            </option>

                            <option value="Casamento">
                                Casamento
                            </option>

                            <option value="Aniversário">
                                Aniversário
                            </option>

                            <option value="Formatura">
                                Formatura
                            </option>

                            <option value="Confraternização">
                                Confraternização
                            </option>

                            <option value="Evento corporativo">
                                Evento corporativo
                            </option>

                            <option value="Outro">
                                Outro
                            </option>

                        </select>

                    </div>


                    <div class="col-md-3">

                        <label class="form-label">
                            Data
                        </label>

                        <input
                            type="date"
                            wire:model="data_evento"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            wire:model.live="status"
                            class="form-select"
                        >

                            <option value="novo">
                                Novo
                            </option>

                            <option value="aguardando_data">
                                Aguardando data
                            </option>

                            <option value="orcamento_enviado">
                                Orçamento enviado
                            </option>

                            <option value="aguardando_cliente">
                                Aguardando cliente
                            </option>

                            <option value="negociacao">
                                Negociação
                            </option>

                            <option value="fechado">
                                Fechado
                            </option>

                            <option value="perdido">
                                Perdido
                            </option>

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Último contato
                        </label>

                        <input
                            type="datetime-local"
                            wire:model="ultimo_contato"
                            class="form-control"
                        >

                    </div>


                    <div class="col-12">

                        <label class="form-label">
                            Observações
                        </label>

                        <textarea
                            wire:model="observacoes"
                            class="form-control"
                            rows="4"
                        ></textarea>

                    </div>


                    @if($status === 'perdido')

                        <div class="col-12">

                            <label class="form-label text-danger">
                                Motivo da perda
                            </label>

                            <textarea
                                wire:model="motivo_perda"
                                class="form-control"
                                rows="3"
                            ></textarea>

                        </div>

                    @endif

                </div>


                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a
                        href="{{ route('atendimentos.index') }}"
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