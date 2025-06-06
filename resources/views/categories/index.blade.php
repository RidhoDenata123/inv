@extends('layouts.adminApp')
  
@section('content')

@section('styles')
    <style>
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

@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><i class='fas fa-tags'></i> CATEGORY MASTER</h1>
                    <p class="mb-4"></p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">CATEGORY TABLE</h6>
                        </div>
                        <div class="card-body">
                        <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addCategoryModal"><i class='fas fa-plus'></i> Add Category</a>
                       
                            <div class="table-responsive">
                            <table id="categoryTable" class="table table-sm table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Category ID</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">Category Description</th>
                                    <th scope="col">Created At</th> <!-- Tambahkan ini -->
                                    
                                    <th scope="col">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                            </div>
                        </div>
                    </div>

                        <!-- Modal for Add Category -->
                        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Modal Body -->
                                    <form action="{{ route('categories.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="category_id" class="font-weight-bold">Category ID :</label>
                                                <input type="text" class="form-control" id="addCategoryId" name="category_id" readonly>
                                                @error('category_id')
                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="category_name" class="font-weight-bold">Category Name :</label>
                                                <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" value="{{ old('category_name') }}" placeholder="Enter category name" required>
                                                @error('category_name')
                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Category Description</label>
                                                    <textarea class="form-control @error('category_description') is-invalid @enderror" id="category_description" name="category_description" rows="5" placeholder="Input category description">{{ old('category_description') }}</textarea>
                                                
                                                    <!-- error message for category_description -->
                                                    @error('category_description')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                    
                                        </div>

                                        <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Save Category</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Delete Confirmation -->
                        <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteCategoryModalLabel">Delete Category</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="deleteCategoryForm" method="POST" action="">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                
                                                <p><span class="text-primary"> {{ Auth::user()->name }}</span>, are you sure you want to delete "<strong><span id="deleteCategoryName"></span></strong>" ?</p>
                                                <div class="alert alert-danger">
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <strong>WARNING</strong></span>
                                                <p class="text-danger"><small>This action cannot be undone, the selected category data will be permanently deleted !</small></p>
                                                </div>
                                                
                                                
                                                <div class="form-group form-check">
                                                    <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="remember" required> I agree to the Terms & Conditions.
                                                    <div class="valid-feedback">Valid.</div>
                                                    <div class="invalid-feedback">Check this box to continue.</div>
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep it.</button>
                                                <button type="submit" class="btn btn-danger">Yes, Delete!</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>

                        <!-- Modal for Show Category Details -->
                        <div class="modal fade" id="categoryDetailModal" tabindex="-1" role="dialog" aria-labelledby="categoryDetailModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="categoryDetailModalLabel">Category Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="detailCategoryId" class="font-weight-bold">Category ID :</label>
                                                <input type="text" class="form-control" id="detailCategoryId" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="detailCategoryName" class="font-weight-bold">Category Name :</label>
                                                <input type="text" class="form-control" id="detailCategoryName" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="detailCategoryDescription" class="font-weight-bold">Category Description :</label>
                                                <textarea class="form-control" id="detailCategoryDescription" rows="3" readonly></textarea>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <!-- Modal for Edit Category -->
                        <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Modal Body -->
                                    <form id="editCategoryForm" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="editCategoryId" class="font-weight-bold">Category ID :</label>
                                                <input type="text" class="form-control" id="editCategoryId" name="category_id" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="editCategoryName" class="font-weight-bold">Category Name :</label>
                                                <input type="text" class="form-control" id="editCategoryName" name="category_name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="editCategoryDescription" class="font-weight-bold">Category Description :</label>
                                                <textarea class="form-control" id="editCategoryDescription" name="category_description" rows="3" required></textarea>
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

                        

 

                </div>

                  
       
                <!-- /.container-fluid -->

@section('scripts')
    <!-- Page level plugins -->
    <!-- DataTables core -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- DataTables Responsive (setelah DataTables utama) -->
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>


    <!-- Datatable  -->       
    <script>
            $(document).ready(function() {
                $('#categoryTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: '{{ route("categories.datatable") }}',
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'category_id', name: 'category_id' },
                        { data: 'category_name', name: 'category_name' },
                        { data: 'category_description', name: 'category_description' },
                        { data: 'created_at', name: 'created_at' }, // Tambahkan ini
                        { data: 'actions', name: 'actions', orderable: false, searchable: false }
                    ],
                    order: [[4, 'desc']]
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

            // Generate random category_id when the modal is shown
            $('#addCategoryModal').on('show.bs.modal', function() {
                const randomId = 'CAT-' + Math.floor(100000 + Math.random() * 900000); // Generate random ID
                $('#addCategoryId').val(randomId); // Set the value of category_id input
            });

            // Handle click event on "SHOW" button
            $(document).on('click', '.btn-show', function() {
                        const categoryId = $(this).data('category_id'); // Ambil ID kategori dari tombol

                        // Lakukan permintaan AJAX ke server
                        $.ajax({
                            url: `/categories/show/${categoryId}`, // URL rute Laravel untuk mendapatkan detail kategori
                            method: 'GET',
                            success: function(data) {
                                // Isi modal dengan data kategori
                                $('#detailCategoryId').val(data.category_id);
                                $('#detailCategoryName').val(data.category_name);
                                $('#detailCategoryDescription').val(data.category_description);

                                // Tampilkan modal
                                $('#categoryDetailModal').modal('show');
                            },
                            error: function(xhr) {
                            alert('Failed to fetch category details. Please try again.');
                            }
                        });
                    });

                // Handle click event on "EDIT" button
                $(document).on('click', '.btn-edit', function() {
                    const categoryId = $(this).data('category_id'); // Ambil ID kategori dari tombol

                    // Lakukan permintaan AJAX ke server
                    $.ajax({
                        url: `/categories/show/${categoryId}`, // URL rute Laravel untuk mendapatkan detail kategori
                        method: 'GET',
                        success: function(data) {
                            // Isi modal dengan data kategori
                            $('#editCategoryId').val(data.category_id);
                            $('#editCategoryName').val(data.category_name);
                            $('#editCategoryDescription').val(data.category_description);

                            // Set action URL untuk form edit
                            $('#editCategoryForm').attr('action', `/categories/update/${categoryId}`);

                            // Tampilkan modal
                            $('#editCategoryModal').modal('show');
                        },
                        error: function(xhr) {
                            alert('Failed to fetch category details. Please try again.');
                        }
                    });
                });

                // Handle click event on "DELETE" button
                $(document).on('click', '.btn-delete', function() {
                    const categoryId = $(this).data('category_id'); // Ambil ID kategori dari tombol
                    const categoryName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama kategori dari tabel

                    // Isi modal dengan data kategori
                    $('#deleteCategoryId').text(categoryId);
                    $('#deleteCategoryName').text(categoryName);

                    // Set action URL untuk form delete
                    const deleteUrl = `/categories/delete/${categoryId}`;
                    $('#deleteCategoryForm').attr('action', deleteUrl);
                });

        }); 
            
    </script>
@endsection

@endsection
