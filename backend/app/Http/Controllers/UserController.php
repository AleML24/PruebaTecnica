<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\ResponseFormat;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use function PHPSTORM_META\map;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //meta
            $page = $request->page ?? 1;
            $perPage = $request->perPage ?? 20;

            //filters
            $role = $request->role;
            $name = $request->name;

            $users = User::query();

            //applying filters
            if ($role)
                $users = $users->where('role', $role);
            if ($name)
                $users = $users->where('name', 'like', "%$name%");

            if ($perPage == -1) {
                $users = $users->get();
                $data = $users;
                $meta = [
                    'total' => $users->count(),
                    'current_page' => 1,
                    'last_page' => 1
                ];
            } else {
                $users = $users->paginate($perPage, ['*'], 'page', $page);
                $data = $users->items();
                $meta = [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'total' => $users->total()
                ];
            }

            return ResponseFormat::response(200, null, $data, $meta);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                throw new Exception("User not found", 404);
            }

            return ResponseFormat::response(200, null, $user);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //data validation
            User::validateData($request);

            $user = User::create($request->all());

            return ResponseFormat::response(201, "User successfully stored", $user);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            //data validation
            User::validateData($request, $update = true);

            $user = User::find($id);
            if (!$user) {
                throw new Exception("User not found", 404);
            }

            $user->update($request->all());

            return ResponseFormat::response(201, "User successfully updated", $user);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $user = User::find($id);
            if (!$user) {
                throw new Exception("User not found", 404);
            }

            $user->delete();

            return ResponseFormat::response(201, "User successfully deleted", $user);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }

    public function statistics(Request $request)
    {
        try {

            $stats = User::select('role')
                ->selectRaw("count(*) as users")
                ->groupBy('role')
                ->get();

            $total = $stats->sum('users');

            $stats->map(function ($item) use ($total) {
                $item->percentage = round($item->users * 100 / $total, 2);
            });

            $data = [
                'total' => $total,
                'roles_users' => $stats
            ];

            return ResponseFormat::response(200, null, $data);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }

    public function exportDataCsv()
    {
        try {
            $archivo = "users.csv";

            $users = DB::table('users')->select('name as usuario', 'email as correo', 'role as rol')->get();

            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$archivo",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];

            $callback = function () use ($users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Usuario', 'Correo', 'Rol']); // Encabezados del CSV
                foreach ($users as $user) {
                    fputcsv($file, [$user->usuario, $user->correo, $user->rol]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Exception $e) {
            return ResponseFormat::exceptionResponse($e);
        }
    }

    public function exportDataXlsx()
    {
        try {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            //columns headlines
            $sheet->setCellValue('A1', 'Usuario');
            $sheet->setCellValue('B1', 'Correo');
            $sheet->setCellValue('C1', 'Rol');

            //get data
            $users = DB::table('users')->select('name as usuario', 'email as correo', 'role as rol')->get();

            //start filling on line 2
            $row = 2;
            foreach ($users as $user) {
                $sheet->setCellValue("A$row", $user->usuario);
                $sheet->setCellValue("B$row", $user->correo);
                $sheet->setCellValue("C$row", $user->rol);
                $row++;
            }

            //Create and save document
            $writer = new Xlsx($spreadsheet);
            $archivo = "users.xlsx";

            // Configurar la respuesta para descargar el archivo
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$archivo\"");
            header('Cache-Control: max-age=0');

            //send file to the browser
            $writer->save('php://output');
            exit;
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function exportDataPdf()
    {

        try {
            //Get Data
            $users = DB::table('users')->select('name as usuario', 'email as correo', 'role as rol')->get();

            //load view and send the data
            $pdf = Pdf::loadView('pdf.exportData', compact('users'));

            // Download pdf file
            // Descargar el archivo PDF
            return $pdf->download('usuarios.pdf');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
