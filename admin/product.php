<?php
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'shop';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error){
    echo 'not connected'.$conn->connect_error;
}
if ($_SERVER['REQUEST_METHOD']=='POST'){
    if ( $_POST['name'] ==!null && $_POST['price'] ==!null && $_POST['optPrice'] ==!null && $_POST['category_id'] ==!null) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        $optPrice = $_POST['optPrice'];
        $sql = "INSERT INTO product(name, price, category_id, optPrice) VALUES ('$name', $price, $category_id, $optPrice)";
        if ($conn->query($sql)) {
            echo "<span class='badge badge-success'>Продукт добавлено</span>";
        } else {
            echo "<span class='badge badge-danger'>Продукт не добавлено" . $conn->error . "</span>";
        }
    } else {
    echo "<span class='badge badge-danger'>Заполните все поля".$conn->error."</span>";
    }
}
$category = "SELECT * FROM category";
if ($result = $conn->query($category)){
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $categories[]=$row;
        }
    }
    else{
        echo "<span class='badge badge-danger'>нет продукты</span>";
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
    <title>Document</title>
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
</head>
<body>
    <div class="container mt-4">
        <ul style="display: flex; list-style: none; justify-content: center" >
            <li><a class="btn btn-success mr-2" href="http://shop/index.php">Главное</a></li>
            <li><a class="btn btn-info mr-2" href="http://shop/admin/product.php">Продукт</a></li>
            <li><a class="btn btn-info" href="http://shop/admin/category.php">Категории<a/></li>
        </ul>
        <form action="product.php" class="form-group" method="post">
            <label for="">Продукть</label>
            <input type="text" name="name" class="form-control mb-2" placeholder="Продукть">
            <input type="integer" name="price" class="form-control mb-2" placeholder="Цена">
            <input type="integer" name="optPrice" class="form-control mb-2" placeholder="Оптовый Цена">
            <label for="">Категории</label>
            <select class="form-control mb-4" name="category_id">
                <?php foreach ($categories as $category){?>
                <option name="" value="<?=$category['id']?>"><?=$category['name']?></option>
                <?php }?>
            </select>
            <button type="text"  class="btn btn-success ">Создать</button>
        </form>
    </div>
</body>
</html>
