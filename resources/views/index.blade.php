@extends('layouts.master')

@section('title', 'Migration View')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <style>
        div.dataTables_processing {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            width: 200px !important;
            height: auto !important;
            margin-left: -100px !important;
            margin-top: -60px !important;
            text-align: center !important;
            padding: 20px !important;
            background: rgba(255, 255, 255, 0.95) !important;
            border-radius: 10px !important;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2) !important;
            z-index: 9999 !important;
            border: none !important;
        }

        .dt-processing-container {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .dt-processing-spinner {
            width: 50px !important;
            height: 50px !important;
            margin-bottom: 15px !important;
            border: 4px solid #f3f3f3 !important;
            border-top: 4px solid #3498db !important;
            border-radius: 50% !important;
            animation: spin 1s linear infinite !important;
        }

        .dt-processing-text {
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #333 !important;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .dt-processing-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9998;
        }

        /* CSS untuk mengatur lebar kolom */
        .dataTables_wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table.dataTable {
            width: 100% !important;
            margin: 0 !important;
        }

        table.dataTable th,
        table.dataTable td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Atur lebar maksimum untuk kolom tertentu */
        table.dataTable th.dt-head-nowrap,
        table.dataTable td.dt-body-nowrap {
            white-space: nowrap !important;
        }

        /* Tambahkan class untuk kolom yang perlu lebar khusus */
        .column-sm {
            max-width: 80px !important;
        }

        .column-md {
            max-width: 150px !important;
        }

        .column-lg {
            max-width: 250px !important;
        }
    </style>
@endsection


@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">MIGRATION</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-default">
                        <label>PERIODE</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="filter_periode" id="filter_periode"
                                placeholder="Pilih Periode" aria-label="Pilih Periode" value="01/01/2024 - 02/01/2024" />
                        </div>
                    </div>
                </div>
                <div class="col-xm-12 col-sm-12 col-md-12 col-lg-12 mb-3">
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupFilter">Terapkan ke:</label>
                        <select class="form-select" id="inputGroupFilter" aria-label="Example select with button addon">
                            <option value='all'>--ALL--</option>
                            <option value="pelunasanhutang">Pelunasan Hutang</option>
                            <option value="pelunasanhutangd">Pelunasan Hutang Detail</option>
                            <option value="pelunasanpiutang">Pelunasan Piutang</option>
                            <option value="pelunasanpiutangd">Pelunasan Piutang Detail</option>
                            <option value="bank">Expense Bank</option>
                            <option value="kas">Expense Kas</option>
                            <option value="jurnalmemo">Expense Jurnal Memo</option>
                            <option value="apcndn">Expense AP CN/DN</option>
                            <option value="arcndn">Expense AR CN/DN</option>
                            <option value="tagihanklaim">Tagihan Klaim</option>
                            <option value="pembayaranklaim">Pembayaran Klaim</option>
                            <option value="pembayaranpphklaim">Pembayaran PPH Klaim</option>
                            <option value="saldoawalklaim">Saldo Awal Klaim</option>
                            <option value="maph">MAp Header</option>
                            <option value="mapd">MAp Detail</option>
                            <option value="marh">MAr Header</option>
                            <option value="mard">MAr Detail</option>
                            <option value="mbelih">MBeli Header</option>
                            <option value="mbelid">MBeli Detail</option>
                            <option value="penjualanh">Penjualan Header</option>
                            <option value="penjualand">Penjualan Detail</option>
                            <option value="koreksih">Koreksi Header</option>
                            <option value="koreksid">Koreksi Detail</option>
                            <option value="mutasih">Mutasi Header</option>
                            <option value="mutasid">Mutasi Detail</option>
                            <option value="saldohutang">Saldo Hutang</option>
                            <option value="saldopiutang">Saldo Piutang</option>
                        </select>
                        <button id="btn-download" class="btn btn-outline-success"><i
                                class="fas fa-download"></i> Download</button>
                        <button id="btn-filter" class="btn btn-outline-primary"><i
                                class="fas fa-check"></i> Filter</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="tab-0" data-bs-toggle="tab"
                                    href="#tabpanel-pelunasanhutang" role="tab" aria-controls="tabpanel-pelunasanhutang"
                                    aria-selected="true">Pelunasan Hutang</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-1" data-bs-toggle="tab"
                                    href="#tabpanel-pelunasanhutangdetail" role="tab"
                                    aria-controls="tabpanel-pelunasanhutangdetail" aria-selected="false">Pelunasan Hutang
                                    Detail</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-2" data-bs-toggle="tab" href="#tabpanel-pelunasanpiutang"
                                    role="tab" aria-controls="tabpanel-pelunasanpiutang" aria-selected="false">Pelunasan
                                    Piutang</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-3" data-bs-toggle="tab"
                                    href="#tabpanel-pelunasanpiutangdetail" role="tab"
                                    aria-controls="tabpanel-pelunasanpiutangdetail" aria-selected="false">Pelunasan Piutang
                                    Detail</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-4" data-bs-toggle="tab"
                                    href="#tabpanel-bank" role="tab"
                                    aria-controls="tabpanel-bank" aria-selected="false">Expense Bank</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-5" data-bs-toggle="tab"
                                    href="#tabpanel-kas" role="tab"
                                    aria-controls="tabpanel-kas" aria-selected="false">Expense Kas</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-6" data-bs-toggle="tab"
                                    href="#tabpanel-jurnalmemo" role="tab"
                                    aria-controls="tabpanel-jurnalmemo" aria-selected="false">Expense Jurnal Memo</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-7" data-bs-toggle="tab"
                                    href="#tabpanel-apcndn" role="tab"
                                    aria-controls="tabpanel-apcndn" aria-selected="false">Expense AP CN/DN</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-8" data-bs-toggle="tab"
                                    href="#tabpanel-arcndn" role="tab"
                                    aria-controls="tabpanel-arcndn" aria-selected="false">Expense AR CN/DN</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-9" data-bs-toggle="tab"
                                    href="#tabpanel-tagihanklaim" role="tab"
                                    aria-controls="tabpanel-tagihanklaim" aria-selected="false">Tagihan Klaim</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-10" data-bs-toggle="tab"
                                    href="#tabpanel-pembayaranklaim" role="tab"
                                    aria-controls="tabpanel-pembayaranklaim" aria-selected="false">Pembayaran Klaim</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-11" data-bs-toggle="tab"
                                    href="#tabpanel-pembayaranpphklaim" role="tab"
                                    aria-controls="tabpanel-pembayaranpphklaim" aria-selected="false">Pembayaran PPH Klaim</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-12" data-bs-toggle="tab"
                                    href="#tabpanel-saldoawalklaim" role="tab"
                                    aria-controls="tabpanel-saldoawalklaim" aria-selected="false">Saldo Awal Klaim</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-13" data-bs-toggle="tab"
                                    href="#tabpanel-maph" role="tab"
                                    aria-controls="tabpanel-maph" aria-selected="false">MAp Header</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-14" data-bs-toggle="tab"
                                    href="#tabpanel-mapd" role="tab"
                                    aria-controls="tabpanel-mapd" aria-selected="false">MAp Detail</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-15" data-bs-toggle="tab"
                                    href="#tabpanel-marh" role="tab"
                                    aria-controls="tabpanel-marh" aria-selected="false">MAr Header</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-16" data-bs-toggle="tab"
                                    href="#tabpanel-mard" role="tab"
                                    aria-controls="tabpanel-mard" aria-selected="false">MAr Detail</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-17" data-bs-toggle="tab"
                                    href="#tabpanel-mbelih" role="tab"
                                    aria-controls="tabpanel-mbelih" aria-selected="false">Mbeli Header</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-18" data-bs-toggle="tab"
                                    href="#tabpanel-mbelid" role="tab"
                                    aria-controls="tabpanel-mbelid" aria-selected="false">Mbeli Detail</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-19" data-bs-toggle="tab"
                                    href="#tabpanel-penjualanh" role="tab"
                                    aria-controls="tabpanel-penjualanh" aria-selected="false">Penjualan Header</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-20" data-bs-toggle="tab"
                                    href="#tabpanel-penjualand" role="tab"
                                    aria-controls="tabpanel-penjualand" aria-selected="false">Penjualan Detail</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-21" data-bs-toggle="tab"
                                    href="#tabpanel-koreksih" role="tab"
                                    aria-controls="tabpanel-koreksih" aria-selected="false">Koreksi Header</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-22" data-bs-toggle="tab"
                                    href="#tabpanel-koreksid" role="tab"
                                    aria-controls="tabpanel-koreksid" aria-selected="false">Koreksi Detail</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-23" data-bs-toggle="tab"
                                    href="#tabpanel-mutasih" role="tab"
                                    aria-controls="tabpanel-mutasih" aria-selected="false">Mutasi Header</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-24" data-bs-toggle="tab"
                                    href="#tabpanel-mutasid" role="tab"
                                    aria-controls="tabpanel-mutasid" aria-selected="false">Mutasi Detail</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-25" data-bs-toggle="tab"
                                    href="#tabpanel-saldohutang" role="tab"
                                    aria-controls="tabpanel-saldohutang" aria-selected="false">Saldo Hutang</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="tab-26" data-bs-toggle="tab"
                                    href="#tabpanel-saldopiutang" role="tab"
                                    aria-controls="tabpanel-saldopiutang" aria-selected="false">Saldo Piutang</a>
                            </li>
                        </ul>
                        <div class="tab-content pt-5" id="tab-content">
                            <div class="tab-pane active" id="tabpanel-pelunasanhutang" role="tabpanel"
                                aria-labelledby="tabpanel-pelunasanhutang">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-pelunasanhutang">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-pelunasanhutangdetail" role="tabpanel"
                                aria-labelledby="tabpanel-pelunasanhutangdetail">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-pelunasanhutangdetail">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-pelunasanpiutang" role="tabpanel"
                                aria-labelledby="tabpanel-pelunasanpiutang">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-pelunasanpiutang">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-pelunasanpiutangdetail" role="tabpanel"
                                aria-labelledby="tabpanel-pelunasanpiutangdetail">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-pelunasanpiutangdetail">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-bank" role="tabpanel"
                                aria-labelledby="tabpanel-bank">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-bank">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-kas" role="tabpanel"
                                aria-labelledby="tabpanel-kas">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-kas">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-jurnalmemo" role="tabpanel"
                                aria-labelledby="tabpanel-jurnalmemo">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-jurnalmemo">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-apcndn" role="tabpanel"
                                aria-labelledby="tabpanel-apcndn">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-apcndn">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-arcndn" role="tabpanel"
                                aria-labelledby="tabpanel-arcndn">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-arcndn">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-tagihanklaim" role="tabpanel"
                                aria-labelledby="tabpanel-tagihanklaim">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-tagihanklaim">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-pembayaranklaim" role="tabpanel"
                                aria-labelledby="tabpanel-pembayaranklaim">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-pembayaranklaim">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-pembayaranpphklaim" role="tabpanel"
                                aria-labelledby="tabpanel-pembayaranpphklaim">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-pembayaranpphklaim">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-saldoawalklaim" role="tabpanel"
                                aria-labelledby="tabpanel-saldoawalklaim">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-saldoawalklaim">
                                        <thead>

                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-maph" role="tabpanel"
                                aria-labelledby="tabpanel-maph">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-maph">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-mapd" role="tabpanel"
                                aria-labelledby="tabpanel-mapd">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-mapd">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-marh" role="tabpanel"
                                aria-labelledby="tabpanel-marh">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-marh">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-mard" role="tabpanel"
                                aria-labelledby="tabpanel-mard">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-mard">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-mbelih" role="tabpanel"
                                aria-labelledby="tabpanel-mbelih">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-mbelih">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-mbelid" role="tabpanel"
                                aria-labelledby="tabpanel-mbelid">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-mbelid">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-penjualanh" role="tabpanel"
                                aria-labelledby="tabpanel-penjualanh">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-penjualanh">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-penjualand" role="tabpanel"
                                aria-labelledby="tabpanel-penjualand">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-penjualand">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-koreksih" role="tabpanel"
                                aria-labelledby="tabpanel-koreksih">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-koreksih">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-koreksid" role="tabpanel"
                                aria-labelledby="tabpanel-koreksid">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-koreksid">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-mutasih" role="tabpanel"
                                aria-labelledby="tabpanel-mutasih">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-mutasih">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-mutasid" role="tabpanel"
                                aria-labelledby="tabpanel-mutasid">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-mutasid">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-saldohutang" role="tabpanel"
                                aria-labelledby="tabpanel-saldohutang">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-saldohutang">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabpanel-saldopiutang" role="tabpanel"
                                aria-labelledby="tabpanel-saldopiutang">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-saldopiutang">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/plugin/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/toastr/toastr.min.js') }}"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "toastClass": "colored-toast"
        };

        $(document).ready(function() {
            var tablePelunasanHutang, tablePelunasanHutangDetail, tablePelunasanPiutang,
            tablePelunasanPiutangDetail, tableBank, tableKas, tableJurnalMemo,
            tableApCnDn, tableArCnDn, tableTagihanKlaim, tablePembayaranKlaim, tablePembayaranPphKlaim,
            tableSaldoAwalKlaim, tableMApH, tableMApD, tableMArH, tableMArD, tableMbeliH, tableMbeliD,
            tablePenjualanH, tablePenjualanD, tableKoreksiH, tableKoreksiD, tableMutasiH, tableMutasiD,
            tableSaldoHutang, tableSaldoPiutang;

            const tableConfig = @json($config);

            $('#table-pelunasanhutang').html(generateThead(tableConfig.pelunasanhutang));
            $('#table-pelunasanhutangdetail').html(generateThead(tableConfig.pelunasanhutangd));
            $('#table-pelunasanpiutang').html(generateThead(tableConfig.pelunasanpiutang));
            $('#table-pelunasanpiutangdetail').html(generateThead(tableConfig.pelunasanpiutangd));
            $('#table-bank').html(generateThead(tableConfig.bank));
            $('#table-kas').html(generateThead(tableConfig.kas));
            $('#table-jurnalmemo').html(generateThead(tableConfig.jurnalmemo));
            $('#table-apcndn').html(generateThead(tableConfig.apcndn));
            $('#table-arcndn').html(generateThead(tableConfig.arcndn));
            $('#table-tagihanklaim').html(generateThead(tableConfig.tagihanklaim));
            $('#table-pembayaranklaim').html(generateThead(tableConfig.pembayaranklaim));
            $('#table-pembayaranpphklaim').html(generateThead(tableConfig.pembayaranpphklaim));
            $('#table-saldoawalklaim').html(generateThead(tableConfig.saldoawalklaim));
            $('#table-maph').html(generateThead(tableConfig.maph));
            $('#table-mapd').html(generateThead(tableConfig.mapd));
            $('#table-marh').html(generateThead(tableConfig.marh));
            $('#table-mard').html(generateThead(tableConfig.mapd));
            $('#table-mbelih').html(generateThead(tableConfig.mbelih));
            $('#table-mbelid').html(generateThead(tableConfig.mbelid));
            $('#table-penjualanh').html(generateThead(tableConfig.penjualanh));
            $('#table-penjualand').html(generateThead(tableConfig.penjualand));
            $('#table-koreksih').html(generateThead(tableConfig.koreksih));
            $('#table-koreksid').html(generateThead(tableConfig.koreksid));
            $('#table-mutasih').html(generateThead(tableConfig.mutasih));
            $('#table-mutasid').html(generateThead(tableConfig.mutasid));
            $('#table-saldohutang').html(generateThead(tableConfig.saldohutang));
            $('#table-saldopiutang').html(generateThead(tableConfig.saldopiutang));

            tablePelunasanHutang = $('#table-pelunasanhutang').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'pelunasanhutang';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.pelunasanhutang.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tablePelunasanHutang.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tablePelunasanHutangDetail = $('#table-pelunasanhutangdetail').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'pelunasanhutangd';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.pelunasanhutangd.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "paging": true,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();
                }
            });

            tablePelunasanPiutang = $('#table-pelunasanpiutang').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'pelunasanpiutang';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.pelunasanpiutang.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();
                }
            });

            tablePelunasanPiutangDetail = $('#table-pelunasanpiutangdetail').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'pelunasanpiutangd';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.pelunasanpiutangd.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "paging": true,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();
                }
            });

            tableBank = $('#table-bank').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'bank';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.bank.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableBank.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableKas = $('#table-kas').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'kas';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.kas.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableKas.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableJurnalMemo = $('#table-jurnalmemo').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'jurnalmemo';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.jurnalmemo.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableJurnalMemo.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableApCnDn = $('#table-apcndn').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'apcndn';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.apcndn.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableApCnDn.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableArCnDn = $('#table-arcndn').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'arcndn';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.arcndn.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableArCnDn.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableTagihanKlaim = $('#table-tagihanklaim').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'tagihanklaim';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.tagihanklaim.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableTagihanKlaim.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tablePembayaranKlaim = $('#table-pembayaranklaim').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'pembayaranklaim';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.pembayaranklaim.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tablePembayaranKlaim.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tablePembayaranPphKlaim = $('#table-pembayaranpphklaim').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'pembayaranpphklaim';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.pembayaranpphklaim.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tablePembayaranPphKlaim.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableSaldoAwalKlaim = $('#table-saldoawalklaim').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'saldoawalklaim';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.saldoawalklaim.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                "pageLength": 25,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableSaldoAwalKlaim.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableMApH = $('#table-maph').DataTable({
                processing: tableConfig.maph.processing,
                serverSide: tableConfig.maph.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'maph';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.maph.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.maph.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableMApH.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableMApD = $('#table-mapd').DataTable({
                processing: tableConfig.mapd.processing,
                serverSide: tableConfig.mapd.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'mapd';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.mapd.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.mapd.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableMApD.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableMArH = $('#table-marh').DataTable({
                processing: tableConfig.marh.processing,
                serverSide: tableConfig.marh.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'marh';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.marh.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.marh.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableMArH.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableMArD = $('#table-mard').DataTable({
                processing: tableConfig.mard.processing,
                serverSide: tableConfig.mard.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'mard';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.mard.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.mard.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableMArD.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableMbeliH = $('#table-mbelih').DataTable({
                processing: tableConfig.mbelih.processing,
                serverSide: tableConfig.mbelih.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'mbelih';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.mbelih.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.mbelih.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableMbeliH.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableMbeliD = $('#table-mbelid').DataTable({
                processing: tableConfig.mbelid.processing,
                serverSide: tableConfig.mbelid.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'mbelid';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.mbelid.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.mbelid.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableMbeliD.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tablePenjualanH = $('#table-penjualanh').DataTable({
                processing: tableConfig.penjualanh.processing,
                serverSide: tableConfig.penjualanh.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'penjualanh';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.penjualanh.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.penjualanh.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tablePenjualanH.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tablePenjualanD = $('#table-penjualand').DataTable({
                processing: tableConfig.penjualand.processing,
                serverSide: tableConfig.penjualand.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'penjualand';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.penjualand.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.penjualand.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tablePenjualanD.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableKoreksiH = $('#table-koreksih').DataTable({
                processing: tableConfig.koreksih.processing,
                serverSide: tableConfig.koreksih.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'koreksih';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.koreksih.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.koreksih.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableKoreksiH.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableKoreksiD = $('#table-koreksid').DataTable({
                processing: tableConfig.koreksid.processing,
                serverSide: tableConfig.koreksid.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'koreksid';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.koreksid.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.koreksid.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableKoreksiD.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableMutasiH = $('#table-mutasih').DataTable({
                processing: tableConfig.mutasih.processing,
                serverSide: tableConfig.mutasih.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'mutasih';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.mutasih.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.mutasih.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableMutasiH.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableMutasiD = $('#table-mutasid').DataTable({
                processing: tableConfig.mutasid.processing,
                serverSide: tableConfig.mutasid.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'mutasid';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.mutasid.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.mutasid.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableMutasiD.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableSaldoHutang = $('#table-saldohutang').DataTable({
                processing: tableConfig.saldohutang.processing,
                serverSide: tableConfig.saldohutang.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'saldohutang';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.saldohutang.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.saldohutang.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableSaldoHutang.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            tableSaldoPiutang = $('#table-saldopiutang').DataTable({
                processing: tableConfig.saldopiutang.processing,
                serverSide: tableConfig.saldopiutang.serverSide,
                ajax: {
                    url: "{{ route('migration.getdata') }}",
                    type: "GET",
                    data: function(d) {
                        d.periode = $('#filter_periode').val();
                        d.tipe = 'saldopiutang';
                        return d;
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: tableConfig.saldopiutang.columns,
                columnDefs: [
                    { targets: '_all', className: 'dt-head-nowrap dt-body-nowrap' }
                ],
                pageLength: tableConfig.saldopiutang.pageLength,
                language: {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "infoEmpty": "",
                    "infoFiltered": "",
                    "processing": '<div class="dt-processing-container"><div class="dt-processing-spinner"></div><div class="dt-processing-text">Sedang memproses...</div></div>'
                },
                initComplete: function() {
                    this.api().columns.adjust().draw();
                    // Tambahkan event listener untuk window resize
                    $(window).on('resize', function() {
                        tableSaldoPiutang.columns.adjust();
                    });
                },
                preDrawCallback: function() {
                    // Tambahkan overlay sebelum tabel di-render
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                    if (!$('.dt-processing-overlay').length) {
                        $('body').append(
                            '<div class="dt-processing-overlay" style="display:none;"></div>');
                    }
                },
                drawCallback: function() {
                    // Hapus overlay setelah tabel selesai di-render
                    $('.dt-processing-overlay').remove();

                    this.api().columns.adjust();
                    // Tambahkan tooltip untuk sel yang terpotong
                    $('table.dataTable tbody td').each(function() {
                        if(this.offsetWidth < this.scrollWidth) {
                            $(this).attr('title', $(this).text());
                        }
                    });
                }
            });

            // generate thead from tableConfig
            function generateThead(tableConfig) {
                var theadHtml = '<thead><tr>';
                $.each(tableConfig.columns, function(index, column) {
                    theadHtml += '<th>' + column.name + '</th>';
                });
                theadHtml += '</tr></thead>';
                return theadHtml;
            }

            function activateTab(tabId) {
                var tabEl = document.querySelector(tabId);
                var tab = new bootstrap.Tab(tabEl);
                tab.show();
            }

            $('#btn-filter').on('click', function() {
                var filterTarget = $('#inputGroupFilter').val();
                var selectedPeriode = $('#filter_periode').val();

                $(this).prop('disabled', true);

                function showSuccessToast(message) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(message);
                    } else {
                        alert(message);
                    }

                    $('#btn-filter').prop('disabled', false);
                }

                if (filterTarget === 'all') {
                    var reloadCounter = 0;
                    var totalTables = 21; // Jumlah tabel yang akan di-reload
                    function checkAllTablesLoaded() {
                        reloadCounter++;
                        console.log(reloadCounter);
                        if (reloadCounter >= totalTables) {
                            showSuccessToast('Semua data berhasil difilter berdasarkan periode: ' +
                                selectedPeriode);
                            $(this).prop('disabled', false);
                        }
                    }
                    swal({
                        title: "Are you sure?",
                        text: "Semua data akan di-load berdasarkan periode: " + selectedPeriode +" dan akan membutuhkan sedikit waktu.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willFilter) => {
                        if (willFilter) {
                            toastr.info('Proses filtering data, mohon menunggu...');
                            tablePelunasanHutang.ajax.reload(checkAllTablesLoaded, false);
                            tablePelunasanHutangDetail.ajax.reload(checkAllTablesLoaded, false);
                            tablePelunasanPiutang.ajax.reload(checkAllTablesLoaded, false);
                            tablePelunasanPiutangDetail.ajax.reload(checkAllTablesLoaded, false);
                            tableBank.ajax.reload(checkAllTablesLoaded, false);
                            tableKas.ajax.reload(checkAllTablesLoaded, false);
                            tableJurnalMemo.ajax.reload(checkAllTablesLoaded, false);
                            tableApCnDn.ajax.reload(checkAllTablesLoaded, false);
                            tableArCnDn.ajax.reload(checkAllTablesLoaded, false);
                            tableTagihanKlaim.ajax.reload(checkAllTablesLoaded, false);
                            tablePembayaranKlaim.ajax.reload(checkAllTablesLoaded, false);
                            tablePembayaranPphKlaim.ajax.reload(checkAllTablesLoaded, false);
                            tableSaldoAwalKlaim.ajax.reload(checkAllTablesLoaded, false);
                            tableMApH.ajax.reload(checkAllTablesLoaded, false);
                            tableMApD.ajax.reload(checkAllTablesLoaded, false);
                            tableMArH.ajax.reload(checkAllTablesLoaded, false);
                            tableMArD.ajax.reload(checkAllTablesLoaded, false);
                            tableMbeliH.ajax.reload(checkAllTablesLoaded, false);
                            tableMbeliD.ajax.reload(checkAllTablesLoaded, false);
                            tablePenjualanH.ajax.reload(checkAllTablesLoaded, false);
                            tablePenjualanD.ajax.reload(checkAllTablesLoaded, false);
                            tableKoreksiH.ajax.reload(checkAllTablesLoaded, false);
                            tableKoreksiD.ajax.reload(checkAllTablesLoaded, false);
                            tableMutasiH.ajax.reload(checkAllTablesLoaded, false);
                            tableMutasiD.ajax.reload(checkAllTablesLoaded, false);
                            tableSaldoHutang.ajax.reload(checkAllTablesLoaded, false);
                            tableSaldoPiutang.ajax.reload(checkAllTablesLoaded, false);
                        } else {
                            $(this).prop('disabled', false);
                            return;
                        }
                    });
                } else if (filterTarget === 'pelunasanhutang') {
                    activateTab('#tab-0');
                    tablePelunasanHutang.ajax.reload(function() {
                        showSuccessToast(
                            'Data Pelunasan Hutang berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'pelunasanhutangd') {
                    activateTab('#tab-1');
                    tablePelunasanHutangDetail.ajax.reload(function() {
                        showSuccessToast(
                            'Data Pelunasan Hutang Detail berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'pelunasanpiutang') {
                    activateTab('#tab-2');
                    tablePelunasanPiutang.ajax.reload(function() {
                        showSuccessToast(
                            'Data Pelunasan Piutang berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'pelunasanpiutangd') {
                    activateTab('#tab-3');
                    tablePelunasanPiutangDetail.ajax.reload(function() {
                        showSuccessToast(
                            'Data Pelunasan Piutang Detail berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'bank') {
                    activateTab('#tab-4');
                    tableBank.ajax.reload(function() {
                        showSuccessToast(
                            'Data Expense Bank berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'kas') {
                    activateTab('#tab-5');
                    tableKas.ajax.reload(function() {
                        showSuccessToast(
                            'Data Expense Kas berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'jurnalmemo') {
                    activateTab('#tab-6');
                    tableJurnalMemo.ajax.reload(function() {
                        showSuccessToast(
                            'Data Expense Jurnal Memo berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'apcndn') {
                    activateTab('#tab-7');
                    tableApCnDn.ajax.reload(function() {
                        showSuccessToast(
                            'Data Expense AP CN/DN berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'arcndn') {
                    activateTab('#tab-8');
                    tableArCnDn.ajax.reload(function() {
                        showSuccessToast(
                            'Data Expense AR CN/DN berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'tagihanklaim') {
                    activateTab('#tab-9');
                    tableTagihanKlaim.ajax.reload(function() {
                        showSuccessToast(
                            'Data Tagihan Klaim berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'pembayaranklaim') {
                    activateTab('#tab-10');
                    tablePembayaranKlaim.ajax.reload(function() {
                        showSuccessToast(
                            'Data Pembayaran Kalim berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'pembayaranpphklaim') {
                    activateTab('#tab-11');
                    tablePembayaranPphKlaim.ajax.reload(function() {
                        showSuccessToast(
                            'Data Pembayaran PPH Klaim berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'saldoawalklaim') {
                    activateTab('#tab-12');
                    tableSaldoAwalKlaim.ajax.reload(function() {
                        showSuccessToast(
                            'Data Saldo Awal Klaim berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'maph') {
                    activateTab('#tab-13');
                    tableMApH.ajax.reload(function() {
                        showSuccessToast(
                            'Data MAp Header berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'mapd') {
                    activateTab('#tab-14');
                    tableMApD.ajax.reload(function() {
                        showSuccessToast(
                            'Data MAp Detail berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'marh') {
                    activateTab('#tab-15');
                    tableMArH.ajax.reload(function() {
                        showSuccessToast(
                            'Data MAr Header berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'mard') {
                    activateTab('#tab-16');
                    tableMArD.ajax.reload(function() {
                        showSuccessToast(
                            'Data MAr Detail berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'mbelih') {
                    activateTab('#tab-17');
                    tableMbeliH.ajax.reload(function() {
                        showSuccessToast(
                            'Data Mbeli Header berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'mbelid') {
                    activateTab('#tab-18');
                    tableMbeliD.ajax.reload(function() {
                        showSuccessToast(
                            'Data Mbeli Detail berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'penjualanh') {
                    activateTab('#tab-19');
                    tablePenjualanH.ajax.reload(function() {
                        showSuccessToast(
                            'Data Penjualan Header berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'penjualand') {
                    activateTab('#tab-20');
                    tablePenjualanD.ajax.reload(function() {
                        showSuccessToast(
                            'Data Penjualan Detail berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'koreksih') {
                    activateTab('#tab-21');
                    tableKoreksiH.ajax.reload(function() {
                        showSuccessToast(
                            'Data Koreksi Header berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'koreksid') {
                    activateTab('#tab-22');
                    tableKoreksiD.ajax.reload(function() {
                        showSuccessToast(
                            'Data Koreksi Detail berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'mutasih') {
                    activateTab('#tab-23');
                    tableMutasiH.ajax.reload(function() {
                        showSuccessToast(
                            'Data Mutasi Header berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'mutasid') {
                    activateTab('#tab-24');
                    tableMutasiD.ajax.reload(function() {
                        showSuccessToast(
                            'Data Mutasi Detail berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'saldohutang') {
                    activateTab('#tab-25');
                    tableSaldoHutang.ajax.reload(function() {
                        showSuccessToast(
                            'Data Saldo Hutang berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                } else if (filterTarget === 'saldopiutang') {
                    activateTab('#tab-25');
                    tableSaldoPiutang.ajax.reload(function() {
                        showSuccessToast(
                            'Data Saldo Piutang berhasil difilter berdasarkan periode: ' +
                            selectedPeriode);
                    }, false);
                }
            });

            $('#btn-download').on('click', function() {
                var filterTarget = $('#inputGroupFilter').val();
                var selectedPeriode = $('#filter_periode').val();

                $(this).prop('disabled', true);

                var dates = selectedPeriode.split(' - ');
                var startDate = moment(dates[0], 'MM/DD/YYYY').format('YYYY-MM-DD');
                var endDate = moment(dates[1], 'MM/DD/YYYY').format('YYYY-MM-DD');

                var downloadType = filterTarget === 'all' ? 'pelunasanhutang' : filterTarget;

                if (filterTarget === 'all') {
                    toastr.warning('Pilih salah satu tabel untuk download data.', 'Peringatan');
                    $('#btn-download').prop('disabled', false);
                    return;
                }

                toastr.info('Mempersiapkan download...', 'Mohon tunggu');

                // Menggunakan AJAX untuk mendeteksi keberhasilan download
                $.ajax({
                    url: "{{ route('migration.downloadData') }}",
                    type: 'GET',
                    data: {
                        tipe: downloadType,
                        startDate: startDate,
                        endDate: endDate
                    },
                    xhrFields: {
                        responseType: 'blob' // Menerima response sebagai blob
                    },
                    success: function(blob, status, xhr) {
                        // Get filename from the Content-Disposition header if available
                        var filename;
                        var disposition = xhr.getResponseHeader('Content-Disposition');

                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);
                            if (matches != null && matches[1]) {
                                filename = matches[1].replace(/['"]/g, '');
                            }
                        }

                        // If filename not found in header, use default
                        if (!filename) {
                            filename = downloadType + '_' + startDate + '_' + endDate + '.xlsx';
                        }

                        // Create a URL for the blob
                        var url = window.URL.createObjectURL(blob);

                        // Create an anchor element for download
                        var a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        a.download = filename;

                        // Add to DOM, click, and remove
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);
                        // Tampilkan notifikasi sukses
                        toastr.success('File berhasil didownload', 'Berhasil');
                        $('#btn-download').prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan error
                        toastr.error('Gagal mendownload file: ' + error, 'Error');
                        $('#btn-download').prop('disabled', false);
                    }
                });
            });


            $(document).on('processing.dt', function(e, settings, processing) {
                if (processing) {
                    $('.dt-processing-overlay').show();
                } else {
                    $('.dt-processing-overlay').hide();
                }
            });

            function fixDoubleHeader() {
                if ($('.dataTables_scrollHead table.dataTable thead tr').length > 1) {
                    $('.dataTables_scrollHead table.dataTable thead tr:nth-child(2)').hide();
                }
            }

            tablePelunasanHutang.on('draw.dt', function() {
                fixDoubleHeader();
            });

            $(document).ready(function() {
                setTimeout(fixDoubleHeader, 100);
            });


            $(function() {
                $('input[name="filter_periode"]').daterangepicker({
                    opens: 'left',
                    minDate: moment('2024-01-01'),
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') +
                        ' to ' + end
                        .format('YYYY-MM-DD'));
                });
            });
        });
    </script>
@endsection
