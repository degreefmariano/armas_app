<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface ImportarArmaInterface
{
    public function importarArmas(Request $request);

    public function importarArmasLargas(Request $request);

    public function downloadTemplateCortas();

    public function downloadTemplateLargas();

    public function listadoProcesos(Request $request);

    public function procesoPorId(int $jobId);

    public function downloadExcel($jobId, $request);
}
