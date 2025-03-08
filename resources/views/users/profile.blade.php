<!DOCTYPE html>
<html lang="id">
<head>
    <title>Profil Pengguna</title>
    <!-- Tambahkan link CDN Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include resource_path('views/partials/navbar.blade.php'); ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            Profil Pengguna
        </div>
        <div class="card-body">
            <p class="card-text"><strong>Absen:</strong> <?php echo $id; ?></p>
            <p class="card-text"><strong>Nama:</strong> <?php echo $name; ?></p>
        </div>
    </div>
</div>

</body>
</html>
