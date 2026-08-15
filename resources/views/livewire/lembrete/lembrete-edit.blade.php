<div class="container py-4">

    <div class="mb-4">

        <a
            href="{{ route('lembretes.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3">
            Editar Lembrete
        </h2>

        <p class="text-muted">
            Atualize o retorno programado.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="atualizar">

                <div class="row g-3">


                    <div class="col-md-12">

                        <label class="form-label fw-semibold">
                            Atendimento
                        </label>

                        <select
                            wire:model="atendimento_id"
                            class="form-select"
                        >

                            @foreach($atendimentos as $atendimento)

                                <option
                                    value="{{ $atendimento->id }}"
                                >

                                    {{ $atendimento->cliente->nome }}

                                    -

                                    {{ $atendimento->cliente->telefone }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Título
                        </label>

                        <input
                            type="text"
                            wire:model="titulo"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Data e horário
                        </label>

                        <input
                            type="datetime-local"
                            wire:model="lembrar_em"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select
                            wire:model="status"
                            class="form-select"
                        >

                            <option value="pendente">
                                Pendente
                            </option>

                            <option value="concluido">
                                Concluído
                            </option>

                            <option value="cancelado">
                                Cancelado
                            </option>

                        </select>

                    </div>


                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Descrição
                        </label>

                        <textarea
                            wire:model="descricao"
                            class="form-control"
                            rows="4"
                        ></textarea>

                    </div>

                </div>


                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a
                        href="{{ route('lembretes.index') }}"
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