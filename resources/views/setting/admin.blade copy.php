@extends('layouts.adminApp')

@section('content')


<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-cogs"></i> SETTING</h1>

    <!-- my Profile -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">My Profile</h6>
        </div>
        <div class="card-body">


            <div class="row">
    
                        <!-- Produk img -->
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <img id="UserImage" src="{{ Auth::user()->user_img ? asset('storage/' . Auth::user()->user_img) : asset('img/undraw_profile.svg') }}" alt="Product Image" class="img-fluid rounded" style="max-height: 310px;">
                        </div>

                        <!-- Produk Detail -->
                        <div class="col-md-9">
                           
                    
                            @csrf
                            @method('PUT')   
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">Display Name :</label>

                                    <span class="badge 
                                        {{ $user->type === '1' ? 'badge-success' : 'badge-primary' }}">
                                        {{ ucfirst($user->type) }}
                                    </span>

                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" readonly>
                       
                                </div>
                                <div class="form-group">
                                    <label for="email" class="font-weight-bold">Email :</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="font-weight-bold">Phone :</label>
                                    <input type="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" readonly>
                                </div>

                            
                                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#editProfileModal">
                                        <i class="fas fa-user"></i> Edit Profile
                                    </button>
                            
                                    <button type="button" class="btn btn-warning mt-3" data-toggle="modal" data-target="#changePasswordModal">
                                        <i class="fas fa-key"></i> Change Password
                                    </button>

                                    <button type="button" class="btn btn-success mt-3" data-toggle="modal" data-target="#changeUserImageModal">
                                        <i class="fas fa-camera"></i> Change Picture
                                    </button>
                                    
                              
                                    
                        </div>
            </div>

    
                    
        </div>



        
    </div>

<!-- Modal for Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Edit profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('setting.admin.updateProfile') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Display Name :</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email :</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="font-weight-bold">Phone :</label>
                        <input type="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
      
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

