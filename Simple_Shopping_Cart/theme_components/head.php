<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="icon" type="image/png" href="favicon-48x48.png" sizes="48x48" />
    <link rel="icon" type="image/svg+xml" href="favicon.svg" />
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
    <link rel="manifest" href="site.webmanifest" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css" integrity="sha256-1B2F7Fq1n1D5Z7XH9g1E6H1K1Fz8D5fQf5ZQpU8Zy5I=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?= $script_block ??''?>
    <style>
        i.bi{
            font-size: 1.1rem;
        }
        .ms-n5{
            margin-left: -40px;
        }
        .border_h:hover{
            box-shadow: 0 0 8px 1px #ccc;
        }
        .img-cart{
            display: block;
            max-width: 50px;
            height: auto;
            margin-left: auto;
            margin-right: auto;
        }
        table tr td{
            border: 1px solid #FFFFFF;
        }
        table tr th{
            background:#eee;
        }
    </style>   
</head>
<body class="d-flex flex-column min-vh-100">
    