<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?= ASSET_URL ?>public/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="<?= ASSET_URL ?>public/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= ASSET_URL ?>public/assets/js/bootstrapValidator.min.js"></script>
<!-- Notify -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"
    integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
<script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();

    $('#to-recover').on("click", function () {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
</script>
