<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue;

    public function handle()
    {
        try {
            $jobs = DB::table('jobs')
                ->where('queue', 'default')
                ->get();

            foreach ($jobs as $job) {
                $payload = json_decode($job->payload);
                $class = $payload->data->command;

                if ($class == 'ImportDocumentJob') {
                    $data = $payload->data->command;

                    $importJob = new ImportDocumentJob($data->documento);
                    $importJob->handle();

                    DB::table('jobs')->where('id', $job->id)->delete();
                }
            }
        } catch (\Exception $e) {
            Log::error('Erro ao processar a fila de importação: ' . $e->getMessage());
        }
    }
}
