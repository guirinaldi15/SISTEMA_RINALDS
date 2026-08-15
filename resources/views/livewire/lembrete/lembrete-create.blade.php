<div class="container py-4">

    <div class="mb-4">

        <a
            href="{{ route('lembretes.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3">
            Novo Lembrete
        </h2>

        <p class="text-muted">
            Programe quando deverá retornar o atendimento de um cliente.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="salvar">

                <div class="row g-3">


                    <div class="col-md-12">

                        <label class="form-label fw-semibold">
                            Atendimento *
                        </label>

                        <select
                            wire:model="atendimento_id"
                            class="form-select @error('atendimento_id') is-invalid @enderror"
                        >

                            <option value="">
                                Selecione um atendimento
                            </option>

                            @foreach($atendimentos as $atendimento)

                                <option value="{{ $atendimento->id }}">

                                    {{ $atendimento->cliente->nome }}

                                    -

                                    {{ $atendimento->cliente->telefone }}

                                    -

                                    {{ ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $atendimento->status
                                        )
                                    ) }}

                                </option>

                            @endforeach

                        </select>

                        @error('atendimento_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Título *
                        </label>

                        <input
                            type="text"
                            wire:model="titulo"
                            class="form-control @error('titulo') is-invalid @enderror"
                            placeholder="Retornar cliente"
                        >

                        @error('titulo')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Retornar em *
                        </label>

                        <input
                            type="datetime-local"
                            wire:model="lembrar_em"
                            class="form-control @error('lembrar_em') is-invalid @enderror"
                        >

                        @error('lembrar_em')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Descrição
                        </label>

                        <textarea
                            wire:model="descricao"
                            class="form-control"
                            rows="4"
                            placeholder="Ex.: Cliente pediu para retornar amanhã após analisar o orçamento."
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
                        Criar Lembrete
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>