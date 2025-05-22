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
                        </ul>
                        <div class="tab-content pt-5" id="tab-content">
                            <div class="tab-pane active" id="tabpanel-pelunasanhutang" role="tabpanel"
                                aria-labelledby="tabpanel-pelunasanhutang">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="table-pelunasanhutang">
                                        <thead>
                                            <tr>
                                                <th>Tgl</th>
                                                <th>NoBukti</th>
                                                <th>NoBuktiRef</th>
                                                <th>NoBuktiFAS</th>
                                                <th>PT</th>
                                                <th>NamaPT</th>
                                                <th>PRINCIPLE</th>
                                                <th>NamaPrinciple</th>
                                                <th>DEPO</th>
                                                <th>NamaDepo</th>
                                                <th>KodeArea</th>
                                                <th>NamaArea</th>
                                                <th>KodeDivisi</th>
                                                <th>NamaDivisi</th>
                                                <th>KodePemasok</th>
                                                <th>NamaPemasok</th>
                                                <th>NoFaktur</th>
                                                <th>TglFaktur</th>
                                                <th>NominalPelunasan</th>
                                                <th>Jenis</th>
                                                <th>NoAkun</th>
                                                <th>NamaAkun</th>
                                                <th>NoAkunLawan</th>
                                                <th>NamaAkunLawan</th>
                                                <th>NoAkunLengkap</th>
                                                <th>NoAkunLawanLengkap</th>
                                            </tr>
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
                                            <tr>
                                                <th>NoBukti</th>
                                                <th>NoInvoice</th>
                                                <th>NominalPelunasan</th>
                                            </tr>
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
                                            <tr>
                                                <th>Tgl</th>
                                                <th>NoBukti</th>
                                                <th>NoBuktiRef</th>
                                                <th>NoBuktiFAS</th>
                                                <th>PT</th>
                                                <th>NamaPT</th>
                                                <th>PRINCIPLE</th>
                                                <th>NamaPrinciple</th>
                                                <th>DEPO</th>
                                                <th>NamaDepo</th>
                                                <th>KodeArea</th>
                                                <th>NamaArea</th>
                                                <th>KodeDivisi</th>
                                                <th>NamaDivisi</th>
                                                <th>KodePemasok</th>
                                                <th>NamaPemasok</th>
                                                <th>NoFaktur</th>
                                                <th>TglFaktur</th>
                                                <th>NominalPelunasan</th>
                                                <th>Jenis</th>
                                                <th>NoAkun</th>
                                                <th>NamaAkun</th>
                                                <th>NoAkunLawan</th>
                                                <th>NamaAkunLawan</th>
                                                <th>NoAkunLengkap</th>
                                                <th>NoAkunLawanLengkap</th>
                                            </tr>
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
                                            <tr>
                                                <th>NoBukti</th>
                                                <th>NoInvoice</th>
                                                <th>NominalPelunasan</th>
                                            </tr>
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
                                            <tr>
                                                <th>Tgl</th>
                                                <th>NoBukti</th>
                                                <th>NomorRecord</th>
                                                <th>NomorKitir</th>
                                                <th>PT</th>
                                                <th>NamaPT</th>
                                                <th>PRINCIPLE</th>
                                                <th>NamaPrinciple</th>
                                                <th>DEPO</th>
                                                <th>NamaDepo</th>
                                                <th>KodeArea</th>
                                                <th>NamaArea</th>
                                                <th>KodeDivisi</th>
                                                <th>NamaDivisi</th>
                                                <th>NomorRekening</th>
                                                <th>Kategori</th>
                                                <th>NoAkunBank</th>
                                                <th>NamaAkunBank</th>
                                                <th>NoAkunLawan</th>
                                                <th>NamaAkunLawan</th>
                                                <th>Jenis(Keluar/Masuk)</th>
                                                <th>Keterangan</th>
                                                <th>Nilai</th>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                                <th>NoAkunBankLengkap</th>
                                                <th>NoAkunLawanLengkap</th>
                                            </tr>
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
                                            <tr>
                                                <th>Tgl</th>
                                                <th>NoBukti</th>
                                                <th>NoBuktiRef</th>
                                                <th>PT</th>
                                                <th>NamaPT</th>
                                                <th>PRINCIPLE</th>
                                                <th>NamaPrinciple</th>
                                                <th>DEPO</th>
                                                <th>NamaDepo</th>
                                                <th>KodeArea</th>
                                                <th>NamaArea</th>
                                                <th>KodeDivisi</th>
                                                <th>NamaDivisi</th>
                                                <th>NoRekeningBank</th>
                                                <th>Kategori</th>
                                                <th>NoAkunBank</th>
                                                <th>NamaAkunBank</th>
                                                <th>NoAkunLawan</th>
                                                <th>NamaAkunLawan</th>
                                                <th>Jenis(Keluar/Masuk)</th>
                                                <th>Keterangan</th>
                                                <th>Nilai</th>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                                <th>NoAkunBankLengkap</th>
                                                <th>NoAkunLawanLengkap</th>
                                            </tr>
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
                                            <tr>
                                                <th>Tgl</th>
                                                <th>NoBukti</th>
                                                <th>NoRef</th>
                                                <th>PT</th>
                                                <th>NamaPT</th>
                                                <th>PRINCIPLE</th>
                                                <th>NamaPrinciple</th>
                                                <th>DEPO</th>
                                                <th>NamaDepo</th>
                                                <th>KodeArea</th>
                                                <th>NamaArea</th>
                                                <th>KodeDivisi</th>
                                                <th>NamaDivisi</th>
                                                <th>Kategori</th>
                                                <th>NoAkun</th>
                                                <th>NamaAkun</th>
                                                <th>Keterangan</th>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                                <th>NoAkunLengkap</th>
                                            </tr>
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
                                            <tr>
                                                <th>Tgl</th>
                                                <th>NoBukti</th>
                                                <th>NoBuktiFAS</th>
                                                <th>PT</th>
                                                <th>NamaPT</th>
                                                <th>PRINCIPLE</th>
                                                <th>NamaPrinciple</th>
                                                <th>DEPO</th>
                                                <th>NamaDepo</th>
                                                <th>KodeArea</th>
                                                <th>NamaArea</th>
                                                <th>KodeDivisi</th>
                                                <th>NamaDivisi</th>
                                                <th>KodePemasok</th>
                                                <th>NamaPemasok</th>
                                                <th>NoFaktur</th>
                                                <th>TglFaktur</th>
                                                <th>Nilai</th>
                                                <th>Jenis</th>
                                                <th>NoAkun</th>
                                                <th>NamaAkun</th>
                                                <th>NoAkunLawan</th>
                                                <th>NamaAkunLawan</th>
                                                <th>Jenis(Keluar/Masuk)</th>
                                                <th>NoAkunLengkap</th>
                                                <th>NoAkunLawanLengkap</th>
                                            </tr>
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
                                            <tr>
                                                <th>Tgl</th>
                                                <th>NoBukti</th>
                                                <th>NoBuktiFAS</th>
                                                <th>PT</th>
                                                <th>NamaPT</th>
                                                <th>PRINCIPLE</th>
                                                <th>NamaPrinciple</th>
                                                <th>DEPO</th>
                                                <th>NamaDepo</th>
                                                <th>KodeArea</th>
                                                <th>NamaArea</th>
                                                <th>KodeCustomer</th>
                                                <th>NamaCustomer</th>
                                                <th>NoFaktur</th>
                                                <th>TglFaktur</th>
                                                <th>Nilai</th>
                                                <th>Jenis</th>
                                                <th>NoAkun</th>
                                                <th>NamaAkun</th>
                                                <th>NoAkunLawan</th>
                                                <th>NamaAkunLawan</th>
                                                <th>Jenis(Keluar/Masuk)</th>
                                                <th>NoAkunLengkap</th>
                                                <th>NoAkunLawanLengkap</th>
                                            </tr>
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
                                            <tr>
                                                <th>NOBUKTI</th>
                                                <th>PRINCIPAL</th>
                                                <th>NAMA_PRINCIPAL</th>
                                                <th>DEPO</th>
                                                <th>NAMA_DEPO</th>
                                                <th>AREA</th>
                                                <th>NAMA_AREA</th>
                                                <th>DIVISI</th>
                                                <th>NAMA_DIVISI</th>
                                                <th>KATEGORI</th>
                                                <th>TYPE</th>
                                                <th>JENIS KLAIM</th>
                                                <th>NAMA KLAIM</th>
                                                <th>NO PROGRAM</th>
                                                <th>PERIODE MULAI</th>
                                                <th>PERIODE AKHIR</th>
                                                <th>TGL PIUTANG KLAIM</th>
                                                <th>TGL KIRIM KLAIM</th>
                                                <th>NO KWITANSI</th>
                                                <th>DPP</th>
                                                <th>PPN</th>
                                                <th>NILAI KLAIM</th>
                                                <th>NO AKUN NILAI KLAIM</th>
                                                <th>NO AKUN PPN KLAIM</th>
                                                <th>NO AKUN DPP</th>
                                                <th>AkunNilaiKlaim</th>
                                                <th>AkunPpnKlaim</th>
                                                <th>AkunDppKlaim</th>
                                                <th>Nilai</th>
                                            </tr>
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
                                            <tr>
                                                <th>NOBUKTI</th>
                                                <th>PRINCIPAL</th>
                                                <th>NAMA_PRINCIPAL</th>
                                                <th>DEPO</th>
                                                <th>NAMA_DEPO</th>
                                                <th>AREA</th>
                                                <th>NAMA_AREA</th>
                                                <th>DIVISI</th>
                                                <th>NAMA_DIVISI</th>
                                                <th>KATEGORI</th>
                                                <th>TYPE</th>
                                                <th>JENIS KLAIM</th>
                                                <th>NAMA KLAIM</th>
                                                <th>NO PROGRAM</th>
                                                <th>PERIODE MULAI</th>
                                                <th>PERIODE AKHIR</th>
                                                <th>TGL KIRIM KLAIM</th>
                                                <th>NO KWITANSI</th>
                                                <th>TGL BAYAR</th>
                                                <th>KET BAYAR</th>
                                                <th>DPP</th>
                                                <th>PPN</th>
                                                <th>NILAI KLAIM</th>
                                                <th>TOTAL BAYAR</th>
                                                <th>NoAkunBank</th>
                                                <th>NamaAkunBank</th>
                                                <th>NoAkunLawan</th>
                                                <th>NamaAkunLawan</th>
                                                <th>Jenis(Keluar/Masuk)</th>
                                                <th>NoAkunBankLengkap</th>
                                                <th>NoAkunLawanLengkap</th>
                                                <th>Nilai</th>
                                            </tr>
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
                                            <tr>
                                                <th>NOBUKTI</th>
                                                <th>PRINCIPAL</th>
                                                <th>NAMA_PRINCIPAL</th>
                                                <th>DEPO</th>
                                                <th>NAMA_DEPO</th>
                                                <th>AREA</th>
                                                <th>NAMA_AREA</th>
                                                <th>DIVISI</th>
                                                <th>NAMA_DIVISI</th>
                                                <th>KATEGORI</th>
                                                <th>TYPE</th>
                                                <th>JENIS KLAIM</th>
                                                <th>NAMA KLAIM</th>
                                                <th>NO PROGRAM</th>
                                                <th>PERIODE MULAI</th>
                                                <th>PERIODE AKHIR</th>
                                                <th>TGL KIRIM KLAIM</th>
                                                <th>NO KWITANSI</th>
                                                <th>TGL BAYAR</th>
                                                <th>KET BAYAR</th>
                                                <th>DPP</th>
                                                <th>PPN</th>
                                                <th>NILAI KLAIM</th>
                                                <th>PENERIMAAN PPH</th>
                                                <th>NoAkunBank</th>
                                                <th>NamaAkunBank</th>
                                                <th>NoAkunLawan</th>
                                                <th>NamaAkunLawan</th>
                                                <th>Jenis(Keluar/Masuk)</th>
                                                <th>NoAkunBankLengkap</th>
                                                <th>NoAkunLawanLengkap</th>
                                                <th>Nilai</th>
                                            </tr>
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
                                            <tr>
                                                <th>PRINCIPAL</th>
                                                <th>NAMA_PRINCIPAL</th>
                                                <th>DEPO</th>
                                                <th>NAMA_DEPO</th>
                                                <th>AREA</th>
                                                <th>NAMA_AREA</th>
                                                <th>DIVISI</th>
                                                <th>NAMA_DIVISI</th>
                                                <th>KATEGORI</th>
                                                <th>TYPE</th>
                                                <th>JENIS KLAIM</th>
                                                <th>NAMA KLAIM</th>
                                                <th>NO PROGRAM</th>
                                                <th>PERIODE MULAI</th>
                                                <th>PERIODE AKHIR</th>
                                                <th>SELISIH</th>
                                                <th>NOAKUN</th>
                                                <th>NAMAAKUN</th>
                                                <th>Nilai</th>
                                                <th>NoAkunLengkap</th>
                                            </tr>
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
            tableSaldoAwalKlaim;

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
                columns: [
                    { data: 'Tgl', name: 'Tgl', className: 'column-md' },
                    { data: 'NoBukti', name: 'NoBukti', className: 'column-md' },
                    { data: 'NoBuktiRef', name: 'NoBuktiRef', className: 'column-md' },
                    { data: 'NoBuktiFAS', name: 'NoBuktiFAS', className: 'column-md' },
                    { data: 'PT', name: 'PT', className: 'column-sm' },
                    { data: 'NamaPT', name: 'NamaPT', className: 'column-lg' },
                    { data: 'PRINCIPLE', name: 'PRINCIPLE', className: 'column-sm' },
                    { data: 'NamaPrinciple', name: 'NamaPrinciple', className: 'column-lg' },
                    { data: 'DEPO', name: 'DEPO', className: 'column-sm' },
                    { data: 'NamaDepo', name: 'NamaDepo', className: 'column-lg' },
                    { data: 'KodeArea', name: 'KodeArea', className: 'column-sm' },
                    { data: 'NamaArea', name: 'NamaArea', className: 'column-md' },
                    { data: 'KodeDivisi', name: 'KodeDivisi', className: 'column-sm' },
                    { data: 'NamaDivisi', name: 'NamaDivisi', className: 'column-md' },
                    { data: 'KodePemasok', name: 'KodePemasok', className: 'column-md' },
                    { data: 'NamaPemasok', name: 'NamaPemasok', className: 'column-lg' },
                    { data: 'NoFaktur', name: 'NoFaktur', className: 'column-md' },
                    { data: 'TglFaktur', name: 'TglFaktur', className: 'column-md' },
                    { data: 'NominalPelunasan', name: 'NominalPelunasan', className: 'column-md' },
                    { data: 'Jenis', name: 'Jenis', className: 'column-sm' },
                    { data: 'NoAkun', name: 'NoAkun', className: 'column-md' },
                    { data: 'NamaAkun', name: 'NamaAkun', className: 'column-lg' },
                    { data: 'NoAkunLawan', name: 'NoAkunLawan', className: 'column-md' },
                    { data: 'NamaAkunLawan', name: 'NamaAkunLawan', className: 'column-lg' },
                    { data: 'NoAkunLengkap', name: 'NoAkunLengkap', className: 'column-lg' },
                    { data: 'NoAkunLawanLengkap', name: 'NoAkunLawanLengkap', className: 'column-lg' },
                ],
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
                columns: [{
                        data: 'NoBukti',
                        name: 'NoBukti'
                    },
                    {
                        data: 'NoInvoice',
                        name: 'NoInvoice'
                    },
                    {
                        data: 'NominalPelunasan',
                        name: 'NominalPelunasan'
                    },
                ],
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
                columns: [
                    { data: 'Tgl', name: 'Tgl', className: 'column-md' },
                    { data: 'NoBukti', name: 'NoBukti', className: 'column-lg' },
                    { data: 'NoBuktiRef', name: 'NoBuktiRef', className: 'column-lg' },
                    { data: 'NoBuktiFAS', name: 'NoBuktiFAS', className: 'column-lg' },
                    { data: 'PT', name: 'PT', className: 'column-sm' },
                    { data: 'NamaPT', name: 'NamaPT', className: 'column-lg' },
                    { data: 'PRINCIPLE', name: 'PRINCIPLE', className: 'column-sm' },
                    { data: 'NamaPrinciple', name: 'NamaPrinciple', className: 'column-lg' },
                    { data: 'DEPO', name: 'DEPO', className: 'column-sm' },
                    { data: 'NamaDepo', name: 'NamaDepo', className: 'column-lg' },
                    { data: 'KodeArea', name: 'KodeArea', className: 'column-sm' },
                    { data: 'NamaArea', name: 'NamaArea', className: 'column-md' },
                    { data: 'KodeDivisi', name: 'KodeDivisi', className: 'column-sm' },
                    { data: 'NamaDivisi', name: 'NamaDivisi', className: 'column-md' },
                    { data: 'KodeCustomer', name: 'KodeCustomer', className: 'column-lg' },
                    { data: 'NamaCustomer', name: 'NamaCustomer', className: 'column-lg' },
                    { data: 'NoFaktur', name: 'NoFaktur', className: 'column-md' },
                    { data: 'TglFaktur', name: 'TglFaktur', className: 'column-md' },
                    { data: 'NominalPelunasan', name: 'NominalPelunasan', className: 'column-md' },
                    { data: 'Jenis', name: 'Jenis', className: 'column-sm' },
                    { data: 'NoAkun', name: 'NoAkun', className: 'column-md' },
                    { data: 'NamaAkun', name: 'NamaAkun', className: 'column-lg' },
                    { data: 'NoAkunLawan', name: 'NoAkunLawan', className: 'column-md' },
                    { data: 'NamaAkunLawan', name: 'NamaAkunLawan', className: 'column-lg' },
                    { data: 'NoAkunLengkap', name: 'NoAkunLengkap', className: 'column-lg' },
                    { data: 'NoAkunLawanLengkap', name: 'NoAkunLawanLengkap', className: 'column-lg' },
                ],
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
                columns: [{
                        data: 'NoBukti',
                        name: 'NoBukti'
                    },
                    {
                        data: 'NoInvoice',
                        name: 'NoInvoice'
                    },
                    {
                        data: 'NominalPelunasan',
                        name: 'NominalPelunasan'
                    },
                ],
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
                columns: [
                    { data: 'Tgl', name: 'Tgl', className: 'column-md' },
                    {
                        data: 'NoBukti', name: 'NoBukti', className: 'column-md',
                        render: function(data, type, row) {
                            return data ? data.toString() : '';
                        }
                    },
                    { data: 'NomorRecord', name: 'NomorRecord', className: 'column-md' },
                    { data: 'NomorKitir', name: 'NomorKitir', className: 'column-md' },
                    { data: 'PT', name: 'PT', className: 'column-sm' },
                    { data: 'NamaPT', name: 'NamaPT', className: 'column-lg' },
                    { data: 'PRINCIPLE', name: 'PRINCIPLE', className: 'column-sm' },
                    { data: 'NamaPrinciple', name: 'NamaPrinciple', className: 'column-lg' },
                    { data: 'DEPO', name: 'DEPO', className: 'column-sm' },
                    { data: 'NamaDepo', name: 'NamaDepo', className: 'column-lg' },
                    { data: 'KodeArea', name: 'KodeArea', className: 'column-sm' },
                    { data: 'NamaArea', name: 'NamaArea', className: 'column-md' },
                    { data: 'KodeDivisi', name: 'KodeDivisi', className: 'column-sm' },
                    { data: 'NamaDivisi', name: 'NamaDivisi', className: 'column-md' },
                    { data: 'NomorRekening', name: 'NomorRekening', className: 'column-md' },
                    { data: 'Kategori', name: 'Kategori', className: 'column-sm' },
                    { data: 'NoAkunBank', name: 'NoAkunBank', className: 'column-md' },
                    { data: 'NamaAkunBank', name: 'NamaAkunBank', className: 'column-md' },
                    { data: 'NoAkunLawan', name: 'NoAkunLawan', className: 'column-md' },
                    { data: 'NamaAkunLawan', name: 'NamaAkunLawan', className: 'column-sm' },
                    { data: 'Jenis(Keluar/Masuk)', name: 'Jenis(Keluar/Masuk)', className: 'column-md' },
                    { data: 'Keterangan', name: 'Keterangan', className: 'column-lg' },
                    { data: 'Nilai', name: 'Nilai', className: 'column-md' },
                    { data: 'Debet', name: 'Debet', className: 'column-sm' },
                    { data: 'Kredit', name: 'Kredit', className: 'column-sm' },
                    { data: 'NoAkunBankLengkap', name: 'NoAkunBankLengkap', className: 'column-lg' },
                    { data: 'NoAkunLawanLengkap', name: 'NoAkunLawanLengkap', className: 'column-lg' },
                ],
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
                columns: [
                    { data: 'Tgl', name: 'Tgl', className: 'column-md' },
                    {
                        data: 'NoBukti', name: 'NoBukti', className: 'column-md',
                        render: function(data, type, row) {
                            return data ? data.toString() : '';
                        }
                    },
                    { data: 'NoBuktiRef', name: 'NoBuktiRef', className: 'column-md' },
                    { data: 'PT', name: 'PT', className: 'column-sm' },
                    { data: 'NamaPT', name: 'NamaPT', className: 'column-lg' },
                    { data: 'PRINCIPLE', name: 'PRINCIPLE', className: 'column-sm' },
                    { data: 'NamaPrinciple', name: 'NamaPrinciple', className: 'column-lg' },
                    { data: 'DEPO', name: 'DEPO', className: 'column-sm' },
                    { data: 'NamaDepo', name: 'NamaDepo', className: 'column-lg' },
                    { data: 'KodeArea', name: 'KodeArea', className: 'column-sm' },
                    { data: 'NamaArea', name: 'NamaArea', className: 'column-md' },
                    { data: 'KodeDivisi', name: 'KodeDivisi', className: 'column-sm' },
                    { data: 'NamaDivisi', name: 'NamaDivisi', className: 'column-md' },
                    { data: 'NoRekeningBank', name: 'NoRekeningBank', className: 'column-md' },
                    { data: 'Kategori', name: 'Kategori', className: 'column-sm' },
                    { data: 'NoAkunBank', name: 'NoAkunBank', className: 'column-md' },
                    { data: 'NamaAkunBank', name: 'NamaAkunBank', className: 'column-md' },
                    { data: 'NoAkunLawan', name: 'NoAkunLawan', className: 'column-md' },
                    { data: 'NamaAkunLawan', name: 'NamaAkunLawan', className: 'column-sm' },
                    { data: 'Jenis(Keluar/Masuk)', name: 'Jenis(Keluar/Masuk)', className: 'column-md' },
                    { data: 'Keterangan', name: 'Keterangan', className: 'column-lg' },
                    { data: 'Nilai', name: 'Nilai', className: 'column-md' },
                    { data: 'Debet', name: 'Debet', className: 'column-sm' },
                    { data: 'Kredit', name: 'Kredit', className: 'column-sm' },
                    { data: 'NoAkunBankLengkap', name: 'NoAkunBankLengkap', className: 'column-lg' },
                    { data: 'NoAkunLawanLengkap', name: 'NoAkunLawanLengkap', className: 'column-lg' },
                ],
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
                columns: [
                    { data: 'Tgl', name: 'Tgl', className: 'column-md' },
                    {
                        data: 'NoBukti', name: 'NoBukti', className: 'column-md',
                        render: function(data, type, row) {
                            return data ? data.toString() : '';
                        }
                    },
                    { data: 'NoRef', name: 'NoRef', className: 'column-md' },
                    { data: 'PT', name: 'PT', className: 'column-sm' },
                    { data: 'NamaPT', name: 'NamaPT', className: 'column-lg' },
                    { data: 'PRINCIPLE', name: 'PRINCIPLE', className: 'column-sm' },
                    { data: 'NamaPrinciple', name: 'NamaPrinciple', className: 'column-lg' },
                    { data: 'DEPO', name: 'DEPO', className: 'column-sm' },
                    { data: 'NamaDepo', name: 'NamaDepo', className: 'column-lg' },
                    { data: 'KodeArea', name: 'KodeArea', className: 'column-sm' },
                    { data: 'NamaArea', name: 'NamaArea', className: 'column-md' },
                    { data: 'KodeDivisi', name: 'KodeDivisi', className: 'column-sm' },
                    { data: 'NamaDivisi', name: 'NamaDivisi', className: 'column-md' },
                    { data: 'Kategori', name: 'Kategori', className: 'column-sm' },
                    { data: 'NoAkun', name: 'NoAkun', className: 'column-md' },
                    { data: 'NamaAkun', name: 'NamaAkun', className: 'column-md' },
                    { data: 'Keterangan', name: 'Keterangan', className: 'column-lg' },
                    { data: 'Debet', name: 'Debet', className: 'column-sm' },
                    { data: 'Kredit', name: 'Kredit', className: 'column-sm' },
                    { data: 'NoAkunLengkap', name: 'NoAkunLengkap', className: 'column-lg' },
                ],
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
                columns: [
                    { data: 'Tgl', name: 'Tgl', className: 'column-md' },
                    { data: 'NoBukti', name: 'NoBukti', className: 'column-lg' },
                    { data: 'NoBuktiFAS', name: 'NoBuktiFAS', className: 'column-md' },
                    { data: 'PT', name: 'PT', className: 'column-sm' },
                    { data: 'NamaPT', name: 'NamaPT', className: 'column-lg' },
                    { data: 'PRINCIPLE', name: 'PRINCIPLE', className: 'column-sm' },
                    { data: 'NamaPrinciple', name: 'NamaPrinciple', className: 'column-lg' },
                    { data: 'DEPO', name: 'DEPO', className: 'column-sm' },
                    { data: 'NamaDepo', name: 'NamaDepo', className: 'column-lg' },
                    { data: 'KodeArea', name: 'KodeArea', className: 'column-sm' },
                    { data: 'NamaArea', name: 'NamaArea', className: 'column-md' },
                    { data: 'KodeDivisi', name: 'KodeDivisi', className: 'column-sm' },
                    { data: 'NamaDivisi', name: 'NamaDivisi', className: 'column-md' },
                    { data: 'KodePemasok', name: 'KodePemasok', className: 'column-md' },
                    { data: 'NamaPemasok', name: 'NamaPemasok', className: 'column-lg' },
                    { data: 'NoFaktur', name: 'NoFaktur', className: 'column-md' },
                    { data: 'TglFaktur', name: 'TglFaktur', className: 'column-md' },
                    { data: 'Nilai', name: 'Nilai', className: 'column-md' },
                    { data: 'Jenis', name: 'Jenis', className: 'column-sm' },
                    { data: 'NoAkun', name: 'NoAkun', className: 'column-md' },
                    { data: 'NamaAkun', name: 'NamaAkun', className: 'column-lg' },
                    { data: 'NoAkunLawan', name: 'NoAkunLawan', className: 'column-md' },
                    { data: 'NamaAkunLawan', name: 'NamaAkunLawan', className: 'column-lg' },
                    { data: 'Jenis(Keluar/Masuk)', name: 'Jenis(Keluar/Masuk)', className: 'column-sm' },
                    { data: 'NoAkunLengkap', name: 'NoAkunLengkap', className: 'column-lg' },
                    { data: 'NoAkunLawanLengkap', name: 'NoAkunLawanLengkap', className: 'column-lg' },
                ],
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
                columns: [
                    { data: 'Tgl', name: 'Tgl', className: 'column-md' },
                    { data: 'NoBukti', name: 'NoBukti', className: 'column-lg' },
                    { data: 'NoBuktiFAS', name: 'NoBuktiFAS', className: 'column-md' },
                    { data: 'PT', name: 'PT', className: 'column-sm' },
                    { data: 'NamaPT', name: 'NamaPT', className: 'column-lg' },
                    { data: 'PRINCIPLE', name: 'PRINCIPLE', className: 'column-sm' },
                    { data: 'NamaPrinciple', name: 'NamaPrinciple', className: 'column-lg' },
                    { data: 'DEPO', name: 'DEPO', className: 'column-sm' },
                    { data: 'NamaDepo', name: 'NamaDepo', className: 'column-lg' },
                    { data: 'KodeArea', name: 'KodeArea', className: 'column-sm' },
                    { data: 'NamaArea', name: 'NamaArea', className: 'column-md' },
                    { data: 'KodeCustomer', name: 'KodeCustomer', className: 'column-md' },
                    { data: 'NamaCustomer', name: 'NamaCustomer', className: 'column-lg' },
                    { data: 'NoFaktur', name: 'NoFaktur', className: 'column-md' },
                    { data: 'TglFaktur', name: 'TglFaktur', className: 'column-md' },
                    { data: 'Nilai', name: 'Nilai', className: 'column-md' },
                    { data: 'Jenis', name: 'Jenis', className: 'column-sm' },
                    { data: 'NoAkun', name: 'NoAkun', className: 'column-md' },
                    { data: 'NamaAkun', name: 'NamaAkun', className: 'column-lg' },
                    { data: 'NoAkunLawan', name: 'NoAkunLawan', className: 'column-md' },
                    { data: 'NamaAkunLawan', name: 'NamaAkunLawan', className: 'column-lg' },
                    { data: 'Jenis(Keluar/Masuk)', name: 'Jenis(Keluar/Masuk)', className: 'column-sm' },
                    { data: 'NoAkunLengkap', name: 'NoAkunLengkap', className: 'column-lg' },
                    { data: 'NoAkunLawanLengkap', name: 'NoAkunLawanLengkap', className: 'column-lg' },
                ],
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
                columns: [
                    { data: "NOBUKTI", name: "NOBUKTI" },
                    { data: "PRINCIPAL", name: "PRINCIPAL" },
                    { data: "NAMA_PRINCIPAL", name: "NAMA_PRINCIPAL" },
                    { data: "DEPO", name: "DEPO" },
                    { data: "NAMA_DEPO", name: "NAMA_DEPO" },
                    { data: "AREA", name: "AREA" },
                    { data: "NAMA_AREA", name: "NAMA_AREA" },
                    { data: "DIVISI", name: "DIVISI" },
                    { data: "NAMA_DIVISI", name: "NAMA_DIVISI" },
                    { data: "KATEGORI", name: "KATEGORI" },
                    { data: "TYPE", name: "TYPE" },
                    { data: "JENIS KLAIM", name: "JENIS KLAIM" },
                    { data: "NAMA KLAIM", name: "NAMA KLAIM" },
                    { data: "NO PROGRAM", name: "NO PROGRAM" },
                    { data: "PERIODE MULAI", name: "PERIODE MULAI" },
                    { data: "PERIODE AKHIR", name: "PERIODE AKHIR" },
                    { data: "TGL PIUTANG KLAIM", name: "TGL PIUTANG KLAIM" },
                    { data: "TGL KIRIM KLAIM", name: "TGL KIRIM KLAIM" },
                    { data: "NO KWITANSI", name: "NO KWITANSI" },
                    { data: "DPP", name: "DPP" },
                    { data: "PPN", name: "PPN" },
                    { data: "NILAI KLAIM", name: "NILAI KLAIM" },
                    { data: "NO AKUN NILAI KLAIM", name: "NO AKUN NILAI KLAIM" },
                    { data: "NO AKUN PPN KLAIM", name: "NO AKUN PPN KLAIM" },
                    { data: "NO AKUN DPP", name: "NO AKUN DPP" },
                    { data: "AkunNilaiKlaim", name: "AkunNilaiKlaim" },
                    { data: "AkunPpnKlaim", name: "AkunPpnKlaim" },
                    { data: "AkunDppKlaim", name: "AkunDppKlaim" },
                    { data: "Nilai", name: "Nilai" },
                ],
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
                columns: [
                    { data: "NOBUKTI", name: "NOBUKTI" },
                    { data: "PRINCIPAL", name: "PRINCIPAL" },
                    { data: "NAMA_PRINCIPAL", name: "NAMA_PRINCIPAL" },
                    { data: "DEPO", name: "DEPO" },
                    { data: "NAMA_DEPO", name: "NAMA_DEPO" },
                    { data: "AREA", name: "AREA" },
                    { data: "NAMA_AREA", name: "NAMA_AREA" },
                    { data: "DIVISI", name: "DIVISI" },
                    { data: "NAMA_DIVISI", name: "NAMA_DIVISI" },
                    { data: "KATEGORI", name: "KATEGORI" },
                    { data: "TYPE", name: "TYPE" },
                    { data: "JENIS KLAIM", name: "JENIS KLAIM" },
                    { data: "NAMA KLAIM", name: "NAMA KLAIM" },
                    { data: "NO PROGRAM", name: "NO PROGRAM" },
                    { data: "PERIODE MULAI", name: "PERIODE MULAI" },
                    { data: "PERIODE AKHIR", name: "PERIODE AKHIR" },
                    { data: "TGL KIRIM KLAIM", name: "TGL KIRIM KLAIM" },
                    { data: "NO KWITANSI", name: "NO KWITANSI" },
                    { data: "TGL BAYAR", name: "TGL BAYAR" },
                    { data: "KET BAYAR", name: "KET BAYAR" },
                    { data: "DPP", name: "DPP" },
                    { data: "PPN", name: "PPN" },
                    { data: "NILAI KLAIM", name: "NILAI KLAIM" },
                    { data: "TOTAL BAYAR", name: "TOTAL BAYAR" },
                    { data: "NoAkunBank", name: "NoAkunBank" },
                    { data: "NamaAkunBank", name: "NamaAkunBank" },
                    { data: "NoAkunLawan", name: "NoAkunLawan" },
                    { data: "NamaAkunLawan", name: "NamaAkunLawan" },
                    { data: "Jenis(Keluar/Masuk)", name: "Jenis(Keluar/Masuk)" },
                    { data: "NoAkunBankLengkap", name: "NoAkunBankLengkap" },
                    { data: "NoAkunLawanLengkap", name: "NoAkunLawanLengkap" },
                    { data: "Nilai", name: "Nilai" },
                ],
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
                columns: [
                    { data: "NOBUKTI", name: "NOBUKTI" },
                    { data: "PRINCIPAL", name: "PRINCIPAL" },
                    { data: "NAMA_PRINCIPAL", name: "NAMA_PRINCIPAL" },
                    { data: "DEPO", name: "DEPO" },
                    { data: "NAMA_DEPO", name: "NAMA_DEPO" },
                    { data: "AREA", name: "AREA" },
                    { data: "NAMA_AREA", name: "NAMA_AREA" },
                    { data: "DIVISI", name: "DIVISI" },
                    { data: "NAMA_DIVISI", name: "NAMA_DIVISI" },
                    { data: "KATEGORI", name: "KATEGORI" },
                    { data: "TYPE", name: "TYPE" },
                    { data: "JENIS KLAIM", name: "JENIS KLAIM" },
                    { data: "NAMA KLAIM", name: "NAMA KLAIM" },
                    { data: "NO PROGRAM", name: "NO PROGRAM" },
                    { data: "PERIODE MULAI", name: "PERIODE MULAI" },
                    { data: "PERIODE AKHIR", name: "PERIODE AKHIR" },
                    { data: "TGL KIRIM KLAIM", name: "TGL KIRIM KLAIM" },
                    { data: "NO KWITANSI", name: "NO KWITANSI" },
                    { data: "TGL BAYAR", name: "TGL BAYAR" },
                    { data: "KET BAYAR", name: "KET BAYAR" },
                    { data: "DPP", name: "DPP" },
                    { data: "PPN", name: "PPN" },
                    { data: "NILAI KLAIM", name: "NILAI KLAIM" },
                    { data: "PENERIMAAN PPH", name: "PENERIMAAN PPH" },
                    { data: "NoAkunBank", name: "NoAkunBank" },
                    { data: "NamaAkunBank", name: "NamaAkunBank" },
                    { data: "NoAkunLawan", name: "NoAkunLawan" },
                    { data: "NamaAkunLawan", name: "NamaAkunLawan" },
                    { data: "Jenis(Keluar/Masuk)", name: "Jenis(Keluar/Masuk)" },
                    { data: "NoAkunBankLengkap", name: "NoAkunBankLengkap" },
                    { data: "NoAkunLawanLengkap", name: "NoAkunLawanLengkap" },
                    { data: "Nilai", name: "Nilai" },
                ],
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
                columns: [
                    { data: "PRINCIPAL", name: "PRINCIPAL" },
                    { data: "NAMA_PRINCIPAL", name: "NAMA_PRINCIPAL" },
                    { data: "DEPO", name: "DEPO" },
                    { data: "NAMA_DEPO", name: "NAMA_DEPO" },
                    { data: "AREA", name: "AREA" },
                    { data: "NAMA_AREA", name: "NAMA_AREA" },
                    { data: "DIVISI", name: "DIVISI" },
                    { data: "NAMA_DIVISI", name: "NAMA_DIVISI" },
                    { data: "KATEGORI", name: "KATEGORI" },
                    { data: "TYPE", name: "TYPE" },
                    { data: "JENIS KLAIM", name: "JENIS KLAIM" },
                    { data: "NAMA KLAIM", name: "NAMA KLAIM" },
                    { data: "NO PROGRAM", name: "NO PROGRAM" },
                    { data: "PERIODE MULAI", name: "PERIODE MULAI" },
                    { data: "PERIODE AKHIR", name: "PERIODE AKHIR" },
                    { data: "SELISIH", name: "SELISIH" },
                    { data: "NOAKUN", name: "NOAKUN" },
                    { data: "NAMAAKUN", name: "NAMAAKUN" },
                    { data: "Nilai", name: "Nilai" },
                    { data: "NoAkunLengkap", name: "NoAkunLengkap" },
                ],
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
                    var totalTables = 13; // Jumlah tabel yang akan di-reload

                    function checkAllTablesLoaded() {
                        reloadCounter++;
                        if (reloadCounter >= totalTables) {
                            showSuccessToast('Semua data berhasil difilter berdasarkan periode: ' +
                                selectedPeriode);
                        }
                    }
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
                    success: function(blob) {
                        // Buat URL objek dari blob
                        var url = window.URL.createObjectURL(blob);

                        // Buat elemen anchor untuk download
                        var a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;

                        // Tentukan nama file dari header Content-Disposition jika ada
                        var filename = downloadType + '_' + startDate + '_' + endDate + '.xlsx';
                        a.download = filename;

                        // Tambahkan ke DOM, klik, dan hapus
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);

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
