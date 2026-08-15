<?php

namespace App\Livewire\Agenda;

use Livewire\Component;
use App\Models\Reserva;
use Carbon\Carbon;

class AgendaIndex extends Component
{
    public $mes;
    public $ano;

    public function mount()
{
    Carbon::setLocale('pt_BR');

    $this->mes = now()->month;
    $this->ano = now()->year;
}

    public function mesAnterior()
    {
        $data = Carbon::create(
            $this->ano,
            $this->mes,
            1
        )->subMonth();

        $this->mes = $data->month;
        $this->ano = $data->year;
    }

    public function proximoMes()
    {
        $data = Carbon::create(
            $this->ano,
            $this->mes,
            1
        )->addMonth();

        $this->mes = $data->month;
        $this->ano = $data->year;
    }

    public function hoje()
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

        $reservas = Reserva::with('cliente')
            ->whereBetween(
                'data_evento',
                [
                    $inicioMes->format('Y-m-d'),
                    $fimMes->format('Y-m-d')
                ]
            )
            ->where('status', '!=', 'cancelada')
            ->orderBy('data_evento')
            ->get();

        $reservasPorDia = $reservas->groupBy(
            function ($reserva) {
                return $reserva->data_evento
                    ->format('Y-m-d');
            }
        );

        $diasNoMes = $inicioMes->daysInMonth;

        $primeiroDiaSemana =
            $inicioMes->dayOfWeekIso;

        return view(
            'livewire.agenda.agenda-index',
            compact(
                'inicioMes',
                'fimMes',
                'diasNoMes',
                'primeiroDiaSemana',
                'reservasPorDia'
            )
        );
    }
}