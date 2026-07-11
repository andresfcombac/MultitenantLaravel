<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\FormularioRespuesta;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Illuminate\Http\Request;

class FormularioRespuestaController extends Controller
{
    public function index(Request $request, $id)
{
    $formulario = Formulario::with('campos')->findOrFail($id);

    $query = FormularioRespuesta::where(
        'id_formulario',
        $id
    );

    if ($request->filled('nombre')) {

        $query->where(
            'nombres',
            'like',
            '%' . $request->nombre . '%'
        );

    }

    if ($request->filled('correo')) {

        $query->where(
            'correo',
            'like',
            '%' . $request->correo . '%'
        );

    }

    if ($request->filled('documento')) {

        $query->where(
            'numero_documento',
            'like',
            '%' . $request->documento . '%'
        );

    }

    $respuestas = $query
    ->orderBy('fecha_respuesta', 'desc')
    ->paginate(20)
    ->withQueryString();

    $totalRespuestas = FormularioRespuesta::where(
    'id_formulario',
    $id
)->count();

$respuestasHoy = FormularioRespuesta::where(
    'id_formulario',
    $id
)
->whereDate(
    'fecha_respuesta',
    today()
)
->count();

$respuestasMes = FormularioRespuesta::where(
    'id_formulario',
    $id
)
->whereYear(
    'fecha_respuesta',
    now()->year
)
->whereMonth(
    'fecha_respuesta',
    now()->month
)
->count();

    return view(
    'formularios.respuestas',
    compact(
        'formulario',
        'respuestas',
        'totalRespuestas',
        'respuestasHoy',
        'respuestasMes'
    )
);
}

    public function exportar($id)
    {
        $formulario = Formulario::with('campos')->findOrFail($id);

        $respuestas = FormularioRespuesta::where(
            'id_formulario',
            $id
        )->get();

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // ==========================
        // ENCABEZADOS
        // ==========================

        $columna = 1;

        $sheet->setCellValue($this->celda($columna++, 1), 'Nombres');
        $sheet->setCellValue($this->celda($columna++, 1), 'Apellidos');
        $sheet->setCellValue($this->celda($columna++, 1), 'Correo');
        $sheet->setCellValue($this->celda($columna++, 1), 'Teléfono');
        $sheet->setCellValue($this->celda($columna++, 1), 'Tipo documento');
        $sheet->setCellValue($this->celda($columna++, 1), 'Número documento');

        foreach ($formulario->campos->sortBy('orden') as $campo) {
            $sheet->setCellValue(
                $this->celda($columna++, 1),
                $campo->etiqueta
            );
        }

        $sheet->setCellValue(
            $this->celda($columna++, 1),
            'Fecha respuesta'
        );

        // ==========================
        // DATOS
        // ==========================

        $fila = 2;

        foreach ($respuestas as $respuesta) {

            $columna = 1;

            $sheet->setCellValue(
                $this->celda($columna++, $fila),
                $respuesta->nombres
            );

            $sheet->setCellValue(
                $this->celda($columna++, $fila),
                $respuesta->apellidos
            );

            $sheet->setCellValue(
                $this->celda($columna++, $fila),
                $respuesta->correo
            );

            $sheet->setCellValue(
                $this->celda($columna++, $fila),
                $respuesta->telefono
            );

            $sheet->setCellValue(
                $this->celda($columna++, $fila),
                $respuesta->tipo_documento
            );

            $sheet->setCellValue(
                $this->celda($columna++, $fila),
                $respuesta->numero_documento
            );

            foreach ($formulario->campos->sortBy('orden') as $campo) {

                $sheet->setCellValue(
                    $this->celda($columna++, $fila),
                    $respuesta->datos[$campo->etiqueta] ?? ''
                );

            }

            $sheet->setCellValue(
                $this->celda($columna++, $fila),
                $respuesta->fecha_respuesta
            );

            $fila++;
        }

        // Autoajustar columnas

        foreach (range('A', $sheet->getHighestColumn()) as $columnID) {

            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);

        }

        $writer = new Xlsx($spreadsheet);

        $nombre = 'Respuestas_' . $formulario->id_formulario . '.xlsx';

        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $nombre,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ]
        );
    }

    private function celda($columna, $fila)
    {
        return Coordinate::stringFromColumnIndex($columna) . $fila;
    }
    public function importar(Request $request, $id)
{
    $request->validate([
        'archivo' => 'required|file|mimes:xlsx,xls,csv'
    ]);

    $formulario = Formulario::with('campos')->findOrFail($id);

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(
        $request->file('archivo')->getRealPath()
    );

    $sheet = $spreadsheet->getActiveSheet();

    $filas = $sheet->toArray();

    if (count($filas) < 2) {

        return back()->with(
            'error',
            'El archivo no contiene información.'
        );

    }

    // Encabezados del Excel

    $encabezados = array_map(
        'trim',
        $filas[0]
    );

    unset($filas[0]);

    $importadas = 0;

    foreach ($filas as $filaExcel) {

        if (count(array_filter($filaExcel)) == 0) {
            continue;
        }

        $fila = array_combine(
            $encabezados,
            $filaExcel
        );

        $datos = [];

        foreach ($formulario->campos as $campo) {

            $datos[$campo->etiqueta] =
                $fila[$campo->etiqueta] ?? '';

        }

        FormularioRespuesta::create([

            'id_formulario' => $id,

            'datos' => $datos,

            'nombres' => $fila['Nombres'] ?? '',

            'apellidos' => $fila['Apellidos'] ?? '',

            'correo' => $fila['Correo'] ?? '',

            'telefono' => $fila['Teléfono'] ?? '',

            'tipo_documento' => $fila['Tipo documento'] ?? '',

            'numero_documento' => $fila['Número documento'] ?? ''

        ]);

        $importadas++;

    }

    return back()->with(
        'success',
        "Se importaron {$importadas} respuestas correctamente."
    );
}
}