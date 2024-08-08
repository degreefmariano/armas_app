<?php

namespace App\Http\Resources\Jobs;

use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class JobsPorIdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $start = new DateTime($this->start_job);
        $end = new DateTime($this->end_job);
        $difference = $start->diff($end);
        $timeDifference = $this->formatTimeDifference($difference);

        $archivoTipo = ($this->status === 'FALLIDO') ? 'fallido' : 'original';

        $archivos = [
            [
                'tipo' => $archivoTipo,
                'nombre' => $this->temp_file_name,
            ],
        ];

        if (isset($this->error_file_name) || !is_null($this->error_file_name)) {
            $archivos[] = [
                'tipo' => 'error',
                'nombre' => $this->error_file_name,
            ];
        }

        return [
            'id'              => $this->id,
            'job_id'          => $this->job_id,
            'proceso_arma'    => ($this->tipo == 1) ? 'CORTA' : 'LARGA',
            'usuario_proceso' => trim($this->usuario->name),
            'fecha_proceso'   => $this->queue,
            'inicio_proceso'  => $this->start_job,
            'fin_proceso'     => $this->end_job,
            'duracion'        => $timeDifference,
            'ok_procesados'   => $this->records_ok,
            'no_proceados'    => $this->records_error,
            'estado'          => $this->status,
            'observaciones'   => $this->comments,
            'archivos'        => $archivos,
        ];
    }
    function formatTimeDifference($difference)
    {
        $hours = $difference->h;
        $minutes = $difference->i;
        $seconds = $difference->s;

        if ($hours < 10) {
            $hours = '0' . $hours;
        }

        if ($minutes < 10) {
            $minutes = '0' . $minutes;
        }

        if ($seconds < 10) {
            $seconds = '0' . $seconds;
        }

        return "$hours:$minutes:$seconds";
    }
}
