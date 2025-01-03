@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Pemesanan /</span> List Data Pemesanan (Approve As Pool)
        </h4>

        <div class="col-lg-12 col-md-6">
            <div class="mt-3 mb-3">
                <!-- Button trigger modal -->
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex justify-content-start">

                    </div>
                    <div class="d-flex justify-content-end">
                        {{-- button back --}}
                        <a href="{{ route('superAdmin.data-approve.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back"></i>
                            <span class="align-middle ms-1">Back</span>
                        </a>
                    </div>
                </div>
                <!-- Hoverable Table rows -->
                <div class="card mt-3">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="text-center" style="vertical-align:middle;">
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th colspan="3">Data Pegawai</th>
                                    <th rowspan="3">Nama Kendaraan</th>
                                    <th rowspan="2">Tujuan Ke</th>
                                    <th rowspan="2">Status</th>
                                    <th colspan="4">Action</th>
                                </tr>
                                <tr>
                                    <th>ID Pegawai</th>
                                    <th>Nama Pegawai</th>
                                    <th>Kantor</th>
                                    <th>Detail Data</th>
                                    <th>Isi BBM</th>
                                    <th>Ganti Kendaraan</th>
                                    <th>Reject</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" style="vertical-align:middle;">
                                <?php $no = 1; ?>
                                @forelse ($getData as $key => $ac)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $ac->id_pegawai }}</td>
                                        <td>{{ $ac->pegawai->nama_pegawai }}</td>
                                        <td>{{ $ac->pegawai->penempatan == 1 ? 'Kantor Pusat' : 'Cabang' }}</td>
                                        <td>{{ $ac->kendaraan->nama_kendaraan }}</td>
                                        <td>{{ $ac->tujuan->nama_tambang }}</td>
                                        <td>
                                            @if ($ac->status == 1)
                                                <span class="badge bg-warning">Menunggu Approve Anda</span>
                                            @elseif($ac->status == 2)
                                                <span class="badge bg-primary">Menunggu Approve Kepala Kantor</span>
                                            @elseif($ac->status == 3)
                                                <span class="badge bg-secondary">Menunggu Pengisian BBM</span>
                                            @elseif($ac->status == 4)
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($ac->status == 5)
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalApprove{{ $ac->id }}">
                                                <i class="bx bx-check"></i>
                                                Detail Approve
                                            </button>
                                        </td>
                                        <td>
                                            <form action="{{ route('superAdmin.approveAsPool.isiBbm', $ac->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    onClick="return confirm('Apakah Anda Yakin Ingin Mengisi BBM?') ? this.form.submit() : ''">
                                                    <span class="align-middle ms-1">Isi BBM</span>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-dark btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalServiceGanti{{ $ac->id }}">
                                                <span class="align-middle ms-1">Ganti Kendaraan</span>
                                            </button>
                                        </td>
                                        <td>
                                            <form action="{{ route('superAdmin.approveAsPool.reject', $ac->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bx bx-x"></i>
                                                    <span class="align-middle ms-1">Reject</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger text-center">
                                        Tidak ada pegawai yang melakukan pemesanan kendaraan
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

    <!-- Modal Approve -->
    @foreach ($getData as $key => $ac)
        <form id="formAccountSettings" method="POST" action="{{ route('superAdmin.approveAsPool.approve', $ac->id) }}">
            @csrf
            <div class="modal fade" id="modalApprove{{ $ac->id }}" tabindex="-1" role="dialog"
                aria-labelledby="modalApproveTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalApproveTitle">Detail Approve Pemesanan Kendaraan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="emailWithTitle" class="form-label">ID Pegawai</label>
                                    <input name="id_pegawai" type="text" id="id_pegawai" class="form-control"
                                        placeholder="ID Pegawai" value="{{ $ac->id_pegawai }}" readonly>
                                </div>
                                <div class="col mb-0">
                                    <label for="emailWithTitle" class="form-label">Nama Pegawai</label>
                                    <input name="nama_pegawai" type="text" id="nama_pegawai" class="form-control"
                                        placeholder="Nama Pegawai" value="{{ $ac->pegawai->nama_pegawai }}" readonly>
                                </div>
                                <div class="col mb-0">
                                    <label for="emailWithTitle" class="form-label">Kantor</label>
                                    <input name="penempatan" type="text" id="penempatan" class="form-control"
                                        placeholder="Kantor" value="{{ Str::title($ac->pegawai->penempatan) }}" readonly>
                                </div>
                                <div class="col mb-0">
                                    <label for="dobWithTitle" class="form-label">Tujuan Ke</label>
                                    <input name="tujuan_tambang" type="text" id="tujuan_tambang" class="form-control"
                                        placeholder="Tujuan Ke" value="{{ $ac->tujuan->nama_tambang }}" readonly>
                                </div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col mb-0">
                                    <label for="dobWithTitle" class="form-label">Kendaraan</label>
                                    <input name="kendaraan" type="text" id="kendaraan" class="form-control"
                                        placeholder="Kendaraan" value="{{ $ac->kendaraan->nama_kendaraan }}" readonly>
                                </div>
                                <div class="col mb-0">
                                    <label for="dobWithTitle" class="form-label">Driver</label>
                                    <input name="driver" type="text" id="driver" class="form-control"
                                        placeholder="Driver" value="{{ $ac->driver->nama_driver }}" readonly>
                                </div>
                                <div class="col mb-0">
                                    <label for="dobWithTitle" class="form-label">Plat Nomor</label>
                                    <input name="plat_nomor" type="text" id="plat_nomor" class="form-control"
                                        placeholder="Plat Nomor" value="{{ $ac->kendaraan->plat_nomor }}" readonly>
                                </div>
                                <div class="col mb-0">
                                    <label for="dobWithTitle" class="form-label">Nama Kendaraan</label>
                                    <input name="nama_kendaraan" type="text" id="nama_kendaraan" class="form-control"
                                        placeholder="Nama Kendaraan" value="{{ $ac->kendaraan->nama_kendaraan }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col mb-0">

                                    @if ($serviceBerikutnya[$key] == 1)
                                        <label for="dobWithTitle" class="form-label badge bg-success">
                                            Status Service
                                        </label>
                                        <input name="kondisiKendaraan" type="text" id="kondisiKendaraan"
                                            class="form-control" placeholder="Service Terakhir"
                                            value="Kendaraan Sudah Service" readonly>
                                    @elseif ($serviceBerikutnya[$key] == 2)
                                        <label for="dobWithTitle" class="form-label badge bg-danger">
                                            Status Service
                                        </label>
                                        <input name="kondisiKendaraan" type="text" id="kondisiKendaraan"
                                            class="form-control" placeholder="Service Terakhir"
                                            value="Segera Service Kendaraan" readonly>
                                    @else
                                        <label for="dobWithTitle" class="form-label badge bg-warning">
                                            Status Service
                                        </label>
                                        <input name="kondisiKendaraan" type="text" id="kondisiKendaraan"
                                            class="form-control" placeholder="Service Terakhir"
                                            value="{{ $serviceBerikutnya[$key] }} Hari Lagi" readonly>
                                    @endif
                                </div>
                                <div class="col mb-0">
                                    <label for="dobWithTitle" class="form-label">Jarak</label>
                                    <input name="jarak" type="text" id="jarak" class="form-control"
                                        placeholder="Jarak" value="{{ $jarakKantorKeTambang[$key] }}" readonly>
                                </div>
                                <div class="col mb-0">
                                    <label for="dobWithTitle" class="form-label">BBM Yang Dibutuhkan</label>
                                    <input name="jarak" type="text" id="jarak" class="form-control"
                                        placeholder="Jarak" value="{{ $bbmYangDibutuhkan[$key] }}" readonly>
                                </div>
                                <div class="col mb-0">
                                    <label for="dobWithTitle" class="form-label">Jumlah BBM</label>
                                    @if ($cekBbm[$key] == 'BBM cukup')
                                        <span class="badge bg-success">{{ $cekBbm[$key] }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $cekBbm[$key] }}</span>
                                    @endif
                                    <input name="jumlah_bbm" type="text" id="jumlah_bbm" class="form-control"
                                        placeholder="Jumlah BBM" value="{{ $jumlahBbm[$key] }}" readonly>
                                    <input name="cekBbm" type="text" id="cekBbm" class="form-control"
                                        value="{{ $cekBbm[$key] }}" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            {{-- Kendaraan kondisi baik & BBM cukup --}}
                            @if ($serviceBerikutnya[$key] == 1 && $cekBbm[$key] == 'BBM cukup')
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-check"></i>
                                    <span class="align-middle ms-1">Approve</span>
                                </button>
                                {{-- kendaraan kondisi buruk & BBM cukup --}}
                            @elseif ($serviceBerikutnya[$key] == 2 && $cekBbm[$key] == 'BBM cukup')
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Service Kendaraan
                                </button>
                                {{-- kendaraan dalam masa service & BBM cukup --}}
                            @elseif ($serviceBerikutnya[$key] != 1 || ($serviceBerikutnya[$key] != 2 && $cekBbm[$key] == 'BBM cukup'))
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                                    Service Kendaraan
                                </button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bx bx-check"></i>
                                    <span class="align-middle ms-1">Approve</span>
                                </button>
                            @else
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                                    Service Kendaraan Atau Isi BBM
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach

    {{-- Service Dan Ganti Kendaraan  --}}
    @foreach ($getData as $key => $ac)
        <form id="formAccountSettings" method="POST"
            action="{{ route('superAdmin.approveAsPool.gantiService', $ac->id) }}">
            @csrf
            <div class="modal fade" id="modalServiceGanti{{ $ac->id }}" tabindex="-1" role="dialog"
                aria-labelledby="modalServiceGantiTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalServiceGantiTitle">Service Kendaraan Dan Ganti Kendaraan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="emailWithTitle" class="form-label">ID Pegawai</label>
                                    <input name="id_pegawai" type="text" id="id_pegawai" class="form-control"
                                        placeholder="ID Pegawai" value="{{ $ac->id_pegawai }}" readonly>
                                </div>
                                <div class="col mb-0">
                                    <label for="emailWithTitle" class="form-label">Nama Pegawai</label>
                                    <input name="nama_pegawai" type="text" id="nama_pegawai" class="form-control"
                                        placeholder="Nama Pegawai" value="{{ $ac->pegawai->nama_pegawai }}" readonly>
                                </div>
                                <div class="col mb-0">
                                    <label for="emailWithTitle" class="form-label">Kendaraan</label>
                                    <input type="text" name="serviceBerikutnya"
                                        value="{{ $serviceBerikutnya[$key] }}" hidden>
                                    <select id="namaKendaraan" class="select2 form-select" name="namaKendaraan">
                                        @foreach ($getJenisKendaraan as $value)
                                            <option value="{{ $value }}"
                                                @if ($value == $ac->kendaraan->nama_kendaraan) selected @endif>
                                                {{ $value }}
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-warning">
                                <i class="bx bx-check"></i>
                                <span class="align-middle ms-1">Service Dan Ganti</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
