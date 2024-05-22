<!DOCTYPE html>
<html dir="ltr" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= ASSET_URL ?>public/assets/images/favicon.png">
    <title>Rangadore Memorial Hospital Ticket System</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/monsteradmin/" />
    <!-- Custom CSS -->
    <link href="<?= ASSET_URL ?>public/dist/css/style.min.css" rel="stylesheet">
    <?= $this->renderSection('customCss'); ?>
</head>

<?= $this->renderSection('content') ?>
<?= $this->include('includes/js2'); ?>
<?= $this->renderSection('customjs') ?>
</body>

</html>