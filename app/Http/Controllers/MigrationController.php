<?php

namespace App\Http\Controllers;

use App\Exports\ApCnDnExport;
use App\Exports\ArCnDnExport;
use App\Exports\BankExport;
use App\Exports\JurnalMemoExport;
use App\Exports\KasExport;
use App\Exports\MApDExport;
use App\Exports\MApHExport;
use App\Exports\MArDExport;
use App\Exports\MArHExport;
use App\Exports\MbeliDExport;
use App\Exports\PelunasanHutangDExport;
use App\Exports\PelunasanHutangExport;
use App\Exports\PelunasanPiutangDExport;
use App\Exports\PelunasanPiutangExport;
use App\Exports\PembayaranKlaimExport;
use App\Exports\PembayaranPphKlaimExport;
use App\Exports\PenjualanDExport;
use App\Exports\PenjualanHExport;
use App\Exports\SaldoAwalKlaimExport;
use App\Exports\TagihanKlaimExport;
use App\Models\ExpenseApCnDn;
use App\Models\ExpenseArCnDn;
use App\Models\ExpenseBank;
use App\Models\ExpenseJurnalMemo;
use App\Models\ExpenseKas;
use App\Models\ExpensePelunasanHutang;
use App\Models\ExpensePelunasanHutangD;
use App\Models\ExpensePelunasanPiutang;
use App\Models\ExpensePelunasanPiutangD;
use App\Models\MApD;
use App\Models\MApH;
use App\Models\MArD;
use App\Models\MArH;
use App\Models\MbeliD;
use App\Models\MbeliH;
use App\Models\PembayaranKlaim;
use App\Models\PembayaranPphKlaim;
use App\Models\PenjualanD;
use App\Models\PenjualanH;
use App\Models\SaldoAwalKlaim;
use App\Models\TagihanKlaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MigrationController extends Controller
{
    public function index()
    {
        $column_maph = DB::connection('sqlsrv_252')->select($this->tableDefQuery('MApH'));
        $column_mapd = DB::connection('sqlsrv_252')->select($this->tableDefQuery('MAPD'));
        $column_marh = DB::connection('sqlsrv_252')->select($this->tableDefQuery('MArH'));
        $column_mard = DB::connection('sqlsrv_252')->select($this->tableDefQuery('MArD'));
        $column_mbelih = DB::connection('sqlsrv_252')->select($this->tableDefQuery('MbeliH'));
        $column_mbelid = DB::connection('sqlsrv_252')->select($this->tableDefQuery('MbeliD'));
        $column_penjualanh = DB::connection('sqlsrv_252')->select($this->tableDefQuery('temp_penjualan_h'));
        $column_penjualand = DB::connection('sqlsrv_252')->select($this->tableDefQuery('temp_penjualan_d'));

        $config = [
            'maph' => [
                'columns' => $column_maph,
                'pageLength' => 25,
                'processing' => true,
                'serverSide' => true,
            ],
            'mapd' => [
                'columns' => $column_mapd,
                'pageLength' => 25,
                'processing' => true,
                'serverSide' => true,
            ],
            'marh' => [
                'columns' => $column_marh,
                'pageLength' => 25,
                'processing' => true,
                'serverSide' => true,
            ],
            'mard' => [
                'columns' => $column_mard,
                'pageLength' => 25,
                'processing' => true,
                'serverSide' => true,
            ],
            'mbelih' => [
                'columns' => $column_mbelih,
                'pageLength' => 25,
                'processing' => true,
                'serverSide' => true,
            ],
            'mbelid' => [
                'columns' => $column_mbelid,
                'pageLength' => 25,
                'processing' => true,
                'serverSide' => true,
            ],
            'penjualanh' => [
                'columns' => $column_penjualanh,
                'pageLength' => 25,
                'processing' => true,
                'serverSide' => true,
            ],
            'penjualand' => [
                'columns' => $column_penjualand,
                'pageLength' => 25,
                'processing' => true,
                'serverSide' => true,
            ]
        ];

        return view('index', compact('config'));
    }

    public function tableDefQuery($table_name, $schema = "dbo")
    {
        $query = "
        SELECT
            COLUMN_NAME AS data,
            COLUMN_NAME AS name
        FROM
            INFORMATION_SCHEMA.COLUMNS
        WHERE
            TABLE_NAME = '$table_name' AND
            TABLE_SCHEMA = '$schema'
        ";

        return $query;
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
            } elseif ($tipe == 'tagihanklaim') {
                $query = TagihanKlaim::query()
                    ->whereBetween('TGL PIUTANG KLAIM', [$startDate, $endDate]);
            } elseif ($tipe == 'pembayaranklaim') {
                $query = PembayaranKlaim::query()
                    ->whereBetween('TGL BAYAR', [$startDate, $endDate]);
            } elseif ($tipe == 'pembayaranpphklaim') {
                $query = PembayaranPphKlaim::query()
                    ->whereBetween('TGL BAYAR', [$startDate, $endDate]);
            } elseif ($tipe == 'saldoawalklaim') {
                $query = SaldoAwalKlaim::query();
            } elseif ($tipe == 'maph') {
                $query = MApH::query();
            } elseif ($tipe == 'mapd') {
                $query = MApD::query();
            } elseif ($tipe == 'marh') {
                $query = MArH::query();
            } elseif ($tipe == 'mard') {
                $query = MArD::query();
            } elseif ($tipe == 'mbelih') {
                $query = MbeliH::query()
                    ->whereBetween('TglReceiving', [$startDate, $endDate]);
            } elseif ($tipe == 'mbelid') {
                $query = MbeliD::query();
            } elseif ($tipe == 'penjualanh') {
                $query = PenjualanH::query()
                    ->whereBetween('TglDO', [$startDate, $endDate]);
            } elseif ($tipe == 'penjualand') {
                $query = PenjualanD::query();
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
                if ($tipe == 'pelunasanhutangd' || $tipe == 'pelunasanpiutangd') {
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
                if ($tipe == 'jurnalmemo' || $tipe == 'apcndn' || $tipe == 'arcndn') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoBukti', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'tagihanklaim' || $tipe == 'pembayaranklaim' || $tipe == 'pembayaranpphklaim') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NOBUKTI', 'like', "%{$searchValue}%")
                            ->orWhere('PRINCIPAL', 'like', "%{$searchValue}%")
                            ->orWhere('NAMA_PRINCIPAL', 'like', "%{$searchValue}%")
                            ->orWhere('DEPO', 'like', "%{$searchValue}%")
                            ->orWhere('NAMA_DEPO', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'saldoawalklaim') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NOBUKTI', 'like', "%{$searchValue}%")
                            ->orWhere('PRINCIPAL', 'like', "%{$searchValue}%")
                            ->orWhere('NAMA_PRINCIPAL', 'like', "%{$searchValue}%")
                            ->orWhere('DEPO', 'like', "%{$searchValue}%")
                            ->orWhere('NAMA_DEPO', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'maph' || $tipe == 'marh') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoInvoice', 'like', "%{$searchValue}%")
                            ->orWhere('TglInvoice', 'like', "%{$searchValue}%")
                            ->orWhere('NoPajak', 'like', "%{$searchValue}%")
                            ->orWhere('TglPajak', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'mapd') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoInvoice', 'like', "%{$searchValue}%")
                            ->orWhere('NoReceiving', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'mard') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoInvoice', 'like', "%{$searchValue}%")
                            ->orWhere('NoDO', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'mbelih') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoReceiving', 'like', "%{$searchValue}%")
                            ->orWhere('TglReceiving', 'like', "%{$searchValue}%")
                            ->orWhere('NoPurchaseOrder', 'like', "%{$searchValue}%")
                            ->orWhere('KodePemasok', 'like', "%{$searchValue}%")
                            ->orWhere('PT', 'like', "%{$searchValue}%")
                            ->orWhere('NamaPT', 'like', "%{$searchValue}%")
                            ->orWhere('PRINCIPLE', 'like', "%{$searchValue}%")
                            ->orWhere('NamaPrinciple', 'like', "%{$searchValue}%")
                            ->orWhere('DEPO', 'like', "%{$searchValue}%")
                            ->orWhere('NamaDepo', 'like', "%{$searchValue}%")
                            ->orWhere('Area', 'like', "%{$searchValue}%")
                            ->orWhere('NamaArea', 'like', "%{$searchValue}%")
                            ->orWhere('NoInvoice', 'like', "%{$searchValue}%")
                            ->orWhere('NoPajak', 'like', "%{$searchValue}%")
                            ->orWhere('TglPajak', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'mbelid') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoSJ', 'like', "%{$searchValue}%")
                            ->orWhere('SKU_kode', 'like', "%{$searchValue}%")
                            ->orWhere('TipePembelian', 'like', "%{$searchValue}%")
                            ->orWhere('TipePembelian2', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'penjualanh') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoDO', 'like', "%{$searchValue}%")
                            ->orWhere('NoSalesOrder', 'like', "%{$searchValue}%")
                            ->orWhere('KodePelanggan', 'like', "%{$searchValue}%")
                            ->orWhere('PT', 'like', "%{$searchValue}%")
                            ->orWhere('PRINCIPLE', 'like', "%{$searchValue}%")
                            ->orWhere('DEPO', 'like', "%{$searchValue}%")
                            ->orWhere('AREA', 'like', "%{$searchValue}%")
                            ->orWhere('NoInvoice', 'like', "%{$searchValue}%")
                            ->orWhere('NoPajak', 'like', "%{$searchValue}%")
                            ->orWhere('TUNAI', 'like', "%{$searchValue}%")
                            ->orWhere('TipeOrder', 'like', "%{$searchValue}%");
                    });
                }
                if ($tipe == 'penjualand') {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('NoDO', 'like', "%{$searchValue}%")
                            ->orWhere('SKU_kode', 'like', "%{$searchValue}%")
                            ->orWhere('TipeOrder', 'like', "%{$searchValue}%");
                    });
                }
            }

            // Column specific filters
            foreach ($request->get('columns') as $column) {
                if (!empty($column['search']['value'])) {
                    $query->where($column['data'], 'like', "%{$column['search']['value']}%");
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
            } elseif ($tipe == 'tagihanklaim') {
                return Excel::download(new TagihanKlaimExport($startDate, $endDate), "Data_Tagihan_Klaim_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'pembayaranklaim') {
                return Excel::download(new PembayaranKlaimExport($startDate, $endDate), "Data_Pembayaran_Klaim_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'pembayaranpphklaim') {
                return Excel::download(new PembayaranPphKlaimExport($startDate, $endDate), "Data_PembayaranPPH_Klaim_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'saldoawalklaim') {
                return Excel::download(new SaldoAwalKlaimExport($startDate, $endDate), "Saldo_Awal_Klaim_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'maph') {
                return Excel::download(new MApHExport($startDate, $endDate), "MApH_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'mapd') {
                return Excel::download(new MApDExport($startDate, $endDate), "MApD_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'marh') {
                return Excel::download(new MArHExport($startDate, $endDate), "MArH_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'mard') {
                return Excel::download(new MArDExport($startDate, $endDate), "MArD_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'mbelih') {
                return Excel::download(new MbeliH($startDate, $endDate), "MbeliH_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'mbelid') {
                return Excel::download(new MbeliDExport($startDate, $endDate), "MbeliD_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'penjualanh') {
                return Excel::download(new PenjualanHExport($startDate, $endDate), "temp_penjualan_h_{$startDate}_{$endDate}.xlsx");
            } elseif ($tipe == 'penjualand') {
                return Excel::download(new PenjualanDExport($startDate, $endDate), "temp_penjualan_d_{$startDate}_{$endDate}.xlsx");
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
