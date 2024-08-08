<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class ImportArmasJobs extends Model
{
    use HasFactory;

    protected $table = 'import_armas_jobs';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';
    public $timestamps = false;

    public const ESTADO_PENDIENTE = 'PENDIENTE';

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function listadoProcesos(Request $request)
    {
        $search = $request->search;
        $query = ImportArmasJobs::select(
                'import_armas_jobs.id', 
                'import_armas_jobs.tipo', 
                'import_armas_jobs.user_id', 
                'import_armas_jobs.queue',
                'import_armas_jobs.status'
            )
            ->join('users', 'import_armas_jobs.user_id', '=', 'users.id')
            ->when(!is_null($request->fecha_desde), function ($query) use ($request) {
                $desde = date('Y-m-d H:i:s', strtotime($request->input('fecha_desde') . ' 00:00:00'));
                $hasta = date('Y-m-d H:i:s', strtotime($request->input('fecha_hasta') . ' 23:59:59'));
                return $query->whereBetween('queue', [$desde, $hasta]);
            })
            ->when(!is_null($request->status), function ($query) use ($request) {
                return $query->where('estado', $request->status);
            });
            

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('users.name', 'LIKE',  "%$search%");
            });
        }

        return $query->orderBy('import_armas_jobs.id', 'DESC')
            ->paginate($request->offset ?? 10);
    }

    public function procesoPorId(int $jobId)
    {
        return ImportArmasJobs::find($jobId);
    }
}
