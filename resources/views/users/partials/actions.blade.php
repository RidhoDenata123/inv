<div class="d-flex justify-content-center align-items-center">

    <!-- Edit -->
    <a href="#" class="btn btn-sm btn-primary btn-edit mr-2"
        data-id="{{ $row->id }}"
        data-toggle="modal"
        data-target="#editUserModal">
        <i class='fas fa-edit'></i>
    </a>
    <!-- Delete -->
    <button type="button"
        class="btn btn-sm btn-danger btn-delete"
        data-id="{{ $row->id }}"
        data-nama="{{ $row->name }}"
        data-toggle="modal"
        data-target="#deleteUserModal">
        <i class='fas fa-trash-alt'></i>
    </button>
</div>