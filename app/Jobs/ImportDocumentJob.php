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
use App\Models\Document;


class ImportDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $documento;

    public function __construct(array $documento)
    {
        $this->documento = $documento;
    }

    public function handle()
    {
        try {
            $category = DB::table('categories')
                ->where('name', $this->documento['categoria'])
                ->first();

            if (!$category) {
                $category = DB::table('categories')
                    ->insertGetId(['name' => $this->documento['categoria']]);
            }

            $data = [
                'category_id' => $category->id,
                'title' => $this->documento['titulo'],
                'contents' => $this->documento['conteudo'],
            ];

            Document::create($data);
        } catch (\Exception $e) {
            Log::error('Erro ao importar documento: ' . $e->getMessage());
        }
    }
}
