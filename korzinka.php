<?php
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'shop';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    echo 'not connected'.$conn->connect_error;
}
$sql = "Select * from korzinka";
if ($result = $conn->query($sql)){
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
            $korzinka[] = $row;
        }
    } else {
        echo "<span class='badge badge-danger'>нет продукты</span>";
    }

}
$sqlc = "Select * from category";
if ($result= $conn->query($sqlc)){
    if ($result->num_rows>0){
        while ($row = $result->fetch_assoc()){
            $categories[] = $row;
        }
    }
    else {
        echo "<span class='badge badge-danger'>0 results</span>";
    }
}
if ($_SERVER['REQUEST_METHOD']=='GET'){
    $korzinka_id = $_GET['id'];
    foreach ($korzinka as $model){
        if ($model['id']==$korzinka_id){
            $korzinkas = "DELETE FROM korzinka where id = ".$korzinka_id;
            if ($conn->query($korzinkas)){
                echo "<span class='badge badge-success'>1 штук ".$model['name']." удалено из корзинку</span>";
            }else{
                echo "<span class='badge badge-danger'>не удалено</span>";
            }
        }
    }

}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../bootstrap.min.js"></script>
    <style>
        .badge{
            height: 44px;
            font-size: 20px;
            text-align: center;
            width: 100%;
        }
    </style>
    <title>Document</title>
</head>
<body>
<div class="container mt-4">
    <h2>Корзинка</h2>
    <a class="btn btn-info mb-2" type="button" href="http://shop.uz.wschool.uz/admin/product.php"> Админ редактироват</a>
    <a class="btn btn-info mb-2" type="button" href="http://shop.uz.wschool.uz/korzinka.php"> Корзинка </a>
    <a class="btn btn-info mb-2" type="button" href="https://shop/index.php"> Главная</a>
    <table class="table table-dark">
        <thead>
        <tr>
            <th>Продукты</th>
            <th>Оптовый Цена</th>
            <th>Категории</th>
            <th>Добавить в корзину по оптималном цена</th>
        </tr>
        </thead>
        <tbody>
        <form action="korzinka.php" method="GET">
            <?php
                foreach ($korzinka as $model){
                    if (isset($model)){?>
                    <tr>

                        <td><?=$model['name']?></td>
                        <td><?=$model['optPrice']?> Рубл</td>
                        <?php foreach ($categories as $category){
                            if ($category['id']==$model['category']){?>
                                <td><?=$category['name']?></td>
                            <?php }
                        } ?>
                        <td><a href="korzinka.php?id=<?=$model['id']?>" class="btn btn-success" type="submit">Удалит из корзинку</a></td>
                    </tr>
                <?php }
                }?>
        </form>
        </tbody>
    </table>
</div>
</body>
</html>