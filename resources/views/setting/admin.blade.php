@extends('layouts.adminApp')

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
                                        <a href="#myProfile" class="active nav-link" data-toggle="tab">Profile</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#myPassword" class="nav-link" data-toggle="tab">Password</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#companyProfile" class="nav-link" data-toggle="tab">Company</a>
                                    </li>

                                </ul>
                            </div>

                            <!-- Tab Content -->
                            <div class="tab-content pt-3">
                                <!-- My Profile Tab -->
                                <div class="tab-pane fade show active" id="myProfile">

                                    <form action="{{ route('setting.admin.updateProfile') }}" method="POST">
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
                                            <form action="{{ route('setting.admin.updateUserImage') }}" method="POST" enctype="multipart/form-data">
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
                                <form action="{{ route('setting.admin.updatePassword') }}" method="POST">
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


                                <!-- Company Profile Tab -->
                                <div class="tab-pane fade show" id="companyProfile">
                                    <form action="{{ route('setting.admin.updateCompany') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-3 text-center mb-3">
                                            <img id="CompanyLogo" src="{{ $usercompany->company_img ? asset('storage/' . $usercompany->company_img) : asset('img/logo_primary.png') }}" alt="Company Logo" class="img-fluid rounded" style="max-height: 300px;">
                                               <hr>
                                                <div class="mt-3">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#changeCompanyImageModal">
                                                        <i class="fas fa-upload"></i> Change Logo
                                                    </button>
                                                </div>

                                                

                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="company_name" class="font-weight-bold">Company Name :</label>
                                                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $usercompany->company_name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="company_address" class="font-weight-bold">Address :</label>
                                                    <input type="text" class="form-control" id="company_address" name="company_address" value="{{ $usercompany->company_address }}" required>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="company_email" class="font-weight-bold">Email :</label>
                                                            <input type="email" class="form-control" id="company_email" name="company_email" value="{{ $usercompany->company_email }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="company_phone" class="font-weight-bold">Phone :</label>
                                                            <input type="text" class="form-control" id="company_phone" name="company_phone" value="{{ $usercompany->company_phone }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="company_fax" class="font-weight-bold">Fax :</label>
                                                            <input type="text" class="form-control" id="company_fax" name="company_fax" value="{{ $usercompany->company_fax }}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="company_website" class="font-weight-bold">Website :</label>
                                                    <input type="text" class="form-control" id="company_website" name="company_website" value="{{ $usercompany->company_website }}" required>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="company_bank_account" class="font-weight-bold">Company Bank Account :</label>
                                                            <input type="text" class="form-control" id="company_bank_account" name="company_bank_account" value="{{ $usercompany->company_bank_account }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="company_currency" class="font-weight-bold">Currency :</label>
                                                            <input type="text" class="form-control" id="company_currency" name="company_currency" value="{{ $usercompany->company_currency }}" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="company_description" class="font-weight-bold">Description :</label>
                                                    <textarea class="form-control" id="company_description" name="company_description" rows="3">{{ $usercompany->company_description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                
                                <!-- Modal for Changing Company Image -->
                                <div class="modal fade" id="changeCompanyImageModal" tabindex="-1" role="dialog" aria-labelledby="changeUserImageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="changeUserImageModalLabel">Change Company Logo</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <!-- Modal Body -->
                                            <form action="{{ route('setting.admin.updateCompanyImage') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="company_img" class="font-weight-bold">Upload New logo :</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input @error('company_img') is-invalid @enderror" id="company_img" name="company_img" accept=".jpg,.jpeg,.png" required>
                                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                                        
                                                        </div>
                                                        @error('company_img')
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




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-12 col-md-3 mb-3">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <div class="px-xl-3">
                        <button class="btn btn-block btn-secondary" data-toggle="modal" data-target="#logoutModal">
                            <i class="fa fa-sign-out"></i>
                            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                        </button>

                        
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="card-title font-weight-bold">Support</h6>
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

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    });
</script>
@endsection
@endsection