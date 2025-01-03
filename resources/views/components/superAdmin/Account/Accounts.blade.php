@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Account /</span> List Account
        </h4>

        <div class="col-lg-12 col-md-6">
            <div class="mt-3 mb-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCenter">
                    + Tambah Data
                </button>
                <!-- Hoverable Table rows -->
                <div class="card mt-3">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover table-bordered table-striped">
                            <thead class="text-center" style="vertical-align:middle;">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" style="vertical-align:middle;">
                                <?php $no = 1; ?>
                                @forelse ($getData as $ac)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $ac->getRole->message }}</td>
                                        <td>{{ $ac->email }}</td>
                                        <td>
                                            {{ $ac->getRole->nama_role }}
                                        </td>
                                        <td>
                                            <a href="{{ route('superAdmin.accounts.edit', $ac->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Account Belum Dibuat, Silahkan Buat !!.
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

    <!-- Modal -->
    <form id="formAccountSettings" method="POST" action="{{ route('superAdmin.accounts.store') }}">
        @csrf
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Data Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="emailWithTitle" class="form-label">Name</label>
                                <input name="name" type="text" id="name" class="form-control" placeholder="Name"
                                    required />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">E-mail</label>
                                <input name="email" type="email" id="dobWithTitle" class="form-control"
                                    placeholder="E-mail" required />
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Password</label>
                                <input name="password" type="password" id="password" class="form-control" data-eye
                                    placeholder="Enter password" required />
                            </div>
                            <div class="col mb-0">
                                <label for="dobWithTitle" class="form-label">Password</label>
                                <input name="confirm_password" type="password" id="confirm_password" class="form-control"
                                    data-eye placeholder="Enter confirm password" required />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="country">Role</label>
                                <select id="country" class="select2 form-select" name="role">
                                    <option value="1">Super Admin
                                    </option>
                                    <option value="2">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button id="register" type="submit" class="btn btn-primary" disabled>Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Confirm Password --}}
    <script>
        var password = document.getElementById("password"),
            confirm_password = document.getElementById("confirm_password");

        function validatePassword() {
            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
                confirm_password.reportValidity();
                // disable button with id
                document.querySelector('button[id="register"]').disabled = true;

            } else {
                confirm_password.setCustomValidity('');
                // enable button
                document.querySelector('button[id="register"]').disabled = false;
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>
@endsection
