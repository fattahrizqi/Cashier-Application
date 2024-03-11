<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            margin: auto;
            max-width: 1280px;
        }

        .menu {
            justify-content: center;
        }

        a {
            text-decoration: none;
            color: #2e2e2e;
        }

        .menu-list {
            background-color: orange;
            padding: 15px;
            transition: 0.3s ease;
        }

        .menu-list:hover {
            scale: 1.1;
            transition: 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 style="text-align: center">Sistem Kasir</h1>
    </div>

    <div class="menu" style="display: flex; gap: 5rem;">
        <a href="{{ route('products.index') }}">
            <div class="menu-list">
                <h6>Manajemen Produk</h6>
            </div>
        </a>
        <a href="{{ route('transaction.index') }}">
            <div class="menu-list">
                <h6>Manajemen Transaksi</h6>
            </div>
        </a>
    </div>
</body>

</html>
