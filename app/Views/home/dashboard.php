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

  .btn-outline-primary {
    color: #00a65a;
    border-color: #00a65a;
  }

  .rmv_page-titles {
    background: none !important;
    box-shadow: none !important;
  }

  .help-block {
    color: rgb(220, 56, 72);
  }

  .nav-tabs>li {
    margin-right: 5px;
  }

  .nav-tabs>li>a {
    padding: 4px 10px;
    border: 1px solid transparent;
    border-radius: 5px;
    transition: all 0.3s ease;
  }

  .nav-tabs>li.active>a {
    background-color: #007bff;
    color: white !important;
    border: 1px solid #007bff;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .nav-tabs>li>a:hover {
    background-color: #e9ecef;
    color: #007bff !important;
  }

  .form-group {
    display: flex;
    align-items: center;
  }

  .form-group input {
    margin-right: 10px;
  }

  .form-group label {
    font-weight: bold;
  }

  .btn-search {
    display: flex;
    align-items: flex-end;
  }
</style>

<?= $this->endSection(); ?>

<div class="page-wrapper-rmvd" style="margin-top: 100px;">
  <div class="container-fluid">
    <div class="row">
      <!-- Column -->
      <div class="col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row">
              <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-info">
                <i class="ti-wallet"></i>
              </div>
              <div class="ml-2 align-self-center">
                <h3 class="mb-0 font-weight-light" id="total"></h3>
                <h5 class="text-muted mb-0">Total Tickets</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Column -->
      <!-- Column -->
      <div class="col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row">
              <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-warning">
                <i class="mdi mdi-cellphone-link"></i>
              </div>
              <div class="ml-2 align-self-center">
                <h3 class="mb-0 font-weight-light" id="today"></h3>
                <h5 class="text-muted mb-0">Today Tickets</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Column -->
      <!-- Column -->
      <div class="col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row">
              <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-primary">
                <i class="mdi mdi-cart-outline"></i>
              </div>
              <div class="ml-2 align-self-center">
                <h3 class="mb-0 font-weight-light" id="pending"></h3>
                <h5 class="text-muted mb-0">In-Progress Tickets</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Column -->
      <!-- Column -->
      <div class="col-lg-3 col-md-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex flex-row">
              <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-danger">
                <i class="mdi mdi-bullseye"></i>
              </div>
              <div class="ml-2 align-self-center">
                <h3 class="mb-0 font-weight-light" id="resolved"></h3>
                <h5 class="text-muted mb-0">Resolved Tickets</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Column -->
    </div>

    <!-- Modal for edit data -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="StatusId">
              <div class="row">
                <div class="col-lg-12 col-md-6 form-group">
                  <input type="hidden" name="id" id="id" class="form-control">
                  <label for="Status">Select Status</label><span class="text-danger">*</span>
                  <select name="status" id="status" class="form-control">
                    <option value="">Please Select Status</option>
                    <option value="In-Progress">In-Progress</option>
                    <option value="Resolved">Resolved</option>
                  </select>
                  <div class="invalid-feedback text-danger" id="edept_msg">
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

    <div class="row page-titles d-flex justify-content-end rmv_page-titles">
      <button class="btn btn-outline-primary" id="raisedTckt"><i class="fas fa-plus"></i> Raise Tickets</button>
    </div>

    <div class="container-r">
      <h4>Filters:</h4>
      <form id="filters">
        <div class="row page-titles rmv_page-titles">
          <div class="col-md-4 form-group">
            <label for="dept">Department:</label>
            <input type="text" name="dept" id="dept" class="form-control" placeholder="Enter department name">
          </div>
          <div class="col-md-4 form-group">
            <label for="priority">Priority:</label>
            <input type="text" name="priority" id="priority" class="form-control" placeholder="Enter priority">
          </div>
          <div class="col-md-4 form-group">
            <label for="status">Status:</label>
            <input type="text" name="status" id="status" class="form-control" placeholder="Enter Ticket status">
          </div>
          <div class="col-md-4 form-group">
            <label for="from">From Date:</label>
            <input type="date" name="from" id="from" class="form-control">
          </div>
          <div class="col-md-4 form-group">
            <label for="to">To Date:</label>
            <input type="date" name="to" id="to" class="form-control">
          </div>
          <div class="col-md-4 form-group btn-search">
            <button class="btn btn-outline-primary" id="search" style="color: #f18800; border: 1px solid #f18800;"><i class="fas fa-search"></i> Search</button>
            <button class="btn btn-outline-warning" id="reset"
              style="background-color: #fff !important; margin-left: 5px;"><i class="fas fa-spinner"></i> Reset</button>
          </div>
        </div>
      </form>
    </div>

    <div class="category-from">
      <div class="block_container" style="display: none;">
        <form id="RaisedTicketForm">
          <div class="row">
            <div class="col-lg-4 col-md-3 form-group">
              <label for="Issue Name">Issue</label><span class="text-danger">*</span>
              <select name="issue" id="issue" class="form-group form-control">
                <option value="">Please Select One Issue</option>
                <?php foreach ($services as $service): ?>
                  <option value="<?= $service->id; ?>"><?= $service->service; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback text-danger" id="issue_msg">
              </div>
            </div>
            <div class="col-lg-4 col-md-3">
              <div class="form-group">
                <label for="Name">Raised By</label><span class="text-danger">*</span>
                <input type="text" class="form-control onlyalphanum" id="name" name="name" placeholder="Enter Name"
                  autocomplete="off">
                <div class="invalid-feedback text-danger" id="name_msg">
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-3">
              <div class="form-group position-relative">
                <label for="Priority">Priority</label><span class="text-danger">*</span>
                <div class="input-group">
                  <select name="priority" id="priority" class="form-control form-group">
                    <option value="">Please Select One</option>
                    <option value="Critical">Critical</option>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                  </select>
                </div>
                <div class="invalid-feedback text-danger" id="priority_msg"></div>
              </div>
            </div>
            <div class="col-lg-4 col-md-3">
              <div class="form-group">
                <label for="attachment">Attachment</label>
                <input type="file" class="form-control" id="attachment" name="attachment" accept=".jpg, .png, .jpeg">
                <div class="invalid-feedback text-danger" id="attachment_msg">
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-3">
              <div class="form-group">
                <label for="msg">Message</label>
                <textarea name="msg" id="msg" row="10" class="form-control form-group anum"
                  placeholder="Please Specify the Issue"></textarea>
                <div class="invalid-feedback text-danger" id="msg_msg">
                </div>
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

    <ul class="nav nav-tabs">
      <li class="active m-2"><a data-toggle="tab" href="#home">Process Tickets</a></li>
      <li class="m-2"><a data-toggle="tab" href="#menu1">Raised Tickets</a></li>
    </ul>

    <div class="tab-content">
      <div id="home" class="tab-pane in active">
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-hover" id="RaisedTicketTable">
            <thead>
              <tr>
                <th scope="col">Sl.no</th>
                <th scope="col">Ticket Id</th>
                <th scope="col">Issue</th>
                <th scope="col">Raised By</th>
                <th scope="col">Priority</th>
                <th scope="col">Attachement</th>
                <th scope="col">Message</th>
                <th scope="col">Ticket Status</th>
                <th scope="col">Ticket Raised Date</th>
                <th scope="col">Ticket Closed Date</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div id="menu1" class="tab-pane fade">
        <div class="table-responsive mt-3">
          <table class="table table-bordered table-hover" id="RaisedTicketMeTable">
            <thead>
              <tr>
                <th scope="col">Sl.no</th>
                <th scope="col">Ticket Id</th>
                <th scope="col">Issue</th>
                <th scope="col">Raised By</th>
                <th scope="col">Priority</th>
                <th scope="col">Attachement</th>
                <th scope="col">Message</th>
                <th scope="col">Ticket Status</th>
                <th scope="col">Ticket Raised Date</th>
                <th scope="col">Ticket Closed Date</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>



