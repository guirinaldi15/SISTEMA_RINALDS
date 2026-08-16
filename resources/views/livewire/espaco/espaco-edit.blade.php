<div class="container-fluid py-4 px-4">

    <div class="mb-4">

        <a
            href="{{ route('espacos.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3">
            Editar Espaço
        </h2>

        <p class="text-muted">
            Edite as informações do espaço.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="atualizar">

                <div class="row g-3">


                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Nome *
                        </label>

                        <input
                            type="text"
                            wire:model="nome"
                            class="form-control @error('nome') is-invalid @enderror"
                        >

                        @error('nome')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select
                            wire:model="ativo"
                            class="form-select"
                        >

                            <option value="1">
                                Ativo
                            </option>

                            <option value="0">
                                Inativo
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
                            rows="3"
                        ></textarea>

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Capacidade máxima
                        </label>

                        <input
                            type="number"
                            wire:model="capacidade_maxima"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Mesas
                        </label>

                        <input
                            type="number"
                            wire:model="quantidade_mesas"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Cadeiras
                        </label>

                        <input
                            type="number"
                            wire:model="quantidade_cadeiras"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Tipo de cadeira
                        </label>

                        <input
                            type="text"
                            wire:model="tipo_cadeira"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Valor base
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            wire:model="valor_base"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Capacidade de hóspedes
                        </label>

                        <input
                            type="number"
                            wire:model="capacidade_hospedes"
                            class="form-control"
                        >

                    </div>


                    <div class="col-12 mt-4">

                        <h5 class="fw-bold">
                            Estrutura disponível
                        </h5>

                    </div>


                    @php

                        $recursos = [

                            'possui_cozinha'
                                => 'Cozinha',

                            'possui_piscina'
                                => 'Piscina',

                            'possui_churrasqueira'
                                => 'Churrasqueira',

                            'possui_bar_molhado'
                                => 'Bar molhado',

                            'possui_ar_condicionado'
                                => 'Ar-condicionado',

                            'possui_estacionamento'
                                => 'Estacionamento',

                            'possui_wifi'
                                => 'Wi-Fi',

                            'possui_acomodacao'
                                => 'Acomodação',

                        ];

                    @endphp


                    @foreach(
                        $recursos
                        as $campo => $label
                    )

                        <div class="col-md-3">

                            <div class="form-check">

                                <input
                                    type="checkbox"
                                    wire:model="{{ $campo }}"
                                    class="form-check-input"
                                    id="{{ $campo }}"
                                >

                                <label
                                    class="form-check-label"
                                    for="{{ $campo }}"
                                >
                                    {{ $label }}
                                </label>

                            </div>

                        </div>

                    @endforeach


                    <div class="col-md-6 mt-4">

                        <label class="form-label fw-semibold">
                            Itens inclusos
                        </label>

                        <textarea
                            wire:model="itens_inclusos"
                            class="form-control"
                            rows="5"
                            placeholder="Ex.: mesas, cadeiras, freezer..."
                        ></textarea>

                    </div>


                    <div class="col-md-6 mt-4">

                        <label class="form-label fw-semibold">
                            Itens não inclusos
                        </label>

                        <textarea
                            wire:model="itens_nao_inclusos"
                            class="form-control"
                            rows="5"
                            placeholder="Ex.: toalhas, som, alimentos..."
                        ></textarea>

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
                        href="{{ route('espacos.index') }}"
                        class="btn btn-light"
                    >
                        Cancelar
                    </a>


                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Salvar Espaço
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>