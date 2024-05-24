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

    #ServiceForm input::placeholder {
        color: #b7bcc1;
    }
</style>

<?= $this->endSection(); ?>

<div class="page-wrapper">
    <div class="row page-titles d-flex justify-content-end">
        <button class="btn btn-outline-primary" id="addSrvc"><i class="fas fa-plus"></i> Add Service</button>
    </div>
    <div class="container-fluid">
        <div class="category-from">
            <div class="block_container" style="display: none;">
                <form id="ServiceForm">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="Service Name">Category</label><span class="text-danger">*</span>
                            <input type="text" class="form-control onlyalphanum" id="srvc" name="srvc"
                                placeholder="Enter Service Name" autocomplete="off">
                            <div class="invalid-feedback text-danger" id="srvc_msg">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 form-group">
                            <label for="Department Name">Reported To</label><span class="text-danger">*</span>
                            <select name="dept" id="dept" class="form-control form-group">
                                <option value="">Please Select Department</option>
                                <?php foreach ($dept as $data): ?>
                                    <option value="<?= $data->id; ?>"><?= $data->dept_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback text-danger" id="dept_msg">
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
                        <h5 class="modal-title" id="editModalLabel">Edit Category Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="EditServiceForm">
                            <div class="col-lg-12 col-md-6 form-group">
                                <input type="hidden" name="id" id="id">
                                <label for="Service Name">Category</label><span class="text-danger">*</span>
                                <input type="text" class="form-control onlyalphanum" id="esrvc" name="esrvc"
                                    placeholder="Enter Service Name" autocomplete="off">
                                <div class="invalid-feedback text-danger" id="esrvc_msg">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6 form-group">
                                <label for="Department Name">Reported To</label><span class="text-danger">*</span>
                                <select name="edept" id="edept" class="form-control form-group">
                                    <option value="">Please Select Department</option>
                                    <?php foreach ($dept as $data): ?>
                                        <option value="<?= $data->id; ?>"><?= $data->dept_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback text-danger" id="edept_msg">
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
            <table class="table table-bordered table-hover" id="ServiceTable">
                <thead>
                    <tr>
                        <th scope="col">S.no.</th>
                        <th scope="col">Category Name</th>
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

        $('#addSrvc').click(function (e) {
            e.preventDefault();
            $('.block_container').show();
        })

        jQuery(document).ready(function (e) {
            $('#ServiceForm').bootstrapValidator({
                fields: {
                    'srvc': {
                        validators: {
                            notEmpty: {
                                message: "Please enter Service Name"
                            },
                        }
                    },
                    'dept': {
                        validators: {
                            notEmpty: {
                                message: "Please select Department Name"
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
                    url: "<?= base_url('superadmin/addService') ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        // console.log(response);
                        $('input').removeClass('is-invalid');
                        if (response.status === 'success') {
                            $('input').val('');
                            $('.block_container').hide();
                            $.notify(response.message, "success");
                            table.ajax.reload(null, false);
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

        var table = $('#ServiceTable').DataTable({
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
                { targets: [0, 2], orderable: false }
            ],
            ajax: {
                url: "<?= base_url('superadmin/servicedata') ?>",
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
                url: "<?= base_url('superadmin/servicetogglestatus') ?>",
                data: {
                    'id': id,
                    'status': status
                },
                success: function (response) {
                    //   console.log(response);
                    if (response.status === '1') {
                        button.data('status', 'active').html('<i class="fas fa-check-circle"></i>');
                        button.removeClass('btn-outline-danger').addClass('btn-outline-success');
                        $.notify("Service Active Successfully!", 'success');
                    } else {
                        button.data('status', 'deactive').html('<i class="far fa-times-circle"></i>');
                        button.removeClass('btn-outline-success').addClass('btn-outline-danger');
                        $.notify("Service In-Active!");
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
                        url: '<?= base_url('superadmin/deleteService') ?>',
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
                url: "<?= base_url('superadmin/eservicedata') ?>",
                data: { 'id': id },
                success: function (response) {
                    // console.log(response);
                    if (response.status == 'success') {
                        var srvc = response.message.service;
                        var dpt = response.message.department;
                        $('#esrvc').val(srvc);
                        $('#edept').val(dpt);
                    } else {
                        $.notify(response.message, "error");
                    }
                }
            });
        });

        $(document).on('click', '#update', function () {
            var $form = $('#EditServiceForm');
            $form.bootstrapValidator({
                fields: {
                    'esrvc': {
                        validators: {
                            notEmpty: {
                                message: "Please enter Category Name"
                            },
                        }
                    },
                    'edept': {
                        validators: {
                            notEmpty: {
                                message: "Please select Department Name"
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
                    url: "<?= base_url('superadmin/updateServiceData') ?>",
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