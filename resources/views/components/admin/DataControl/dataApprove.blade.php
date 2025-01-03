@extends('layouts.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4 py-3">
      <span class="text-muted fw-light">Data Pemesanan /</span> List Data Pemesanan
    </h4>

    <div class="col-lg-12 col-md-6">
      <div class="mb-3 mt-3">
        <!-- Button trigger modal -->
        <div class="d-flex justify-content-between mb-3">
          <div class="d-flex justify-content-start">
            <button type="button" class="btn btn-primary ms-2"
              data-bs-toggle="modal" data-bs-target="#modalCenter">Tambah
              Data</button>

          </div>
          <div class="d-flex justify-content-end">
          </div>
        </div>
        <!-- Hoverable Table rows -->
        <div class="card mt-3">
          <div class="table-responsive text-nowrap">
            <table class="table-hover table-bordered table-striped table">
              <thead class="text-center" style="vertical-align:middle;">
                <tr>
                  <th rowspan="2">#</th>
                  <th colspan="3">Data Pegawai</th>
                  <th colspan="4">Data Kendaraan</th>
                  <th rowspan="2">Tujuan Ke</th>
                  <th rowspan="2">Status</th>
                  <th colspan="3">Action</th>
                </tr>
                <tr>
                  <th>ID Pegawai</th>
                  <th>Nama Pegawai</th>
                  <th>Kantor</th>
                  <th>Nama Kendaraan</th>
                  <th>Jenis Kendaraan</th>
                  <th>Plat Nomor</th>
                  <th>Nama Driver</th>
                  <th>Selesai</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody class="text-center" style="vertical-align:middle;">
                <?php $no = 1; ?>
                @forelse ($getData as $ac)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $ac->id_pegawai }}</td>
                    <td>{{ $ac->pegawai->nama_pegawai }}</td>
                    <td>
                      {{ $ac->pegawai->penempatan == 1 ? 'Kantor Pusat' : 'Cabang' }}
                    <td>{{ $ac->kendaraan->nama_kendaraan }}</td>
                    <td>{{ Str::title($ac->kendaraan->jenis_kendaraan) }}</td>
                    <td>{{ $ac->kendaraan->plat_nomor }}</td>
                    <td>{{ $ac->driver->nama_driver }}</td>
                    <td>{{ $ac->tujuan->nama_tambang }}</td>
                    <td>
                      @if ($ac->status == 1)
                        <span class="badge bg-warning">Menunggu Approve
                          Pool</span>
                      @elseif($ac->status == 2)
                        <span class="badge bg-primary">Menunggu Approve Kepala
                          Kantor</span>
                      @elseif($ac->status == 3)
                        <span class="badge bg-secondary">Menunggu Pengisian
                          BBM</span>
                      @elseif($ac->status == 4)
                        <span class="badge bg-success">Approved</span>
                      @elseif($ac->status == 5)
                        <span class="badge bg-danger">Rejected</span>
                      @elseif($ac->status == 6)
                        <span class="badge bg-success">Selesai</span>
                      @endif
                    <td>
                      <form
                        action="{{ route('admin.data-approve.selesai', $ac->id) }}"
                        method="POST">
                        @csrf
                        <button type="submit"
                          class="btn btn-success btn-sm {{ $ac->status == 4 ? '' : 'disabled' }}"
                          onClick="return confirm('Apakah Anda Yakin Ingin Menyelesaikan Pemesanan Ini?')">
                          Selesai</button>
                      </form>
                    </td>
                    <td>
                      <button type="button" class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEdit{{ $ac->id ?? '' }}"
                        {{ $ac->status == 1 ? '' : 'disabled' }}>
                        Edit
                      </button>
                    </td>
                  </tr>
                @empty
                  <div class="alert alert-danger text-center">
                    Data Pemesanan Kosong!.
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

  <form id="formAccountSettings" method="POST"
    action="{{ route('admin.data-approve.store') }}">
    @csrf
    <div class="modal fade" id="modalCenter" tabindex="-1" role="dialog"
      aria-labelledby="modalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">Tambah Data Pemesanan
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
              aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <div class="row g-2">
              <div class="col mb-0">
                <label for="emailWithTitle" class="form-label">ID Pegawai</label>
                <input name="id_pegawai" type="text" id="id_pegawai"
                  class="form-control" placeholder="ID Pegawai">
              </div>
              <div class="col mb-0">
                <label for="emailWithTitle" class="form-label">Kendaraan</label>
                <select id="id_kendaraan" class="select2 form-select"
                  name="id_kendaraan">
                  <option disabled selected>-- Pilih Kendaraan --</option>
                  @foreach ($getJenisKendaraan as $value)
                    <option value="{{ $value }}">{{ $value }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col mb-0">
                <label for="emailWithTitle" class="form-label">Tujuan Ke</label>
                <select id="tujuan_tambang" class="select2 form-select"
                  name="tujuan_tambang">
                  <option disabled selected>-- Pilih Tujuan --</option>
                  @foreach ($getTujuan as $key => $value)
                    <option value="{{ $key }}">{{ $value }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary"
              data-bs-dismiss="modal">
              Close
            </button>
            <button id="register" type="submit" class="btn btn-primary">Save
              changes</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  @foreach ($getData as $ac)
    <form id="formAccountSettings" method="POST"
      action="{{ route('admin.data-approve.update', $ac->id ?? '') }}">
      @method('PUT')
      @csrf
      <div class="modal fade" id="modalEdit{{ $ac->id ?? '' }}" tabindex="-1"
        role="dialog" aria-labelledby="modalEditTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalEditTitle">Tambah Data Pemesanan
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close">
              </button>
            </div>
            <div class="modal-body">
              <div class="row g-2">
                <div class="col mb-0">
                  <label for="emailWithTitle" class="form-label">ID
                    Pegawai</label>
                  <input name="id_pegawai" type="text" id="id_pegawai"
                    class="form-control" placeholder="ID Pegawai"
                    value="{{ $ac->id_pegawai ?? '' }}" readonly>
                </div>
                <div class="col mb-0">
                  <label for="emailWithTitle" class="form-label">Nama
                    Pegawai</label>
                  <input name="nama_pegawai" type="text" id="nama_pegawai"
                    class="form-control" placeholder="Nama Pegawai"
                    value="{{ $ac->pegawai->nama_pegawai ?? '' }}" readonly>
                </div>
                <div class="col mb-0">
                  <label for="emailWithTitle" class="form-label">Kantor</label>
                  <input name="penempatan" type="text" id="penempatan"
                    class="form-control" placeholder="Kantor"
                    value="{{ Str::title($ac->pegawai->penempatan ?? '') }}"
                    readonly>
                </div>
              </div>
              <div class="row g-2 mt-2">
                <div class="col mb-0">
                  <label for="dobWithTitle" class="form-label">Tujuan Ke</label>
                  <select id="tujuanKe" class="select2 form-select"
                    name="tujuanKe">
                    @foreach ($getTujuan as $key => $value)
                      <option
                        value="{{ $key }}"{{ $key == ($ac->tujuan_tambang ?? '') ? 'selected' : '' }}>
                        {{ $value }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col mb-0">
                  <label for="dobWithTitle" class="form-label">Kendaraan</label>
                  <select id="kendaraan" class="select2 form-select"
                    name="kendaraan">
                    @foreach ($getJenisKendaraan as $key => $value)
                      <option
                        value="{{ $value }}"{{ $value == ($ac->kendaraan->nama_kendaraan ?? '') ? 'selected' : '' }}>
                        {{ $value }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col mb-0">
                  <label for="dobWithTitle" class="form-label">Driver</label>
                  <input name="driver" type="text" id="driver"
                    class="form-control" placeholder="Driver"
                    value="{{ $ac->driver->nama_driver ?? '' }}" readonly>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary"
                data-bs-dismiss="modal">
                Close
              </button>
              <button id="register" type="submit"
                class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  @endforeach
@endsection
