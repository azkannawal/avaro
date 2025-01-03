@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Data Karyawan /</span> Edit Data Karyawan
        </h4>
        <div class="col-lg-12 col-md-6">
            <form id="formAccountSettings" method="POST" action="{{ route('data_karyawans.update', $data_karyawan->id) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <!-- Hoverable Table rows -->
                <div class="card mt-3">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="text-center" style="vertical-align:middle; font-weight: bold; font-size: 15px;">
                                <tr>
                                    <th rowspan="2">Nama</th>
                                    <th colspan="7">Data Karyawan</th>
                                </tr>
                                <tr>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Umur</th>
                                    <th>Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pendidikan Terakhir</th>
                                    <th>Bidang Bagian</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" style="vertical-align:middle;">
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ $data_karyawan->nama }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                            value="{{ $data_karyawan->tempat_lahir }}">
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                            value="{{ $data_karyawan->tanggal_lahir }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="umur" name="umur"
                                            value="{{ $data_karyawan->umur }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="alamat" name="alamat"
                                            value="{{ $data_karyawan->alamat }}">
                                    </td>
                                    <td>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                            <option value="Laki-Laki" @if ($data_karyawan->jenis_kelamin == 'Laki-Laki') selected @endif>
                                                Laki-Laki</option>
                                            <option value="Perempuan" @if ($data_karyawan->jenis_kelamin == 'Perempuan') selected @endif>
                                                Perempuan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select" id="pendidikan_terakhir" name="pendidikan_terakhir">
                                            <option value="SMA" @if ($data_karyawan->pendidikan_terakhir == 'SMA') selected @endif>SMA
                                            </option>
                                            <option value="D3" @if ($data_karyawan->pendidikan_terakhir == 'D3') selected @endif>D3
                                            </option>
                                            <option value="S1" @if ($data_karyawan->pendidikan_terakhir == 'S1') selected @endif>S1
                                            </option>
                                            <option value="S2" @if ($data_karyawan->pendidikan_terakhir == 'S2') selected @endif>S2
                                            </option>
                                            <option value="S3" @if ($data_karyawan->pendidikan_terakhir == 'S3') selected @endif>S3
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="bidang_bagian" name="bidang_bagian"
                                            value="{{ $data_karyawan->bidang_bagian }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/ Hoverable rows table -->
                <div class="d-flex justify-content-between">
                    <div class="mt-3 d-flex flex-wrap justify-content-start">
                        <button id="submit_button" type="submit" class="btn btn-primary me-2">Save changes</button>
                    </div>
                    <div class="mt-3 d-flex flex-wrap justify-content-end align-items-center">
                        <a href="{{ route('nilai_alternatifs.edit', $data_karyawan->id) }}"
                            class="btn btn-outline-warning me-2">Edit
                            Nilai Alternatif</a>
                        <a onclick="goBack()" class="btn btn-outline-secondary">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <ul class="pagination justify-content-center mt-3"></ul>
    <!--/ Hoverable Table rows -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- Ajax Umur --}}
    <script>
        $(document).ready(function() {
            $('#tanggal_lahir').change(function() {
                var dob = new Date($(this).val());
                var today = new Date();
                var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
                $('#umur').val(age);
            });
        });
    </script>
@endsection
