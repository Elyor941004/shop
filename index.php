<?php
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'shop';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    echo 'not connected'.$conn->connect_error;
}
$sql = "Select * from product";
if ($result = $conn->query($sql)){
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    } else {
        echo "<span class='badge badge-danger'>0 results</span>";
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
        echo "<span class='badge badge-danger'>нет продукты</span>";
    }
}
if ($_SERVER['REQUEST_METHOD']=='POST' && $_POST['korzinka']){
    $product_id = $_POST['korzinka'];
    foreach ($products as $product){
        if ($product['id']==$product_id){
            $name = $product['name'];
            $optprice = $product['optPrice'];
            $category = $product['category_id'];
        }
    }
    $korzinka = "INSERT INTO korzinka(name, optPrice, category) VALUES ('$name', $optprice, $category)";
    if ($conn->query($korzinka)){
        echo "<span class='badge badge-success'>в корзинке 1 штук добавлено</span>";
    }else{
        echo "<span class='badge badge-danger'>не добавлено</span>";
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
        <h2>Продукты</h2>
        <a class="btn btn-info mb-2" type="button" href="https://shop/admin/product.php"> Админ редактироват</a>
        <a class="btn btn-info mb-2" type="button" href="https://shop/korzinka.php"> Корзинка </a>
        <a class="btn btn-info mb-2" type="button" href="https://shop/index.php"> Главная</a>
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>Продукты</th>
                    <th>Оптовый Цена</th>
                    <th>Цена</th>
                    <th>Категории</th>
                    <th>Добавить в корзину по оптималном цена</th>
                </tr>
            </thead>
            <tbody>
                <form action="index.php" method="POST">
                    <?php foreach ($products as $product){?>
                    <tr>
                        <td><?=$product['name']?></td>
                        <td><?=$product['optPrice']?> Рубл</td>
                        <td><?=$product['price']?> Рубл</td>
                        <?php foreach ($categories as $category){
                            if ($category['id']==$product['category_id']){?>
                                <td><?=$category['name']?></td>
                        <input name="korzinka" type="hidden" value="<?=$product['id']?>">
                            <?php }
                        } ?>
                        <td><button class="btn btn-success" type="submit">Добавить в корзину</button></td>
                    </tr>
                    <?}?>
                </form>
            </tbody>
        </table>
    </div>
</body>
</html>