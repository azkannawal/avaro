@extends('layouts.main')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Welcome {{ Auth::user()->getRole->message }}! 🎉
                                </h5>
                                <p class="mb-4">
                                    Kamu dapat melihat data approve yang telah terdaftar di sini.
                                </p>

                                <form action="{{ route(Auth::user()->getRole->nama_role . '.data-approve.index') }}"
                                    method="GET">
                                    <button type="submit" class="btn btn-outline-primary">
                                        Data Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Approve -->
            <div class="col-md-6 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-12">
                            <h5 class="card-header m-0 me-2 pb-3">Total Approve</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Variable for JS --}}
            <input type="text" value="{{ json_encode($getValuesApprove1) }}" id="approve_1" hidden />
            <input type="text" value="{{ json_encode($getValuesApprove2) }}" id="approve_2" hidden />
            <!--/ Total Approve -->

            <!-- Kendaraan mas service -->
            <div class="col-md-6 col-lg-8 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span class="badge bg-danger">Kendaraan Segera Di Service {{ date('M Y') }}</span>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <div class="card overflow-hidden" style="height: 340px">
                                <div class="card-body" id="vertical-example">
                                    @if ($getKendaraanService == null)
                                        <span class="badge bg-warning">Data Tidak Ditemukan</span>
                                    @else
                                        @for ($i = 0; $i < count($getKendaraanService); $i++)
                                            <li class="d-flex mb-4">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <img src="../assets/img/icons/unicons/chart.png" alt="User"
                                                        class="rounded" />
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0">
                                                            {{ $getKendaraanService[$i]['nama'] }} -
                                                            {{ $getKendaraanService[$i]['plat_nomor'] }} </h6>
                                                        <small
                                                            class="text-muted d-block mb-1">{{ Str::title($getKendaraanService[$i]['jenis_kendaraan']) }}</small>
                                                    </div>
                                                </div>
                                                <div class="user-progress d-flex align-items-center gap-1">
                                                    <span class="badge bg-warning">
                                                        {{ $getKendaraanService[$i]['service_berikutnya'] }}</span>
                                                </div>
                                            </li>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Kendaraan mas service -->
            <!-- Jumlah Pemesan -->
            <div class="col-md-6 col-lg-8 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span class="badge bg-primary">Data Pemesanan Kendaraan {{ date('M Y') }}</span>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <div class="card overflow-hidden" style="height: 340px">
                                <div class="card-body" id="vertical-example">
                                    @if ($getData == null)
                                        <span class="badge bg-warning">Data Tidak Ditemukan</span>
                                    @else
                                        @for ($i = 0; $i < count($getData); $i++)
                                            <li class="d-flex mb-4">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <img src="../assets/img/icons/unicons/chart.png" alt="User"
                                                        class="rounded" />
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <small
                                                            class="text-muted d-block mb-1">{{ $getData[$i]->id_pegawai }}</small>
                                                        <h6 class="mb-0">{{ $getData[$i]->pegawai->nama_pegawai }}</h6>
                                                    </div>
                                                </div>
                                                <div class="user-progress d-flex align-items-center gap-1">
                                                    @if ($getData[$i]->status == 1)
                                                        <span class="badge bg-warning">Menunggu Approve Pool</span>
                                                    @elseif($getData[$i]->status == 2)
                                                        <span class="badge bg-primary">Menunggu Approve Kepala
                                                            Kantor</span>
                                                    @elseif($getData[$i]->status == 3)
                                                        <span class="badge bg-secondary">Menunggu Pengisian
                                                            BBM</span>
                                                    @elseif($getData[$i]->status == 4)
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif($getData[$i]->status == 5)
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @elseif($getData[$i]->status == 6)
                                                        <span class="badge bg-success">Selesai</span>
                                                    @endif
                                                </div>
                                            </li>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Jumlah Pemesan -->
            <!-- Jumlah Kendaraan -->
            <div class="col-md-6 col-lg-8 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <span class="badge bg-primary">Data Pemkaian Kendaraan {{ date('M Y') }}</span>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <div class="card overflow-hidden" style="height: 340px">
                                <div class="card-body" id="vertical1-example">
                                    @if ($getKendaraan == null)
                                        <span class="badge bg-warning">Data Tidak Ditemukan</span>
                                    @else
                                        @for ($i = 0; $i < count($getKendaraan); $i++)
                                            <li class="d-flex mb-4">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <img src="../assets/img/icons/unicons/chart.png" alt="User"
                                                        class="rounded" />
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0">
                                                            {{ $getKendaraan[$i]['nama'] }}</h6>
                                                        <small
                                                            class="text-muted d-block mb-1">{{ Str::title($getKendaraan[$i]['jenis_kendaraan']) }}</small>
                                                    </div>
                                                </div>
                                                <div class="user-progress d-flex align-items-center gap-1">
                                                    <span
                                                        class="badge badge-center bg-danger">{{ $getKendaraan[$i]['jumlah'] }}</span>
                                                </div>
                                            </li>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Jumlah Kendaraan -->


        </div>
    </div>
    <!-- / Content -->

    <!-- Vendors JS -->
    <script src="../../../assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <!-- Page JS -->
    <script src="../../../assets/js/dashboards-analytics.js"></script>
@endsection
