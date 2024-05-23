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
    ;
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

    <div class="row page-titles d-flex justify-content-end rmv_page-titles">
      <button class="btn btn-outline-primary" id="raisedTckt"><i class="fas fa-plus"></i> Raise Tickets</button>
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
                <input type="file" class="form-control" id="attachment" name="attachment">
                <div class="invalid-feedback text-danger" id="attachment_msg">
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-3">
              <div class="form-group">
                <label for="msg">Message</label>
                <textarea name="msg" id="msg" row="10" class="form-control form-group"
                  placeholder="Please Specify the Issue"></textarea>
                <div class="invalid-feedback text-danger" id="attachment_msg">
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

    <div class="table-responsive">
      <table class="table table-bordered table-hover" id="DepartmentTable">
        <thead>
          <tr>
            <th scope="col">Sl.no</th>
            <th scope="col">Ticket Id</th>
            <th scope="col">Raised By</th>
            <th scope="col">Issue</th>
            <th scope="col">Message</th>
            <th scope="col">Attachement</th>
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
    $('#raisedTckt').click(function (e) {
      $('.block_container').show();
    });
    $('#save').click(function (e) {
      $('.block_container').hide();
    });
  </script>
  <?= $this->endSection() ?>