<!-- Modal for Changing Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('setting.admin.updatePassword') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_password" class="font-weight-bold">Current Password:</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password" class="font-weight-bold">New Password:</label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                        @error('new_password')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation" class="font-weight-bold">Confirm New Password:</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
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


    <!-- My Company -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">My Company</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Company Logo -->
                <div class="col-md-3 text-center mb-3 mb-md-0">
                <img id="CompanyLogo" src="{{ $usercompany->logo ? asset('storage/' . $usercompany->logo) : asset('img/logo_primary.png') }}" alt="Company Logo" class="img-fluid rounded" style="max-height: 310px;">
                </div>

                <!-- Company Details -->
                <div class="col-md-9">
                    <p><strong>Company Name:</strong> {{ $usercompany->company_name }}</p>
                    <p><strong>Company Description:</strong> {{ $usercompany->company_description }}</p>
                    <p><strong>Address:</strong> {{ $usercompany->company_address }}</p>
                    <p><strong>Email:</strong> {{ $usercompany->company_email }}</p>
                    <p><strong>Phone:</strong> {{ $usercompany->company_phone }}</p>
                    <p><strong>Fax:</strong> {{ $usercompany->company_fax }}</p>
                    <p><strong>Web:</strong> {{ $usercompany->company_website }}</p>
                    <p><strong>Currency:</strong> {{ $usercompany->company_currency }}</p>
                    <p><strong>Bank Account:</strong> {{ $usercompany->company_bank_account }}</p>

                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#editCompanyModal">
                        <i class="fas fa-edit"></i> Edit Company
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for Editing Company -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" role="dialog" aria-labelledby="editCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="editCompanyModalLabel">Edit Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('setting.admin.updateCompany') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="company_name" class="font-weight-bold">Company Name:</label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name', $usercompany->company_name) }}" required>
                        @error('company_name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                            <label for="description" class="font-weight-bold">Company Description :</label>
                            <textarea class="form-control @error('company_descrtiption') is-invalid @enderror" id="company_descrtiption" name="company_descrtiption" rows="3" required>{{ $usercompany->company_description }}</textarea>
                        @error('company_descrtiption')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                        
                        </div>

                    <div class="form-group">
                        <label for="company_address" class="font-weight-bold">Company Address:</label>
                        <input type="text" class="form-control @error('company_address') is-invalid @enderror" id="company_address" name="company_address" value="{{ old('company_address', $usercompany->company_address) }}" required>
                        @error('company_address')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="company_email" class="font-weight-bold">Company Email:</label>
                        <input type="email" class="form-control @error('company_email') is-invalid @enderror" id="company_email" name="company_email" value="{{ old('company_email', $usercompany->company_email ) }}" required>
                        @error('company_email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="company_phone" class="font-weight-bold">Company Phone:</label>
                        <input type="text" class="form-control @error('company_phone') is-invalid @enderror" id="company_phone" name="company_phone" value="{{ old('company_phone', $usercompany->company_phone) }}" required>
                        @error('company_phone')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="company_img" class="font-weight-bold">Company Logo:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('company_img') is-invalid @enderror" id="company_img" name="company_img" accept=".jpg,.jpeg,.png">
                            <label class="custom-file-label" for="company_img">Choose file</label>
                        </div>
                        @error('company_img')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <p class="text-muted"><small>Allowed file types: JPG, JPEG, PNG. Max size: 2MB.</small></p>
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







<div class="row flex-lg-nowrap">










  <div class="col">
    <div class="row">
      <div class="col mb-3">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Setting</h6>
            </div>
          <div class="card-body">
            <div class="e-profile">
              <div class="row">
                <div class="col-12 col-sm-auto mb-3">
                  <div class="mx-auto" style="width: 140px;">
                    <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                      
                      <img id="UserImage" src="{{ Auth::user()->user_img ? asset('storage/' . Auth::user()->user_img) : asset('img/undraw_profile.svg') }}" alt="Product Image" class="img-fluid rounded" style="max-height: 310px;">
                    </div>
                  </div>
                </div>
                <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                  <div class="text-center text-sm-left mb-2 mb-sm-0">
                    <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">John Smith</h4>
                    <p class="mb-0">@johnny.s</p>
                    <div class="text-muted"><small>Last seen 2 hours ago</small></div>
                    <div class="mt-2">
                      <button class="btn btn-primary" type="button">
                        <i class="fa fa-fw fa-camera"></i>
                        <span>Change Photo</span>
                      </button>
                    </div>
                  </div>
                  <div class="text-center text-sm-right">
                    <span class="badge badge-secondary">administrator</span>
                    <div class="text-muted"><small>Joined 09 Dec 2017</small></div>
                  </div>
                </div>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item"><a href="" class="active nav-link">Settings</a></li>
              </ul>



              <div class="tab-content pt-3">
                <div class="tab-pane active">
                  <form class="form" novalidate="">
                    <div class="row">
                      <div class="col">
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Full Name</label>
                              <input class="form-control" type="text" name="name" placeholder="John Smith" value="John Smith">
                            </div>
                          </div>
                          <div class="col">
                            <div class="form-group">
                              <label>Username</label>
                              <input class="form-control" type="text" name="username" placeholder="johnny.s" value="johnny.s">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Email</label>
                              <input class="form-control" type="text" placeholder="user@example.com">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col mb-3">
                            <div class="form-group">
                              <label>About</label>
                              <textarea class="form-control" rows="5" placeholder="My Bio"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-6 mb-3">
                        <div class="mb-2"><b>Change Password</b></div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Current Password</label>
                              <input class="form-control" type="password" placeholder="••••••">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>New Password</label>
                              <input class="form-control" type="password" placeholder="••••••">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
                              <input class="form-control" type="password" placeholder="••••••"></div>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-5 offset-sm-1 mb-3">
                        <div class="mb-2"><b>Keeping in Touch</b></div>
                        <div class="row">
                          <div class="col">
                            <label>Email Notifications</label>
                            <div class="custom-controls-stacked px-2">
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="notifications-blog" checked="">
                                <label class="custom-control-label" for="notifications-blog">Blog posts</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="notifications-news" checked="">
                                <label class="custom-control-label" for="notifications-news">Newsletter</label>
                              </div>
                              <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="notifications-offers" checked="">
                                <label class="custom-control-label" for="notifications-offers">Personal Offers</label>
                              </div>
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
              </div>
            </div>

            
          </div>
        </div>
      </div>









      <div class="col-12 col-md-3 mb-3">
        <div class="card shadow mb-3">
          <div class="card-body">
            <div class="px-xl-3">
              <button class="btn btn-block btn-secondary">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span>
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
</div>






</div>


<!-- Scripts -->
@section('scripts')

<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Datatable -->
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

        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

    });
</script>
@endsection


@endsection