<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= empty($block['title']) ? '' : $block['title'] . ' | ' ?>e-hotels</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/solid.css" integrity="sha384-VxweGom9fDoUf7YfLTHgO0r70LVNHP5+Oi8dcR4hbEjS8UnpRtrwTx7LpHq/MWLI" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/fontawesome.css" integrity="sha384-rnr8fdrJ6oj4zli02To2U/e6t1qG8dvJ8yNZZPsKHcU7wFK3MGilejY5R/cUc5kf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
<?php foreach($block['stylesheets'] as $css) { ?>
    <link rel="stylesheet" type="text/css" href="<?= $css ?>" />
<?php } ?>
    <link rel="stylesheet" type="text/css" href="assets/css/main.css" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
<?php require 'partials/nav.php' ?>
        </div>
    </nav>
    <main>
<?= $block['content'] ?>
    </main>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
<?= $block['scripts'] ?>
</body>
</html>