<?= $this->extend('includes/layout.php'); ?>
<?= $this->section('content'); ?>

<?= $this->section('customCss'); ?>
<style>
    .block_container {
        border: 1px solid #333;
        padding: 20px;
        margin: 20px 0;
        border-radius: 8px;
        background-color: #fff;
    }

    table.dataTable {
        width: 100% !important;
    }

    .help-block {
        color: rgb(220, 56, 72);
        ;
    }

    #DepartmentForm input::placeholder {
        color: #b7bcc1;
    }
</style>

<?= $this->endSection(); ?>

<div class="page-wrapper">
    <div class="row page-titles d-flex justify-content-end">
        <button class="btn btn-outline-primary" id="addDept"><i class="fas fa-plus"></i> Add Department</button>
    </div>
    <div class="container-fluid">
        <div class="category-from">
            <div class="block_container" style="display: none;">
                <form id="DepartmentForm">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="dept name">Department Name</label><span class="text-danger">*</span>
                            <input type="text" class="form-control onlyalphanum" id="dept" name="dept"
                                placeholder="Enter Department Name" autocomplete="off">
                            <div class="invalid-feedback text-danger" id="dept_msg">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="Department Username">Department Username</label><span
                                    class="text-danger">*</span>
                                <input type="text" class="form-control onlyalphanum" id="dept_user" name="dept_user"
                                    placeholder="Enter Department Username" autocomplete="off">
                                <div class="invalid-feedback text-danger" id="dept_user_msg">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group position-relative">
                                <label for="Department password">Department Password</label><span
                                    class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="dept_pass" name="dept_pass"
                                        placeholder="Enter Department Password">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                            <i class="fa fa-eye" id="eyeIcon"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="invalid-feedback text-danger" id="dept_pass_msg"></div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="form-group">
                                <button type="submit" id="save" name="save" class="btn btn-primary mt-2">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal for edit data -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Department Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="EditDepartmentForm">
                            <div class="row">
                                <div class="col-lg-12 col-md-6 form-group">
                                    <input type="hidden" name="id" id="id" class="form-control">
                                    <label for="dept name">Department Name</label><span class="text-danger">*</span>
                                    <input type="text" class="form-control onlyalphanum" id="edept" name="edept"
                                        placeholder="Enter Department Name" autocomplete="off">
                                    <div class="invalid-feedback text-danger" id="edept_msg">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div class="form-group">
                                        <label for="Department Username">Department Username</label><span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control onlyalphanum" id="edept_user"
                                            name="edept_user" placeholder="Enter Department Username"
                                            autocomplete="off">
                                        <div class="invalid-feedback text-danger" id="edept_user_msg">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div class="form-group position-relative">
                                        <label for="Department password">Department Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="edept_pass"
                                                name="edept_pass" placeholder="Enter Department Password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="togglePassword2"
                                                    style="cursor: pointer;">
                                                    <i class="fa fa-eye" id="eyeIcon2"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback text-danger" id="edept_pass_msg"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="update" name="update" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="DepartmentTable">
                <thead>
                    <tr>
                        <th scope="col">S.no.</th>
                        <th scope="col">Department Name</th>
                        <th scope="col">Department Username</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('customjs'); ?>

