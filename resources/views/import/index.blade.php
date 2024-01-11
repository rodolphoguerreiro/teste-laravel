<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Importação</div>

                    <div class="card-body">
                        <button class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('process-form').submit();">
                            Processar Fila
                        </button>

                        <form id="process-form" action="{{ route('import.process') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
