@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">kendaraan /</span> Index kendaraan
        </h4>

        <div class="col-lg-12 col-md-6">
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex justify-content-start">
                </div>
            </div>

            <div class="mt-3 mb-3">
                <!-- Hoverable Table rows -->
                <div class="card mt-3">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="text-center" style="vertical-align:middle;">
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Nama Kendaraan</th>
                                    <th colspan="3">Data Kendaraan</th>
                                </tr>
                                <tr>
                                    <th>Jenis Kendaraan</th>
                                    <th>Plat Nomor</th>
                                    <th>Jumlah BBM</th>
                                    <th>Konsumsi BBM</th>
                                    <th>Status Kendaraan</th>
                                    <th>Status Pakai</th>
                                    <th>Service Terakhir</th>
                                    <th>Service Berikutnya</th>
                                    <th>Penempatan Kantor</th>
                                    <th>Tanggal Pakai</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" style="vertical-align:middle;">
                                @forelse ($getData as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->nama_kendaraan }}</td>
                                        <td>{{ Str::title($d->jenis_kendaraan) }}</td>
                                        <td>{{ $d->plat_nomor }}</td>
                                        <td>{{ $d->jumlah_bbm }} <small>liter</small></td>
                                        <td>{{ $d->konsumsi_bbm }} <small>per jam</small></td>
                                        <td>{{ $d->status_kendaraan == 1 ? 'Hak Milik' : 'Sewa' }}</td>
                                        <td>{{ $d->status_pakai == 1 ? 'Kendaraan Sedang Dipakai' : 'Kendaraan Tidak Dipakai' }}
                                        </td>
                                        <td>{{ $d->service_terakhir }}</td>
                                        <td>{{ $d->service_berikutnya }}</td>
                                        <td>{{ Str::title($d->penempatan) }}</td>
                                        <td>{{ $d->tanggal_pakai }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            Data Kosong
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- pagination --}}
                    <div class="d-flex justify-content-between p-3">

                        <div class="d-flex justify-content-start">
                            Showing
                            {{ $getData->firstItem() }}
                            to
                            {{ $getData->lastItem() }}
                            of
                            {{ $getData->total() }}
                        </div>
                        <div class="d-flex justify-content-end p-2">
                            <nav aria-label="Page navigation ">
                                <ul class="pagination pagination">
                                    @if (count($getData) == 0)
                                    @else
                                        @if ($getData->onFirstPage())
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1"
                                                    aria-disabled="true">&laquo;</a>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $getData->previousPageUrl() }}"
                                                    aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                        @endif

                                        @for ($i = 1; $i <= $getData->lastPage(); $i++)
                                            <li class="page-item {{ $getData->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $getData->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        @if ($getData->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $getData->nextPageUrl() }}"
                                                    aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1"
                                                    aria-disabled="true">&raquo;</a>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="pagination justify-content-center mt-3"></ul>
    {{-- modal import excel --}}
    <form method="post" action="#" enctype="multipart/form-data">
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Import Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Pilih file excel</label>
                            <input class="form-control" type="file" id="formFile" name="file"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- modal create Data Karyawan --}}
    <form method="post" action="{{ route('superAdmin.kendaraan.store') }}" enctype="multipart/form-data">
        <div class="modal fade" id="modalcreate" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Create Data Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="nama" class="form-label">Nama Karyawan</label>
                                <input class="form-control" placeholder="Nama Karyawan" type="text" id="nama"
                                    name="nama" autofocus required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input class="form-control" placeholder="Tempat Lahir" type="text"
                                    name="tempat_lahir" id="tempat_lahir" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input class="form-control" placeholder="Tanggal Lahir" type="date"
                                    id="tanggal_lahir" name="tanggal_lahir" autofocus required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                    <option selected disabled>-- Pilih Hari --</option>
                                    <option value="Laki-Laki">Laki - Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-select" required>
                                    <option selected disabled>-- Pilih Hari --</option>
                                    <option value="SMA/SMK">SMA/SMK</option>
                                    <option value="D1">D1</option>
                                    <option value="D2">D2</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="bidang_bagian" class="form-label">Bidang Bagian</label>
                                <input class="form-control" placeholder="Bidang Bagian" type="area"
                                    name="bidang_bagian" id="bidang_bagian" autofocus required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">Alamat</span>
                                    <textarea class="form-control" aria-label="With textarea" placeholder="Alamat" name="alamat" id="alamat"
                                        autofocus required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
