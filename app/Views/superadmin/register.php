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
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
        style="background:url(<?= ASSET_URL ?>public/assets/images/background/login-register.jpg) no-repeat center center; background-size: cover;">
        <div class="auth-box p-4 bg-white rounded">
            <div id="registerForm">
                <div class="logo">
                    <h3 class="box-title mb-3">Sign Up</h3>
                </div>
                <!-- Form -->
                <div class="row">
                    <div class="col-12">
                        <form class="form-horizontal mt-3 form-material" id="SuperadminRegister">
                            <div class="form-group mb-3">
                                <div class="col-xs-12">
                                    <input class="form-control onlyalphanum" type="text" id="username" name="username"
                                        placeholder="Username">
                                    <div class="invalid-feedback text-danger" id="username_msg"></div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
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
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <input class="form-control" type="password" id="cpassword" name="cpassword"
                                        placeholder="Confirm Password">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="togglePassword1" style="cursor: pointer;">
                                            <i class="fa fa-eye" id="eyeIcon1"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback text-danger" id="cpassword_msg"></div>
                                </div>
                            </div>

                            <div class="form-group text-center mb-3">
                                <div class="col-xs-12">
                                    <button
                                        class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light"
                                        type="submit" id="signup" name="signup">Sign Up</button>
                                </div>
                            </div>
                            <div class="form-group mb-0 mt-2 ">
                                <div class="col-sm-12 text-center ">
                                    Already have an account? <a href="<?= base_url('superadmin/login'); ?>"
                                        class="text-info ml-1 ">Sign In</a>
                                </div>
                            </div>
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
        $('#togglePassword1').click(function (e) {
            e.preventDefault();
            const pInp = $('#cpassword');
            const eye = $('#eyeIcon1');
            if (pInp.attr('type') === 'password') {
                pInp.attr('type', 'text');
                eye.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                pInp.attr('type', 'password');
                eye.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });


        jQuery(document).ready(function (e) {
            $('#SuperadminRegister').bootstrapValidator({
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
                                max: 15,
                                message: 'Password must be at least 6 characters long'
                            }
                        }
                    },
                    'cpassword': {
                        validators: {
                            notEmpty: {
                                message: "Please confirm password."
                            },
                            stringLength: {
                                min: 6,
                                max: 15,
                                message: 'Password must be at least 6 characters long'
                            },
                            identical: {
                                field: 'password',
                                message: 'The password and its confirm are not the same'
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
                    url: "<?= base_url('superadmin/register') ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        // console.log(response);
                        $('input').removeClass('is-invalid');
                        if (response.status === 'success') {
                            $form[0].reset();
                            $.notify(response.message, "success");
                            setTimeout(function () {
                                window.location.href = "<?= base_url('superadmin/login') ?>";
                            }, 500);
                        } else {
                            let error = response.errors;
                            for (const key in error) {
                                document.getElementById(key).classList.add('is-invalid');
                                document.getElementById(key + '_msg').innerHTML = error[key];
                            }
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
<?= $this->endSection() ?>