<?php

namespace App\Http\Controllers;

use App\Exports\ApCnDnExport;
use App\Exports\ArCnDnExport;
use App\Exports\BankExport;
use App\Exports\JurnalMemoExport;
use App\Exports\KasExport;
use App\Exports\PelunasanHutangDExport;
use App\Exports\PelunasanHutangExport;
use App\Exports\PelunasanPiutangDExport;
use App\Exports\PelunasanPiutangExport;
use App\Models\ExpenseApCnDn;
use App\Models\ExpenseArCnDn;
use App\Models\ExpenseBank;
use App\Models\ExpenseJurnalMemo;
use App\Models\ExpenseKas;
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
            } elseif ($tipe == 'pelunasanpiutangd') {
                $query = ExpensePelunasanPiutangD::query();
            } elseif ($tipe == 'bank') {
                $query = ExpenseBank::query()
                    ->whereBetween('Tgl', [$startDate, $endDate]);
            } elseif ($tipe == 'kas') {
                $query = ExpenseKas::query()
                    ->whereBetween('Tgl', [$startDate, $endDate]);
            } elseif ($tipe == 'jurnalmemo') {
                $query = ExpenseJurnalMemo::query()
                    ->whereBetween('Tgl', [$startDate, $endDate]);
            } elseif ($tipe == 'apcndn') {
                $query = ExpenseApCnDn::query()
                    ->whereBetween('Tgl', [$startDate, $endDate]);
            } elseif ($tipe == 'arcndn') {
                $query = ExpenseArCnDn::query()
                    ->whereBetween('Tgl', [$startDate, $endDate]);
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
                if ($tipe == 'bank') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoBukti', 'like', "%{$searchValue}%")
                            ->orWhere('NomorRecord', 'like', "%{$searchValue}%")
                            ->orWhere('NomorKitir', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'kas') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoBukti', 'like', "%{$searchValue}%")
                            ->orWhere('NoBuktiRef', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'jurnalmemo') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoBukti', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'apcndn') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoBukti', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'arcndn') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoBukti', 'like', "%{$searchValue}%");
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
                return Excel::download(new PelunasanHutangExport($startDate, $endDate), "Expense_PelunasanHutang_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'pelunasanhutangd') {
                return Excel::download(new PelunasanHutangDExport, 'Expense_PelunasanHutangD.xlsx');
            } elseif ($tipe == 'pelunasanpiutang') {
                return Excel::download(new PelunasanPiutangExport($startDate, $endDate), "Expense_PelunasanPiutang_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'pelunasanpiutangd') {
                return Excel::download(new PelunasanPiutangDExport, 'Expense_PelunasanPiutangD.xlsx');
            } elseif ($tipe == 'bank') {
                return Excel::download(new BankExport($startDate, $endDate), "Expense_Bank_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'kas') {
                return Excel::download(new KasExport($startDate, $endDate), "Expense_Kas_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'jurnalmemo') {
                return Excel::download(new JurnalMemoExport($startDate, $endDate), "Expense_Jurnal_Memo_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'apcndn') {
                return Excel::download(new ApCnDnExport($startDate, $endDate), "Expense_AP_CNDN_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'arcndn') {
                return Excel::download(new ArCnDnExport($startDate, $endDate), "Expense_AR_CNDN_{$startDate}_{$endDate}.xlsx");
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
