<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Удаление канала</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-4">
        <h2>Delete Channel</h2>
        <p>Вы уверены что хотите удалить этот канал?</p>
        <a href="process_delete_channel.php?id=<?php echo $_GET['id']; ?>" class="btn btn-danger">Да, Удалить</a>
        <a href="index.php" class="btn btn-secondary">Отмена</a>
    </div>
</body>
</html>
