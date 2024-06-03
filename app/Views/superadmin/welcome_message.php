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
                <h3 class="mb-0 font-weight-light">9</h3>
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
                <h3 class="mb-0 font-weight-light">3</h3>
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
                <h3 class="mb-0 font-weight-light">5</h3>
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
                <h3 class="mb-0 font-weight-light">4</h3>
                <h5 class="text-muted mb-0">Resolved Tickets</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Column -->
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="AllRaisedTickets">
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

  <?= $this->endSection() ?>
  <?= $this->section('customjs'); ?>
  <script>
    $(document).ready(function () {
      var table = $('#AllRaisedTickets').DataTable({
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
          error: function (xhr, error, thrown) {
            // console.log("AJAX error:", xhr, error, thrown);
          }
        },
        drawCallback: function (settings) {
          // console.log('Table redrawn:', settings);
        }
      });
    });
  </script>

  <?= $this->endSection() ?>