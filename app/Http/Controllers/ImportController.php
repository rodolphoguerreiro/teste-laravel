<?php
namespace App\Http\Controllers;

use App\Jobs\ImportDocumentJob;
use App\Jobs\ProcessImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\File;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    public function process(Request $request)
    {
        $filePath = storage_path('data/2023-03-28.json');
        $jsonData = File::json($filePath);

        if (isset($jsonData['documentos']) && is_array($jsonData['documentos'])) {
            foreach ($jsonData['documentos'] as $documento) {
                ImportDocumentJob::dispatch($documento);
            }

            dispatch(new ProcessImport());

            return redirect()->route('import.index')->with('message', 'Processamento da fila iniciado com sucesso.');
        } else {
            return redirect()->route('import.index')->with('error', 'Formato do JSON inválido ou ausência de documentos.');
        }
    }
}
