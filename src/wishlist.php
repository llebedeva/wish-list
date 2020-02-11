<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Создаем свой Wishlist</title>
</head>
<body>
    <form action="/" method="POST">
        <h1>Добро пожаловать в ваш личный Wishlist!</h1>
        <p>Здесь вы можете создать свой собственный список желаний. Это поможет вам лучше разобраться в себе и понять
            чего вы действительно хотите. Также вы сможете поделиться списком с друзьями, если захотите.</p>
        <p>Для начала заполните форму ниже чтобы создать ваше первое желание:</p>
        <label for="wish">Желание:</label>
        <br>
        <input type="text" id="wish" name="wish" required>
        <br>
        <label for="link">Ссылка на продукт или услугу:</label>
        <br>
        <input type="text" id="link" name="link">
        <br>
        <label for="description">Дополнительная информация:</label>
        <br>
        <textarea id="description" name="description" rows="3" cols="40"></textarea>
        <br>
        <input type="submit" value="Создать">
    </form>
    <?php
    // Wish table
    use App\Storage\Storage;
    $storage = new Storage();
    $stmt = $storage->getWishTable();
    if ($stmt->rowCount() > 0):
        ?>
        <h2>Список желаний:</h2>
        <table border="1">
            <thead>
            <tr>
                <td>Желание</td>
                <td>Ссылка</td>
                <td>Дополнительная информация</td>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $stmt->fetch()): ?>
                <tr>
                    <td><?=$row['wish'];?></td>
                    <td><a href="<?=$row['link'];?>"><?=$row['link'];?></a></td>
                    <td><?=$row['description'];?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php
    endif;
    ?>
</body>
</html>
