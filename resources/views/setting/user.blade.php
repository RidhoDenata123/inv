@extends('layouts.userApp')

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
    </style>


@endsection


@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-cogs"></i> SETTING</h1>

    <div class="row flex-lg-nowrap">
        <!-- Main Content -->
        <div class="col">
            <div class="row">
                <div class="col mb-3">
                    <div class="card shadow">
                        <!-- Card Header -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">SETTING</h6>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">

                            <div class="e-profile">
                                <div class="row">
                                    <!-- User Image -->
                                    <div class="col-12 col-sm-auto mb-3">
                                        <div class="mx-auto" style="width: 140px;">
                                            <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px;">
                                                <img id="UserImage" src="{{ Auth::user()->user_img ? asset('storage/' . Auth::user()->user_img) : asset('img/undraw_profile.svg') }}" alt="User Image" class="img-fluid rounded" style="max-height: 300px;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- User Info -->
                                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                        <div class="text-center text-sm-left mb-2 mb-sm-0">
                                            <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{ Auth::user()->name }}</h4>
                                            <p class="mb-0">{{ '' . Auth::user()->email }}</p>
                                            <div class="text-muted"><small>Joined {{ Auth::user()->created_at->format('d M Y') }}</small></div>
                                            <div class="mt-2">
                                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#changeUserImageModal">
                                                    <i class="fa fa-fw fa-camera"></i>
                                                    <span>Change Photo</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-center text-sm-right">
                                            <span class="badge badge-primary">Administrator</span>
                                            <div class="text-muted"><small></small></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nav Tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a href="#myProfile" class="active nav-link" data-toggle="tab"><i class='fas fa-user'> </i> Profile</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#myPassword" class="nav-link" data-toggle="tab"><i class='fas fa-key'> </i> Password</a>
                                    </li>

                 

                                </ul>
                            </div>

                            <!-- Tab Content -->
                            <div class="tab-content pt-3">
                                <!-- My Profile Tab -->
                                <div class="tab-pane fade show active" id="myProfile">

                                    <form action="{{ route('setting.user.updateProfile') }}" method="POST">
                                        @csrf
                                        @method('PUT')   
                                        <div class="row">
                                            <div class="col">

                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="name" class="font-weight-bold">Display Name :</label>
                                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                                                @error('name')
                                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="email" class="font-weight-bold">Email :</label>
                                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                                                @error('email')
                                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                            <label for="phone" class="font-weight-bold">Phone :</label>
                                                            <input type="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                                            @error('phone')
                                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                            @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        

                                        
                                        <div class="row">
                                            <div class="col d-flex justify-content-end">
                                                <button class="btn btn-primary" type="submit">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Modal for Changing User Image -->
                                <div class="modal fade" id="changeUserImageModal" tabindex="-1" role="dialog" aria-labelledby="changeUserImageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="changeUserImageModalLabel">Change Profile Picture</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <!-- Modal Body -->
                                            <form action="{{ route('setting.user.updateUserImage') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="user_img" class="font-weight-bold">Upload New Profile Picture :</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input @error('user_img') is-invalid @enderror" id="user_img" name="user_img" accept=".jpg,.jpeg,.png" required>
                                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                                        
                                                        </div>
                                                        @error('user_img')
                                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <p class="text-muted"><small>Allowed file types : JPG, JPEG, PNG. Max size: 2MB.</small></p>
                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <!-- My Password Tab -->
                                <div class="tab-pane" id="myPassword">
                                    <form action="{{ route('setting.user.updatePassword') }}" method="POST">
                                        @csrf
                                        @method('PUT')   
                                        <div class="row">
                                            <div class="col">

                                                <div class="row">
                                                    <div class="col-12 col-sm-6 mb-3">
                                                        <div class="mb-2"><h4>Change Password</h4></div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="current_password" class="font-weight-bold">Current Password :</label>
                                                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                                                                        @error('current_password')
                                                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="new_password" class="font-weight-bold">New Password :</label>
                                                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                                                                        @error('new_password')
                                                                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="new_password_confirmation" class="font-weight-bold">Confirm New Password:</label>
                                                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col d-flex justify-content-end">
                                                                    <button class="btn btn-primary" type="submit">Save Changes</button>
                                                                </div>
                                                            </div>
                                                        </form>

                                                        </div>




                                                    <div class="col-12 col-sm-5 offset-sm-1 mb-3">
                                                        <div class="mb-2"><h4>Forgot Password</h4></div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Enter your email address to receive a password recovery link. We'll send you instructions for resetting your password securely.</p>

                                                                <form method="POST" action="{{ route('password.email') }}">
                                                                    @csrf

                                                                    <div class="form-group">
                                                                    <label for="resetemail" class="font-weight-bold">{{ __('Email Address :') }}</label>
                                                                        <div class="input-group mb-3">
                                                                            <input id="resetemail" type="email" class="form-control @error('resetemail') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                                                @error('resetemail')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            <div class="input-group-append">
                                                                                <button type="submit" class="btn btn-primary">
                                                                                    {{ __('Send Reset Link') }}
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        

                                    
                                    </div>

                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-12 col-md-3 mb-3">
            <div class="card shadow mb-3">
                <!-- Card Header -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">LOGOUT</h6>
                </div>
                <div class="card-body">
                    <p class="card-text">logging out from current login session.</p>
                    <div class="px-xl-3">
                        <button class="btn btn-block btn-secondary" data-toggle="modal" data-target="#logoutModal">
                            <i class="fa fa-sign-out"></i>
                            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                        </button>

                        
                    </div>
                </div>
            </div>
            <div class="card shadow mb-3">
                <!-- Card Header -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">SUPPORT</h6>
                </div>
                <div class="card-body">
                   
                    <p class="card-text">Get fast, free help from our friendly assistants.</p>
                    <button type="button" class="btn btn-primary">Contact Us</button>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Scripts -->
@section('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#bankAccountTable').DataTable({
                "paging": false, // Nonaktifkan pagination bawaan DataTables
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
<script>
    $(document).ready(function() {

        // Aktifkan tab berdasarkan query string
        var activeTab = "{{ session('activeTab') }}";
        if (activeTab) {
            $('.nav-tabs a[href="#' + activeTab + '"]').tab('show');
        }

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

        // EDIT BANK ACCOUNT
            $('.btn-edit').on('click', function() {
                var accountId = $(this).data('account_id');
                $.get('/setting/show-bank/' + accountId, function(data) {
                    $('#edit_account_id').val(data.account_id);
                    $('#edit_account_id_hidden').val(data.account_id);
                    $('#edit_account_name').val(data.account_name);
                    $('#edit_bank_name').val(data.bank_name);
                    $('#editBankAccountForm').attr('action', '/setting/update-bank/' + accountId);
                    $('#editBankAccountModal').modal('show');
                });
            });

            // DELETE BANK ACCOUNT
            $('.btn-delete').on('click', function() {
                var accountId = $(this).data('account_id');
                // Jika ingin menampilkan info tambahan, bisa AJAX ke backend untuk ambil detail
                $('#delete_account_info').text('Account ID: ' + accountId);
                $('#deleteBankAccountForm').attr('action', '/setting/delete-bank/' + accountId);
                $('#deleteBankAccountModal').modal('show');
            });




        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
</script>
@endsection
@endsection