</div>

<?= $this->endSection() ?>
<?= $this->section('customjs'); ?>
<script>
  $(document).ready(function () {
    // Toggle active tab
    $('.nav-tabs a').on('show.bs.tab', function (event) {
      var activeTab = $(event.target).parent();
      activeTab.addClass('active').siblings().removeClass('active');
    });

    $('body').on('keyup', ".onlyalphanum", function (event) {
      this.value = this.value.replace(/[^[A-Za-z0-9 ]]*/gi, '');
    });
    $('body').on('keyup', ".anum", function (event) {
      this.value = this.value.replace(/[^[A-Za-z0-9., ]]*/gi, '');
    });

    $('#raisedTckt').click(function (e) {
      $('.block_container').show();
    });

    jQuery(document).ready(function (e) {
      $('#RaisedTicketForm').bootstrapValidator({
        fields: {
          'issue': {
            validators: {
              notEmpty: {
                message: "Please select Issue"
              },
            }
          },
          'name': {
            validators: {
              notEmpty: {
                message: "Please enter your Name."
              },
            }
          },
          'priority': {
            validators: {
              notEmpty: {
                message: "Please select Priority."
              },
            }
          },
          'attachment': {
            validators: {
              file: {
                extension: 'jpeg,jpg,png',
                type: 'image/jpeg,image/png',
                maxSize: 2 * 1024 * 1024,
                message: 'The selected file is not valid or exceeds 2 MB in size',
              },
            }
          },
        },
      }).on('success.form.bv', function (e) {
        e.preventDefault();
        var $form = $(e.target);
        var bv = $form.data('bootstrapValidator');
        var formData = new FormData($form[0]);
        // console.log(formData);
        $.ajax({
          url: "<?= base_url('home/dashboard') ?>",
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            // console.log(response);
            $('input').removeClass('is-invalid');
            if (response.status === 'success') {
              $form[0].reset();
              $.notify(response.message, "success");
              $('.block_container').hide();
              table.ajax.reload();
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

    var table = $('#RaisedTicketMeTable').DataTable({
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
        { targets: [0, 7], orderable: false }
      ],
      ajax: {
        url: "<?= base_url('home/getRaisedTktbyDept') ?>",
        type: "GET",
        error: function (xhr, error, thrown) {
          // console.log("AJAX error:", xhr, error, thrown);
        }
      },
      drawCallback: function (settings) {
        // console.log('Table redrawn:', settings);
      }
    });

    var table = $('#RaisedTicketTable').DataTable({
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
        { targets: [0, 10], orderable: false }
      ],
      ajax: {
        url: "<?= base_url('home/raisedTickets') ?>",
        type: "GET",
        error: function (xhr, error, thrown) {
          // console.log("AJAX error:", xhr, error, thrown);
        }
      },
      drawCallback: function (settings) {
        // console.log('Table redrawn:', settings);
      }
    });


    $(document).on('click', '#edit', function (e) {
      e.preventDefault();
      var button = $(this);
      var data = table.row(button.closest('tr')).data();
      var id = data[0];

      $.ajax({
        method: "POST",
        url: "<?= base_url('home/getRaisedData') ?>",
        data: { 'id': id },
        success: function (response) {
          // console.log(response);
          if (response.message.status_id) {
            var sid = response.message.status_id;
            $('#id').val(sid);
          }
        }
      });
    });

    $(document).on('click', '#update', function () {
      var formData = $('#StatusId').serialize();
      $.ajax({
        method: "POST",
        url: "<?= base_url('home/updateStatus') ?>",
        data: formData,
        success: function (response) {
          if (response.status == 'success') {
            $.notify(response.message, "success");
            table.ajax.reload();
            $('#exampleModal').modal('hide');
          }
        }
      });
    });

    function fetchNotificationRecord() {
      $.ajax({
        method: "GET",
        url: "<?= base_url('home/notification') ?>",
        success: function (response) {
          let notifiedCount = response.notifiedCount || 0;
          const messageCenter = $(".message-center");
          messageCenter.empty();

          if (Array.isArray(response.message)) {
            response.message.forEach(function (item) {
              const messageItem = `
                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                        <div class="w-75 d-inline-block v-middle pl-2">
                            <h5 class="message-title mb-0 mt-1">${item.raised_by}</h5>
                            <span class="font-12 text-nowrap d-block text-muted text-truncate">${item.msg}</span>
                        </div>
                    </a>
                `;

              messageCenter.append(messageItem);
            });
          }
          // else {
          //   console.log('error');
          // }
          $('#message').text("You have " + notifiedCount + " new messages!");

        }
      });
    }

    fetchNotificationRecord();

    setInterval(fetchNotificationRecord, 60000);

    $.ajax({
      method: "GET",
      url: "<?= base_url('home/CountAllTkts') ?>",
      success: function (response) {
        // console.log(response);
        if (response.status == 'success') {
          $('#total').text(response.message);
        }
      }
    });
    $.ajax({
      method: "GET",
      url: "<?= base_url('home/CountTodayTkts') ?>",
      success: function (response) {
        // console.log(response);
        if (response.status == 'success') {
          $('#today').text(response.count);
        }
      }
    });
    $.ajax({
      method: "GET",
      url: "<?= base_url('home/countPendingTkts') ?>",
      success: function (response) {
        // console.log(response);
        if (response.status == 'success') {
          $('#pending').text(response.count);
        }
      }
    });
    $.ajax({
      method: "GET",
      url: "<?= base_url('home/countResolvedTkts') ?>",
      success: function (response) {
        // console.log(response);
        if (response.status == 'success') {
          $('#resolved').text(response.count);
        }
      }
    });



  });
</script>
<?= $this->endSection() ?>