<script>
    $(document).ready(function () {
        $('body').on('keyup', ".onlyalphanum", function (event) {
            this.value = this.value.replace(/[^[A-Za-z0-9 ]]*/gi, '');
        });

        $('#togglePassword').click(function (e) {
            e.preventDefault();
            const pInp = $('#dept_pass');
            const eye = $('#eyeIcon');
            if (pInp.attr('type') === 'password') {
                pInp.attr('type', 'text');
                eye.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                pInp.attr('type', 'password');
                eye.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
        $('#togglePassword2').click(function (e) {
            e.preventDefault();
            const pInp = $('#edept_pass');
            const eye = $('#eyeIcon2');
            if (pInp.attr('type') === 'password') {
                pInp.attr('type', 'text');
                eye.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                pInp.attr('type', 'password');
                eye.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $('#addDept').click(function (e) {
            e.preventDefault();
            $('.block_container').show();
        })

        jQuery(document).ready(function (e) {
            $('#DepartmentForm').bootstrapValidator({
                fields: {
                    'dept': {
                        validators: {
                            notEmpty: {
                                message: "Please enter Department Name"
                            },
                        }
                    },
                    'dept_user': {
                        validators: {
                            notEmpty: {
                                message: "Please enter Department Username"
                            },
                        }
                    },
                    'dept_pass': {
                        validators: {
                            notEmpty: {
                                message: "Please Enter Department Password"
                            },
                            stringLength: {
                                min: 6,
                                max: 15,
                                message: 'Password must be between 6 and 15 characters long'
                            },
                        }
                    },
                },
            }).on('success.form.bv', function (e) {
                e.preventDefault();
                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');
                var formData = $form.serialize();
                // console.log(formData);
                $.ajax({
                    url: "<?= base_url('superadmin/addDepartment') ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        // console.log(response);
                        $('input').removeClass('is-invalid');
                        if (response.status === 'success') {
                            $('input').val('');
                            $('.block_container').hide();
                            table.ajax.reload(null, false);
                            $.notify(response.message, "success");
                        } else {
                            let error = response.errors;
                            for (const key in error) {
                                document.getElementById(key).classList.add('is-invalid');
                                document.getElementById(key + '_msg').innerHTML = error[key];
                            }
                            $.notify(response.message, "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle error
                        console.error(error);
                    }
                });
            });
        });

        var table = $('#DepartmentTable').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            order: [[1, 'desc']],
            "fnCreatedRow": function (row, data, index) {
                var pageInfo = table.page.info();
                var currentPage = pageInfo.page;
                var pageLength = pageInfo.length;
                var rowNumber = index + 1 + (currentPage * pageLength);
                $('td', row).eq(0).html(rowNumber);
            },
            columnDefs: [
                { targets: [0, 3], orderable: false }
            ],
            ajax: {
                url: "<?= base_url('superadmin/fetchData') ?>",
                type: "GET",
                error: function (xhr, error, thrown) {
                    // console.log("AJAX error:", xhr, error, thrown);
                }
            },
            drawCallback: function (settings) {
                // console.log('Table redrawn:', settings);
            }
        });

        $(document).on('click', '#actv', function () {
            var button = $(this);
            var data = table.row(button.closest('tr')).data();
            var id = data[0];
            var status = $(this).data('status');
            // console.log(id, status);
            $.ajax({
                method: "POST",
                url: "<?= base_url('superadmin/togglestatus') ?>",
                data: {
                    'id': id,
                    'status': status
                },
                success: function (response) {
                    //   console.log(response);
                    if (response.status === '1') {
                        button.data('status', 'active').html('<i class="fas fa-check-circle"></i>');
                        button.removeClass('btn-outline-danger').addClass('btn-outline-success');
                        $.notify("Department Active Successfully!", 'success');
                    } else {
                        button.data('status', 'deactive').html('<i class="far fa-times-circle"></i>');
                        button.removeClass('btn-outline-success').addClass('btn-outline-danger');
                        $.notify("Department In-Active!");
                    }
                }
            });
        });

        $(document).on('click', '#dlt', function () {
            var button = $(this);
            var data = table.row(button.closest('tr')).data();
            var id = data[0];
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this item!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('superadmin/deleteDepartment') ?>',
                        method: 'POST',
                        data: { 'id': id },
                        success: function (response) {
                            button.closest('.row').remove();
                            Swal.fire('Deleted!', 'Your item has been deleted.', 'success');
                            table.ajax.reload();
                        },
                        error: function (xhr, status, error) {
                            // Handle error response
                            Swal.fire('Error!', 'Failed to delete item: ' + error, 'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '#edit', function () {
            var button = $(this);
            var data = table.row(button.closest('tr')).data();
            var id = data[0];
            $('#id').val(id);
            $.ajax({
                method: "POST",
                url: "<?= base_url('superadmin/edata') ?>",
                data: { 'id': id },
                success: function (response) {
                    // console.log(response);
                    if (response.status == 'success') {
                        var dName = response.message.dept_name;
                        var dUname = response.message.dept_username;
                        var dpass = response.message.dept_pass;
                        $('#edept').val(dName);
                        $('#edept_user').val(dUname);
                        $('#edept_pass').val('');
                    } else {
                        $.notify(response.message, "error");
                    }
                }
            });
        });

        $(document).on('click', '#update', function () {
            var $form = $('#EditDepartmentForm');
            $form.bootstrapValidator({
                fields: {
                    'edept': {
                        validators: {
                            notEmpty: {
                                message: "Please enter Department Name"
                            },
                        }
                    },
                    'edept_user': {
                        validators: {
                            notEmpty: {
                                message: "Please enter Department Username"
                            },
                        }
                    },
                    'edept_pass': {
                        validators: {
                            stringLength: {
                                min: 6,
                                max: 15,
                                message: 'Password must be between 6 and 15 characters long'
                            },
                        }
                    },
                },
            });
            $form.bootstrapValidator('validate');
            if ($form.data('bootstrapValidator').isValid()) {
                var formData = $form.serialize();
                // console.log(formData);
                $.ajax({
                    method: "POST",
                    url: "<?= base_url('superadmin/updateData') ?>",
                    data: formData,
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 'success') {
                            $.notify(response.message, "success");
                            table.ajax.reload();
                            $('#editModal').modal('hide');
                        } else {
                            $.notify(response.message, "error");
                        }
                    }
                });
            }
        });


    });
</script>
<?= $this->endSection() ?>