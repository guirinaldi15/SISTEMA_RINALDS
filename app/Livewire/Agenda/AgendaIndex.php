<?php

namespace App\Livewire\Agenda;

use App\Models\Espaco;
use Livewire\Component;
use App\Models\Reserva;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title("Agenda | Rinald's Gestão")]
class AgendaIndex extends Component
{
    public int $mes;
    public int $ano;

    public string $espaco_id = '';

    public function mount(): void
    {
        Carbon::setLocale('pt_BR');

        $this->mes = now()->month;
        $this->ano = now()->year;
    }

    public function mesAnterior(): void
    {
        $data = Carbon::create(
            $this->ano,
            $this->mes,
            1
        )->subMonth();

        $this->mes = $data->month;
        $this->ano = $data->year;
    }

    public function proximoMes(): void
    {
        $data = Carbon::create(
            $this->ano,
            $this->mes,
            1
        )->addMonth();

        $this->mes = $data->month;
        $this->ano = $data->year;
    }

    public function hoje(): void
    {
        $this->mes = now()->month;
        $this->ano = now()->year;
    }

    public function render()
    {
        $inicioMes = Carbon::create(
            $this->ano,
            $this->mes,
            1
        );

        $fimMes = $inicioMes->copy()->endOfMonth();

        $espacos = Espaco::orderBy('nome')->get();

        $reservas = Reserva::with([
            'cliente',
            'espaco',
        ])
            ->whereBetween('data_evento', [
                $inicioMes->toDateString(),
                $fimMes->toDateString(),
            ])
            ->where('status', '!=', 'cancelada')
            ->when(
                $this->espaco_id !== '',
                fn ($query) => $query->where(
                    'espaco_id',
                    $this->espaco_id
                )
            )
            ->orderBy('data_evento')
            ->get();

        $reservasPorDia = $reservas->groupBy(
            fn ($reserva) =>
                $reserva->data_evento->format('Y-m-d')
        );

        $diasNoMes = $inicioMes->daysInMonth;
        $primeiroDiaSemana = $inicioMes->dayOfWeekIso;

        $mes = $this->mes;
        $ano = $this->ano;

        return view(
            'livewire.agenda.agenda-index',
            compact(
                'inicioMes',
                'fimMes',
                'espacos',
                'reservasPorDia',
                'diasNoMes',
                'primeiroDiaSemana',
                'mes',
                'ano'
            )
        );
    }
}