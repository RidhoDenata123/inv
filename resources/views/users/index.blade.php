@extends('layouts.adminApp')

@section('styles')
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" />

    <style>
        .bootstrap-select .dropdown-toggle {
            height: calc(1.5em + .75rem + 2px); /* Sesuaikan tinggi dengan form Bootstrap */
            padding: .375rem .75rem; /* Padding default form */
            font-size: 1rem; /* Ukuran font default */
            line-height: 1.5; /* Line height default */
            color: #858796; /* Warna teks default */
            background-color: #fff; /* Warna latar belakang */
            border: 1px solid #ced4da; /* Warna border */
            border-radius: .25rem; /* Radius border */
        }

        .bootstrap-select .dropdown-menu {
            font-size: 1rem; /* Ukuran font dropdown */
        }
        
        .pagination {
            margin: 0; /* Hilangkan margin default */
        }
        .table-responsive .pagination {
            justify-content: flex-end; /* Posisikan pagination di kanan */
        }
        
        .table-responsive {
            overflow-x: auto;
            min-height: .01%;
        }
        #receivingHeaderTable {
            width: 100% !important;
            table-layout: auto;
            word-break: break-word;
        }
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
        }

        .table-responsive {
            overflow-x: auto;
            position: relative;
        }
        .table-responsive .dropdown-menu {
            position: absolute !important;
            will-change: transform;
        }
        
    </style>


@endsection

@section('content')

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><i class='fas fa-users'></i> USERS</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">USER TABLE</h6>
        </div>
        <div class="card-body">
            <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addUserModal">
                <i class='fas fa-plus'></i> Add User
            </a>
            <div class="table-responsive">
                <table id="userTable" class="table table-sm table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>No.Telepon</th>   
                            <th>Type</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
        
            </div>
        </div>
    </div>


    <!-- Modal Tambah user  -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add User Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="addname" class="font-weight-bold">Username :</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="addname" name="name" value="{{ old('name') }}" placeholder="Enter Username" required>
                            @error('name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="addphone" class="font-weight-bold">Phone :</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="addphone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone" required>
                            @error('phone')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="addemail" class="font-weight-bold">Email :</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="addemail" name="email" value="{{ old('email') }}" placeholder="Enter email"required>
                            @error('email')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="addpassword" class="font-weight-bold">Password :</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="addpassword" name="password" value="{{ old('password') }}" placeholder="Enter password"required>
                            @error('password')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Type :</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="addtype" name="type" value="{{ old('type') }}" required>
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                            </select>

                            @error('type')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror

                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Akun User -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteUserForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">Hapus Akun User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus akun <strong id="deleteUserNama"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Akun User -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User Account</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editUserId" name="id">
                        <div class="form-group">
                            <label class="font-weight-bold">Username :</label>
                            <input type="text" class="form-control" id="editUserName" name="name" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">No.Telp :</label>
                            <input type="text" class="form-control" id="editUserPhone" name="phone" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Email :</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email" required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Type :</label>
                            <select class="form-control" id="editUserType" name="type" required>
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Password :</label>
                            <input type="password" class="form-control" id="editUserPassword" name="password">
                            <p class="text-info"><small><span class="text-info"><i class="fas fa-info-circle"></i> <strong>INFO :</strong></span> Leave it blank if you don't want to change</small></p>
                        </div>
                        <input type="hidden" name="type" value="0">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>

@section('scripts')
    <!-- Page level plugins -->
    <!-- DataTables core -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- DataTables Responsive (setelah DataTables utama) -->
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

    <!-- Bootstrap Select JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>

    <!-- Datatable  -->       
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route("users.datatable") }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'type', name: 'type' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']]
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            // Tampilkan SweetAlert jika ada session flash message
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            @endif

            // Inisialisasi Bootstrap Select
            $('.selectpicker').selectpicker({
                liveSearch: true,
                style: 'btn-light',
                size: 5
            });

            // Edit user
            $(document).on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                $.get(`/users/show/${id}`, function(data) {
                    $('#editUserId').val(data.id);
                    $('#editUserName').val(data.name);
                    $('#editUserPhone').val(data.phone);
                    $('#editUserEmail').val(data.email);
                    $('#editUserAddress').val(data.address);

                    // Konversi type string ke angka untuk select option
                    let typeValue = data.type;
                    if (typeValue === 'admin') typeValue = 1;
                    else if (typeValue === 'user') typeValue = 0;

                    $('#editUserType').val(typeValue);
                    $('#editUserPassword').val('');
                    $('#editUserForm').attr('action', `/users/update/${id}`);
                    $('#editUserModal').modal('show');
                });
            });

            // Delete user 
            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                $('#deleteUserNama').text(nama);
                $('#deleteUserForm').attr('action', `/users/delete/${id}`);
                $('#deleteUserModal').modal('show');
            });
        });
    </script>
@endsection

@endsection