<?= $this->extend('includes/layout2'); ?>
<?= $this->section('content'); ?>

<?= $this->section('customCss'); ?>
<style>
    .help-block {
        color: rgb(220, 56, 72);
    }

    .input-group-text {
        background-color: transparent;
        border-left: 0;
        border-top: 0;
        border-right: 0;
        padding-left: 0;
    }

    .form-control {
        border-right: 0;
    }

    .input-group .form-control:focus {
        box-shadow: none;
    }
</style>

<?= $this->endSection(); ?>

<div class="main-wrapper">

    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
        <div class="auth-box p-4 bg-white rounded">
            <div id="loginform">
                <div class="logo">
                    <h3 class="box-title mb-3">Sign In</h3>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form class="form-horizontal mt-3 form-material" id="TicketLogin">
                            <div class="form-group mb-3">
                                <div class="">
                                    <input class="form-control onlyalphanum" type="text" required="" id="username"
                                        name="username" placeholder="Username">
                                    <div class="invalid-feedback text-danger" id="username_msg"></div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="input-group">
                                    <input class="form-control" type="password" id="password" name="password"
                                        placeholder="Password">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="togglePassword">
                                            <i class="fa fa-eye" id="eyeIcon"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback text-danger" id="password_msg"></div>
                                </div>
                            </div>
                            <div class="form-group text-center mt-4">
                                <div class="col-xs-12">
                                    <button
                                        class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
                                        type="submit" id="signin" name="signin">Log In</button>
                                </div>
                            </div>

                            <!-- <div class="form-group mb-0 mt-4">
                                    <div class="col-sm-12 justify-content-center d-flex">
                                        <p>Don't have an account? <a href="<?= base_url('superadmin/register') ?>"
                                                class="text-info font-weight-normal ml-1">Sign Up</a></p>
                                    </div>
                                </div> -->
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>
<?= $this->section('customjs'); ?>
<script>
    $(document).ready(function () {
        $('body').on('keyup', ".onlyalphanum", function (event) {
            this.value = this.value.replace(/[^[A-Za-z0-9]]*/gi, '');
        });

        $('#togglePassword').click(function (e) {
            e.preventDefault();
            const pInp = $('#password');
            const eye = $('#eyeIcon');
            if (pInp.attr('type') === 'password') {
                pInp.attr('type', 'text');
                eye.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                pInp.attr('type', 'password');
                eye.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        jQuery(document).ready(function (e) {
            $('#TicketLogin').bootstrapValidator({
                fields: {
                    'username': {
                        validators: {
                            notEmpty: {
                                message: "Please enter Username"
                            },
                        }
                    },
                    'password': {
                        validators: {
                            notEmpty: {
                                message: "Please enter password."
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9!@#$%^&*()_+\-=[\]{};':"\\|,.<>\/?]*$/,
                                message: 'Password can only contain alphabets, numbers, and special characters.'
                            },
                            stringLength: {
                                min: 6,
                                max: 30,
                                message: 'Password must be at least 6 characters long'
                            }
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
                    url: "<?= base_url('home/ticket_login') ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        // console.log(response);
                        $('input').removeClass('is-invalid');
                        if (response.status === 'success') {
                            $form[0].reset();
                            $.notify(response.message, "success");
                            setTimeout(function () {
                                window.location.href = "<?= base_url('home/dashboard') ?>";
                            }, 1000);
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
    });
</script>
<?= $this->endSection(); ?>