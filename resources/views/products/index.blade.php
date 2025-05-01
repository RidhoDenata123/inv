@extends('layouts.adminApp')
  
@section('content')

   

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
    </style>


    @endsection

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800"><i class='fas fa-dolly-flatbed'></i> PRODUCT MASTER</h1>
                    <p class="mb-4"></p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">PRODUCT TABLE</h6>
                        </div>
                        <div class="card-body">
                        <a href="#" class="btn btn-md btn-success mb-3" data-toggle="modal" data-target="#addProductModal"><i class='fas fa-plus'></i> ADD PRODUCT</a>
                       
                            <div class="table-responsive">
                            <table id="productTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Product ID</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Purchase Price</th>
                                    <th scope="col">Selling Price</th>
                                    <th scope="col">Supplier</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td> <!-- Nomor otomatis -->
                                        <td>{{ $product->product_id }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->category ? $product->category->category_name : 'No Category' }}</td>
                                        <td>{{ "Rp " . number_format($product->purchase_price,2,',','.') }}</td>
                                        <td>{{ "Rp " . number_format($product->selling_price,2,',','.') }}</td>
                                        <td>{{ $product->supplier ? $product->supplier->supplier_name : 'No Supplier' }}</td>
                                        <td>{{ $product->product_qty }}</td>
                                        <td>{{ $product->unit ? $product->unit->unit_name : 'No Category' }}</td>
                                        <td>
                                            <span class="badge 
                                                {{ $product->product_status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                                {{ ucfirst($product->product_status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <!-- Tombol Show -->
                                                <a href="#" 
                                                class="btn btn-sm btn-dark btn-show mr-2" 
                                                data-product_id="{{ $product->product_id }}" 
                                                data-toggle="modal" 
                                                data-target="#productDetailModal">
                                                <i class="fas fa-search"></i>
                                                </a>

                                                <!-- Dropdown Edit -->
                                                <div class="btn-group mr-2">
                                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class='fas fa-edit'></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a href="#" 
                                                        class="dropdown-item btn-edit" 
                                                        data-product_id="{{ $product->product_id }}" 
                                                        data-toggle="modal" 
                                                        data-target="#editProductModal">
                                                        Edit Data
                                                        </a>
                                                        <a href="#" 
                                                        class="dropdown-item btn-change-image" 
                                                        data-product_id="{{ $product->product_id }}" 
                                                        data-toggle="modal" 
                                                        data-target="#changeImageModal">
                                                        Change Image
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Tombol Delete -->
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger btn-delete" 
                                                        data-product_id="{{ $product->product_id }}" 
                                                        data-toggle="modal" 
                                                        data-target="#deleteProductModal">
                                                        <i class='fas fa-trash-alt'></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                    No data available in table
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $products->links() }}
                            </div>
                        </div>
                    </div>

                    
                <!-- Modal for add Product -->
                <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Product</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
            
                                <!-- Modal body -->
                                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="modal-body">

                                        <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Product ID :</label>
                                                    <input type="text" class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id" value="{{ old('product_id') }}" placeholder="Generated automatically" readonly>

                                                        <!-- error message for product_id -->
                                                        @error('product_id')
                                                            <div class="alert alert-danger mt-2">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                </div>

                                        <div class="row">
                                            <div class="col">                    
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Product name :</label>
                                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name') }}" placeholder="Enter product name" require>

                                                        <!-- error message for product_name -->
                                                        @error('product_name')
                                                            <div class="alert alert-danger mt-2">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                </div>
                                            </div>
                                            <div class="col">

                                            <div class="form-group mb-3">
                                                <label class="font-weight-bold">Product Category:</label>
                                                <select class="form-control selectpicker @error('product_category') is-invalid @enderror" 
                                                        id="product_category" 
                                                        name="product_category" 
                                                        data-live-search="true" 
                                                        data-style="btn-light" 
                                                        required>
                                                    <option value="" selected>Select a category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                                    @endforeach
                                                </select>

                                                <!-- Error message for product_category -->
                                                @error('product_category')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">Product Description</label>
                                            <textarea class="form-control @error('product_description') is-invalid @enderror" name="product_description" rows="3" placeholder="Enter product description">{{ old('product_description') }}</textarea>
                                        
                                            <!-- error message for product_description -->
                                            @error('product_description')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">Product Quantity :</label>
                                            <input type="number" class="form-control @error('product_qty') is-invalid @enderror" id="product_qty" name="product_qty" value="{{ old('product_qty') }}" placeholder="Enter product quantity" require>

                                                <!-- error message for product_qty -->
                                                @error('product_qty')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                        </div>  
                                        <div class="row">
                                            <div class="col">                    
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Purchase Price :</label>
                                                    <input type="number" class="form-control @error('purchase_price') is-invalid @enderror" id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}" placeholder="Enter purchase price" require>

                                                        <!-- error message for purchase_price -->
                                                        @error('purchase_price')
                                                            <div class="alert alert-danger mt-2">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                </div>
                                            </div>
                                            <div class="col">
                                                    <div class="form-group mb-3">
                                                            <label class="font-weight-bold">Selling Price :</label>
                                                            <input type="number" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" value="{{ old('selling_price') }}" placeholder="Enter selling price" require>

                                                                <!-- error message for selling_price -->
                                                                @error('selling_price')
                                                                    <div class="alert alert-danger mt-2">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                    </div>      
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">                    
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Product Unit:</label>
                                                    <select class="form-control selectpicker @error('product_unit') is-invalid @enderror" 
                                                            id="product_unit" 
                                                            name="product_unit" 
                                                            data-live-search="true" 
                                                            data-style="btn-light" 
                                                            required>
                                                        <option value="" selected>Select a unit</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{ $unit->unit_id }}">{{ $unit->unit_name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <!-- Error message for product_unit -->
                                                    @error('product_unit')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Supplier:</label>
                                                    <select class="form-control selectpicker @error('supplier_id') is-invalid @enderror" 
                                                            id="supplier_id" 
                                                            name="supplier_id" 
                                                            data-live-search="true" 
                                                            data-style="btn-light" 
                                                            required>
                                                        <option value="" selected>Select a supplier</option>
                                                        @foreach ($suppliers as $supplier)
                                                            <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <!-- Error message for supplier_id -->
                                                    @error('supplier_id')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">Product Status : </label>
                                            <br>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="product_status_active" name="product_status" value="active" class="custom-control-input" {{ old('product_status') === 'active' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="product_status_active">Active</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="product_status_inactive" name="product_status" value="inactive" class="custom-control-input" {{ old('product_status') === 'inactive' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="product_status_inactive">Inactive</label>
                                            </div>

                                            <!-- Error message for product_status -->
                                            @error('product_status')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                            <hr>

                                        <label class="font-weight-bold">Product image :</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('product_img') is-invalid @enderror" name="product_img" id="product_img">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <!-- error message for product_img -->
                                            @error('product_img')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Product</button>
                                    </div>
                                    
                                </form>
                        </div>
                    </div>
                </div>

                <!-- Modal for Show Product Details -->
                <div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog" aria-labelledby="productDetailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productDetailModalLabel">Product Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <!-- Produk img -->
                                    <div class="col-md-4 text-center mb-3 mb-md-0">
                                        <img id="detailProductImage" src="" alt="Product Image" class="img-fluid rounded" style="max-height: 300px;">
                                    </div>

                                    <!-- Produk Detail -->
                                    <div class="col-md-8">

                                    <div class="card">
                                    
                                        <div class="card-body">          
                                            <p><strong>Product ID :</strong> <span id="detailProductId"></span></p>
                                            
                                                <h1><strong><span id="detailProductName"></span></strong></h1>
                                            
                                            <p> <span id="detailProductDescription"></span></p>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-5"><p><strong>Category :</strong></p></div>
                                                <div class="col-sm-5"><p><span id="detailProductCategory"></span></p></div>  
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5"><p><strong>Purchase Price :</strong></p></div>
                                                <div class="col-sm-5"><p><span id="detailPurchasePrice"></span></p></div>  
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5"><p><strong>Selling Price :</strong></p></div>
                                                <div class="col-sm-5"><p><span id="detailSellingPrice"></span></p></div>  
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5"><p><strong>Quantity :</strong></p></div>
                                                <div class="col-sm-5"><p><span id="detailProductQty"></span></p></div>  
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5"><p><strong>Unit :</strong></p></div>
                                                <div class="col-sm-5"><p><span id="detailProductUnit"></span></p></div>  
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5"><p><strong>Supplier :</strong></p></div>
                                                <div class="col-sm-5"><p><span id="detailSupplierId"></span></p></div>  
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-5"><p><strong>Status :</strong></p></div>
                                                <div class="col-sm-5"><p><span id="detailProductStatus" class="badge"></span></p></div>  
                                            </div>
                                           
                                        </div>
                                    </div>
                                                
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- Modal for Delete Confirmation -->
                <div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="deleteProductForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">
                                    
                                    <p><span class="text-primary"> {{ Auth::user()->name }}</span>, are you sure you want to delete "<strong><span id="deleteProductId"></span> - <span id="deleteProductName"></span></strong>" ?</p>
                                    <div class="alert alert-danger">
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> <strong>WARNING</strong></span>
                                    <p class="text-danger"><small>This action cannot be undone, the selected product data will be permanently deleted !</small></p>
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

                <!-- Modal for Edit Product -->
                <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Product</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
            
                                <!-- Modal body -->
                                <form id="editProductForm" method="POST">
                                @csrf
                                @method('PUT')
                                    <div class="modal-body">

                                        <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Product ID :</label>
                                                    <input type="text" class="form-control @error('product_id') is-invalid @enderror" id="edit_product_id" name="product_id" value="{{ old('product_id') }}" placeholder="Input product id" readonly>

                                                        <!-- error message for product_id -->
                                                        @error('product_id')
                                                            <div class="alert alert-danger mt-2">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                </div>

                                        <div class="row">
                                            <div class="col">                    
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Product name :</label>
                                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="edit_product_name" name="product_name" value="{{ old('product_name') }}" placeholder="Input product name" require>

                                                        <!-- error message for product_name -->
                                                        @error('product_name')
                                                            <div class="alert alert-danger mt-2">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                </div>

                                            </div>

                                            <div class="col">
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Product Category:</label>
                                                    <select class="form-control selectpicker @error('product_category') is-invalid @enderror" 
                                                            id="edit_product_category" 
                                                            name="product_category" 
                                                            data-live-search="true" 
                                                            data-style="btn-light" 
                                                            required>
                                                        <option value="" disabled>Select a category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <!-- Error message for product_category -->
                                                    @error('product_category')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>


                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">Product Description</label>
                                            <textarea class="form-control @error('product_description') is-invalid @enderror" id="edit_product_description" name="product_description" rows="3" placeholder="Input product description">{{ old('product_description') }}</textarea>
                                        
                                            <!-- error message for product_description -->
                                            @error('product_description')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">Product Quantity :</label>
                                            <input type="number" class="form-control @error('product_qty') is-invalid @enderror" id="edit_product_qty" name="product_qty" value="{{ old('product_qty') }}" placeholder="Input product quantity" require>

                                                <!-- error message for product_qty -->
                                                @error('product_qty')
                                                    <div class="alert alert-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                        </div>  

                                        <div class="row">
                                            <div class="col">                    
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Purchase Price :</label>
                                                    <input type="number" class="form-control @error('purchase_price') is-invalid @enderror" id="edit_purchase_price" name="purchase_price" value="{{ old('purchase_price') }}" placeholder="Input purchase price" require>

                                                        <!-- error message for purchase_price -->
                                                        @error('purchase_price')
                                                            <div class="alert alert-danger mt-2">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                </div>

                                            </div>

                                            <div class="col">
                                                    <div class="form-group mb-3">
                                                            <label class="font-weight-bold">Selling Price :</label>
                                                            <input type="number" class="form-control @error('selling_price') is-invalid @enderror" id="edit_selling_price" name="selling_price" value="{{ old('selling_price') }}" placeholder="Input selling price" require>

                                                                <!-- error message for selling_price -->
                                                                @error('selling_price')
                                                                    <div class="alert alert-danger mt-2">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                    </div>      
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">                    
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Product Unit:</label>
                                                    <select class="form-control selectpicker @error('product_unit') is-invalid @enderror" 
                                                            id="edit_product_unit" 
                                                            name="product_unit" 
                                                            data-live-search="true" 
                                                            data-style="btn-light" 
                                                            required>
                                                        <option value="" disabled>Select a unit</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{ $unit->unit_id }}">{{ $unit->unit_name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <!-- Error message for product_unit -->
                                                    @error('product_unit')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col">
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold">Supplier:</label>
                                                    <select class="form-control selectpicker @error('supplier_id') is-invalid @enderror" 
                                                            id="edit_supplier_id" 
                                                            name="supplier_id" 
                                                            data-live-search="true" 
                                                            data-style="btn-light" 
                                                            required>
                                                        <option value="" disabled>Select a supplier</option>
                                                        @foreach ($suppliers as $supplier)
                                                            <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <!-- Error message for supplier_id -->
                                                    @error('supplier_id')
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">Product Status:</label>
                                            <br>

                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="edit_product_status_active" name="product_status" value="active" class="custom-control-input">
                                                <label class="custom-control-label" for="edit_product_status_active">Active</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="edit_product_status_inactive" name="product_status" value="inactive" class="custom-control-input">
                                                <label class="custom-control-label" for="edit_product_status_inactive">Inactive</label>
                                            </div>

                                            <!-- Error message for product_status -->
                                            @error('product_status')
                                                <div class="alert alert-danger mt-2">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                    
                                </form>
                        </div>
                    </div>
                </div>

                <!-- Modal for Change Product Image -->
                <div class="modal fade" id="changeImageModal" tabindex="-1" role="dialog" aria-labelledby="changeImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="changeImageModalLabel">Change Product Image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="changeImageForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Current Image :</label>
                                        <div class="text-center mb-3">
                                            <img id="currentProductImage" src="" alt="Current Product Image" class="img-fluid rounded" style="max-height: 200px;">
                                        </div>
                                    </div>

                                    <hr>

                                    <label class="font-weight-bold">New Image :</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('product_img') is-invalid @enderror" name="product_img" id="new_product_image" required>
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                          
                                    </div>




                                </div>
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
                <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
                <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
                <!-- Bootstrap Select JS -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
              
                <!-- Datatable  -->       
                <script>
                    $(document).ready(function() {
                        $('#productTable').DataTable({
                            "paging": true,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                        
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

                        // Validasi file gambar sebelum mengupload ADD PRODUCT
                        document.getElementById('product_img').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                                const maxSize = 2 * 1024 * 1024; // 2MB

                                if (!allowedTypes.includes(file.type)) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Invalid File Type',
                                        text: 'Only JPEG, PNG, JPG, and GIF files are allowed.',
                                        confirmButtonText: 'OK'
                                    });
                                    event.target.value = ''; // Reset input
                                } else if (file.size > maxSize) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'File Too Large',
                                        text: 'File size exceeds 2MB.',
                                        confirmButtonText: 'OK'
                                    });
                                    event.target.value = ''; // Reset input
                                }
                            }
                        });

                        // Validasi file gambar sebelum mengupload CHANGE IMG
                        document.getElementById('new_product_image').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                                const maxSize = 2 * 1024 * 1024; // 2MB

                                if (!allowedTypes.includes(file.type)) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Invalid File Type',
                                        text: 'Only JPEG, PNG, JPG, and GIF files are allowed.',
                                        confirmButtonText: 'OK'
                                    });
                                    event.target.value = ''; // Reset input
                                } else if (file.size > maxSize) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'File Too Large',
                                        text: 'File size exceeds 2MB.',
                                        confirmButtonText: 'OK'
                                    });
                                    event.target.value = ''; // Reset input
                                }
                            }
                        });

                        // Inisialisasi Bootstrap Select
                        $('.selectpicker').selectpicker({
                            liveSearch: true, // Aktifkan pencarian
                            style: 'btn-light', // Gunakan gaya sederhana
                            size: 5 // Batasi jumlah item yang terlihat
                        });


                        // Generate random product ID when the modal is opened
                        $('#addProductModal').on('show.bs.modal', function() {
                            const randomId = 'PRD-' + Math.random().toString(36).substr(2, 8).toUpperCase();
                            $('#product_id').val(randomId); // Set the generated ID to the input field
                        });

                        // Handle click event on "SHOW" button
                        $('.btn-show').on('click', function() {
                            const productId = $(this).data('product_id'); // Ambil ID produk dari tombol

                            // Lakukan permintaan AJAX ke server
                            $.ajax({
                            url: `/products/${productId}/detail`, // URL rute Laravel
                            method: 'GET',
                            success: function(data) {
                                        // Isi modal dengan data produk
                                        $('#detailProductId').text(data.product_id);
                                        $('#detailProductName').text(data.product_name);
                                        $('#detailProductCategory').text(data.category_name); // Tampilkan category_name
                                        $('#detailProductDescription').text(data.product_description);
                                        $('#detailPurchasePrice').text("Rp " + parseFloat(data.purchase_price).toLocaleString('id-ID', { minimumFractionDigits: 2 }));
                                        $('#detailSellingPrice').text("Rp " + parseFloat(data.selling_price).toLocaleString('id-ID', { minimumFractionDigits: 2 }));
                                        $('#detailProductQty').text(data.product_qty);
                                        $('#detailProductUnit').text(data.unit_name);
                                        $('#detailSupplierId').text(data.supplier_name);
                                        $('#detailProductStatus').text(data.product_status);

                                        
                                        // Atur warna badge berdasarkan status produk
                                            const statusElement = $('#detailProductStatus');
                                            statusElement.text(data.product_status); // Set teks status
                                            if (data.product_status === 'active') {
                                                statusElement.removeClass('badge-danger').addClass('badge-success'); // Warna hijau
                                            } else if (data.product_status === 'inactive') {
                                                statusElement.removeClass('badge-success').addClass('badge-danger'); // Warna merah
                                            }

                                        // Tampilkan gambar produk
                                        if (data.product_img) {
                                            $('#detailProductImage').attr('src', data.product_img);
                                        } else {
                                            $('#detailProductImage').attr('src', '/img/default-product.png'); // Gambar default
                                        }
                                    },
                                    error: function(xhr) {
                                        alert('Failed to fetch product details. Please try again.');
                                    }
                                });
                            });
                        });

                        
                        // Handle click event on "DELETE" button
                        $('.btn-delete').on('click', function() {
                            const productId = $(this).data('product_id'); // Ambil ID produk dari tombol
                            const productName = $(this).closest('tr').find('td:nth-child(3)').text(); // Ambil nama produk dari tabel

                            // Isi modal dengan data produk
                            $('#deleteProductId').text(productId);
                            $('#deleteProductName').text(productName);

                            // Set action URL untuk form delete
                            const deleteUrl = `/products/${productId}`;
                            $('#deleteProductForm').attr('action', `/products/${productId}`);
                        });


                        // Handle click event on "EDIT" button
                        $('.btn-edit').on('click', function() {
                        const productId = $(this).data('product_id'); // Ambil ID produk dari tombol

                            // Lakukan permintaan AJAX ke server untuk mendapatkan data produk
                            $.ajax({
                                url: `/products/${productId}/detail`, // URL rute Laravel untuk mendapatkan detail produk
                                method: 'GET',
                                success: function(data) {
                                    // Isi modal dengan data produk
                                    $('#edit_product_id').val(data.product_id);
                                    $('#edit_product_name').val(data.product_name);
                                    $('#edit_product_description').val(data.product_description);
                                    $('#edit_purchase_price').val(data.purchase_price);
                                    $('#edit_selling_price').val(data.selling_price);
                                    $('#edit_product_qty').val(data.product_qty);

                                    // Pilih kategori yang sesuai
                                    $('#edit_product_category').val(data.product_category).selectpicker('refresh');

                                    // Pilih unit yang sesuai
                                    $('#edit_product_unit').val(data.product_unit).selectpicker('refresh');

                                    // Pilih supplier yang sesuai
                                    $('#edit_supplier_id').val(data.supplier_id).selectpicker('refresh');

                                    // Pilih status yang sesuai
                                    if (data.product_status === 'active') {
                                        $('#edit_product_status_active').prop('checked', true);
                                    } else if (data.product_status === 'inactive') {
                                        $('#edit_product_status_inactive').prop('checked', true);
                                    }

                                    // Set action URL untuk form edit
                                    const editUrl = `/products/${productId}`;
                                    $('#editProductForm').attr('action', editUrl);
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Failed to fetch product details. Please try again.',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            });
                        });
                        
                        // Handle click event on "CHANGE IMAGE" button
                        $('.btn-change-image').on('click', function() {
                            const productId = $(this).data('product_id'); // Ambil ID produk dari tombol

                            // Lakukan permintaan AJAX ke server untuk mendapatkan data produk
                            $.ajax({
                                url: `/products/${productId}/detail`, // URL rute Laravel untuk mendapatkan detail produk
                                method: 'GET',
                                success: function(data) {
                                    // Isi modal dengan data produk
                                    if (data.product_img) {
                                        $('#currentProductImage').attr('src', data.product_img);
                                    } else {
                                        $('#currentProductImage').attr('src', '/img/default-product.png'); // Gambar default
                                    }

                                    // Set action URL untuk form change image
                                    const changeImageUrl = `/products/${productId}/change-image`;
                                    $('#changeImageForm').attr('action', changeImageUrl);
                                },
                                error: function(xhr) {
                                    alert('Failed to fetch product details. Please try again.');
                                }
                            });
                        });

                        // Add the following code if you want the name of the file appear on select
                        $(".custom-file-input").on("change", function() {
                        var fileName = $(this).val().split("\\").pop();
                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                        });

                       


                </script>
@endsection

@endsection
