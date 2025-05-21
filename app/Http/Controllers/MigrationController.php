<?php

namespace App\Http\Controllers;

use App\Exports\PelunasanHutangDExport;
use App\Exports\PelunasanHutangExport;
use App\Exports\PelunasanPiutangDExport;
use App\Exports\PelunasanPiutangExport;
use App\Models\ExpensePelunasanHutang;
use App\Models\ExpensePelunasanHutangD;
use App\Models\ExpensePelunasanPiutang;
use App\Models\ExpensePelunasanPiutangD;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MigrationController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function getData(Request $request)
    {
        try {
            $periode = $request->input('periode');
            $tipe = $request->input('tipe');

            // Pisahkan tanggal dari format daterangepicker
            $dates = explode(' - ', $periode);
            $startDate = date('Y-m-d', strtotime($dates[0]));
            $endDate = date('Y-m-d', strtotime($dates[1]));

            // Query berdasarkan tipe
            if ($tipe == 'pelunasanhutang') {
                $query = ExpensePelunasanHutang::query()
                    ->whereBetween('Tgl', [$startDate, $endDate]);
            } elseif ($tipe == 'pelunasanhutangd') {
                $query = ExpensePelunasanHutangD::query();
            } elseif ($tipe == 'pelunasanpiutang') {
                $query = ExpensePelunasanPiutang::query()
                    ->whereBetween('Tgl', [$startDate, $endDate]);
            }elseif ($tipe == 'pelunasanpiutangd') {
                $query = ExpensePelunasanPiutangD::query();
            } else {
                return response()->json([
                    'draw' => intval($request->input('draw', 1)),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => []
                ]);
            }

            // Mendapatkan jumlah total record
            $totalData = $query->count();

            // Fitur pencarian
            if ($request->has('search') && !empty($request->input('search.value'))) {
                $searchValue = $request->input('search.value');
                if ($tipe == 'pelunasanhutang') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoBukti', 'like', "%{$searchValue}%")
                            ->orWhere('NoBuktiRef', 'like', "%{$searchValue}%")
                            ->orWhere('NoFaktur', 'like', "%{$searchValue}%")
                            ->orWhere('NamaPemasok', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'pelunasanpiutang') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoBukti', 'like', "%{$searchValue}%")
                            ->orWhere('NoBuktiRef', 'like', "%{$searchValue}%")
                            ->orWhere('NoFaktur', 'like', "%{$searchValue}%")
                            ->orWhere('NamaCustomer', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'pelunasanhutangd') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoBukti', 'like', "%{$searchValue}%")
                            ->orWhere('NoInvoice', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'pelunasanpiutangd') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoBukti', 'like', "%{$searchValue}%")
                            ->orWhere('NoInvoice', 'like', "%{$searchValue}%");
                    });
                }
            }

            // Mendapatkan jumlah record setelah filter
            $totalFiltered = $query->count();

            // Pengurutan
            if ($request->has('order') && $request->input('order.0.column') != '') {
                $column = $request->input('columns.' . $request->input('order.0.column') . '.data');
                $dir = $request->input('order.0.dir');
                $query->orderBy($column, $dir);
            }

            // Paginasi
            if ($request->input('length') != -1) {
                $query->skip($request->input('start'))->take($request->input('length'));
            }

            $data = $query->get();

            // Menyiapkan format respons yang dibutuhkan DataTables
            $response = [
                "draw" => intval($request->input('draw')),
                "recordsTotal" => $totalData,
                "recordsFiltered" => $totalFiltered,
                "data" => $data
            ];

            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'draw' => intval($request->input('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ], 500);
        }
    }

    public function downloadData(Request $request)
    {
        try {
            $tipe = $request->input('tipe');
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            if ($tipe == 'pelunasanhutang') {
                return Excel::download(new PelunasanHutangExport($startDate, $endDate), "pelunasanhutang_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'pelunasanhutangd') {
                return Excel::download(new PelunasanHutangDExport, 'pelunasanhutangd.xlsx');
            } elseif ($tipe == 'pelunasanpiutang') {
                return Excel::download(new PelunasanPiutangExport($startDate, $endDate), "pelunasanpiutang_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'pelunasanpiutangd') {
                return Excel::download(new PelunasanPiutangDExport, 'pelunasanpiutangd.xlsx');
            } elseif ($tipe == 'all') {

            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
