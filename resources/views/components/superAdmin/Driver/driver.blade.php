@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">driver /</span> Index driver
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
                                    <th rowspan="2">Nama Driver</th>
                                    <th colspan="3">Data Driver</th>
                                </tr>
                                <tr>
                                    <th>Status Driver</th>
                                    <th>Penempatan Kantor</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" style="vertical-align:middle;">
                                @forelse ($getData as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->nama_driver }}</td>
                                        <td>{{ Str::title($d->status_driver) }}</td>
                                        <td>{{ Str::title($d->penempatan) }}</td>
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
                                                <a class="page-link" href="{{ $getData->url($i) }}">{{ $i }}</a>
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
@endsection
