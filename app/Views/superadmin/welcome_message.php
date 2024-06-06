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

  .rmv_page-titles {
    background: none !important;
    box-shadow: none !important;
  }

  .page-titles {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }

  /* .form-group {
    display: flex;
    align-items: center;
  }  */

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

<div class="page-wrapper">
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

    <div class="row page-titles d-flex justify-content-end rmv_page-titles">
      <button class="btn btn-outline-info" id="dlReport"><i class="fas fa-download"></i> Excel Report</button>
    </div>

    <div class="container-r">
      <h4>Filters:</h4>
      <form id="filters">
        <div class="row page-titles rmv_page-titles">
          <div class="col-md-4 form-group">
            <label for="dept">Department:</label>
            <input type="text" name="dept" id="dept" class="form-control" placeholder="Enter department username">
          </div>
          <div class="col-md-4 form-group">
            <label for="priority">Priority:</label>
            <!-- <input type="text" name="priority" id="priority" class="form-control" placeholder="Enter priority"> -->
            <div class="input-group">
              <select name="priority" id="priority" class="form-control form-group">
                <option value="">Please Select One</option>
                <option value="Critical">Critical</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 form-group">
            <label for="status">Status:</label>
            <!-- <input type="text" name="status" id="status" class="form-control" placeholder="Enter Ticket status"> -->
            <div class="input-group">
              <select name="status" id="status" class="form-control form-group">
                <option value="">Please Select One</option>
                <option value="Open">Open</option>
                <option value="In-Progress">In-Progress</option>
                <option value="Resolved">Resolved</option>
              </select>
            </div>
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
            <button class="btn btn-outline-primary" id="search"><i class="fas fa-search"></i> Search</button>
            <button class="btn btn-outline-warning" id="reset"
              style="background-color: #fff !important; margin-left: 5px;"><i class="fas fa-spinner"></i> Reset</button>
          </div>
        </div>
      </form>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="AllRaisedTickets">
        <thead>
          <tr>
            <th scope="col">Sl.no</th>
            <th scope="col">Ticket Id</th>
            <th scope="col">Department Username</th>
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

  <?= $this->endSection() ?>
  <?= $this->section('customjs'); ?>
  <script>
    $(document).ready(function () {
      var table;
      function FilteredRecords() {
        // $('#AllRaisedTickets').DataTable().destroy();
        if ($.fn.DataTable.isDataTable('#AllRaisedTickets')) {
          $('#AllRaisedTickets').DataTable().destroy();
        }


        table = $('#AllRaisedTickets').DataTable({
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
            url: "<?= base_url('superadmin/fetchalltickets') ?>",
            type: "GET",
            data: function (d) {
              d.dept = $('#dept').val();
              d.priority = $('#priority').val();
              d.status = $('#status').val();
              d.from = $('#from').val();
              d.to = $('#to').val();
            },
            error: function (xhr, error, thrown) {
              // console.log("AJAX error:", xhr, error, thrown);
            }
          },
          drawCallback: function (settings) {
            // console.log('Table redrawn:', settings);
          }
        });
      }

      FilteredRecords();

      $('#dlReport').click(function (e) {
        e.preventDefault();
        // console.log('clicked');
        var dept = $('#dept').val();
        var priority = $('#priority').val();
        var status = $('#status').val();
        var from = $('#from').val();
        var to = $('#to').val();

        var queryString = $.param({
          dept: dept,
          priority: priority,
          status: status,
          from: from,
          to: to
        });

        window.location.href = "<?= base_url('superadmin/downloadReport') ?>" + "?" + queryString;;
      });

      $('#search').click(function (e) {
        e.preventDefault();
        FilteredRecords();
      });

      $('#reset').click(function (e) {
        e.preventDefault();
        $('#dept').val('');
        $('#priority').val('');
        $('#status').val('');
        $('#from').val('');
        $('#to').val('');
        FilteredRecords();
      });

      $.ajax({
        method: "GET",
        url: "<?= base_url('superadmin/CountAllTkts') ?>",
        success: function (response) {
          // console.log(response);
          if (response.status == 'success') {
            $('#total').text(response.message);
          }
        }
      });
      $.ajax({
        method: "GET",
        url: "<?= base_url('superadmin/CountTodayTkts') ?>",
        success: function (response) {
          // console.log(response);
          if (response.status == 'success') {
            $('#today').text(response.count);
          }
        }
      });
      $.ajax({
        method: "GET",
        url: "<?= base_url('superadmin/countPendingTkts') ?>",
        success: function (response) {
          // console.log(response);
          if (response.status == 'success') {
            $('#pending').text(response.count);
          }
        }
      });
      $.ajax({
        method: "GET",
        url: "<?= base_url('superadmin/countResolvedTkts') ?>",
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