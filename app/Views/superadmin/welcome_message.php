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

  </div>

  <?= $this->endSection() ?>
  <?= $this->section('customjs'); ?>

  <?= $this->endSection() ?>