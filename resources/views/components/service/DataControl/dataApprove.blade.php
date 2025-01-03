@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Pemesanan /</span> List Data Pemesanan (Approve As Service)
        </h4>

        <div class="col-lg-12 col-md-6">
            <div class="mt-3 mb-3">
                <!-- Button trigger modal -->
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex justify-content-start">

                    </div>
                    <div class="d-flex justify-content-end">
                    </div>
                </div>
                <!-- Hoverable Table rows -->
                <div class="card mt-3">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="text-center" style="vertical-align:middle;">
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th colspan="3">Data Kendaraan</th>
                                    <th colspan="4">Action</th>
                                </tr>
                                <tr>
                                    <th>Nama Kendaraan</th>
                                    <th>Jenis Kendaraan</th>
                                    <th>Request Kendaraan</th>
                                    <th>Isi BBM</th>
                                    <th>Service</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" style="vertical-align:middle;">
                                <?php $no = 1; ?>
                                @forelse ($getData as $key => $ac)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $ac->kendaraan->nama_kendaraan ?? $ac->nama_kendaraan }}</td>
                                        <td>{{ Str::title($ac->kendaraan->jenis_kendaraan ?? $ac->jenis_kendaraan) }}</td>
                                        <td>
                                            @if ($requestKendaraan[$key] == 1)
                                                <span class="badge bg-warning">Service</span>
                                            @elseif($requestKendaraan[$key] == 2)
                                                <span class="badge bg-primary">Isi BBM</span>
                                            @endif
                                        <td>
                                            <form action="{{ route('service.service.isiBbm', $ac->id) }}" method="POST">
                                                @csrf
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onClick="return confirm('Apakah Anda Yakin Ingin Mengisi BBM?') ? this.form.submit() : ''"
                                                    {{ $requestKendaraan[$key] == 1 ? 'disabled' : '' }}>
                                                    <span class="align-middle ms-1">Isi BBM
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('service.service.service', $ac->id) }}" method="POST">
                                                @csrf
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    onClick="return confirm('Apakah Anda Yakin Ingin Service?') ? this.form.submit() : ''"
                                                    {{ $requestKendaraan[$key] == 2 ? 'disabled' : '' }}>
                                                    <span class="align-middle ms-1">Service
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger text-center">
                                        Tidak ada kendaraan isi BBM atau service
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="pagination justify-content-center mt-3"></ul>
    <!--/ Hoverable Table rows -->
@endsection
