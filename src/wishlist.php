<?php
/** @var array $variables */
/** @var PDOStatement $stmt */
$stmt = $variables['stmt'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Создаем свой Wishlist</title>
</head>
<body>
    <form action="/" method="POST">
        <h1>Welcome to the Wishlist!</h1>
        <?php if ($stmt->rowCount() === 0): ?>
            <p>You don't have any wishes yet. Please, create your first wish.</p>
        <?php endif; ?>
        <label for="wish">Wish:</label>
        <br>
        <input type="text" id="wish" name="wish" required>
        <br>
        <label for="link">Reference:</label>
        <br>
        <input type="text" id="link" name="link">
        <br>
        <label for="description">Additional information:</label>
        <br>
        <textarea id="description" name="description" rows="3" cols="40"></textarea>
        <br>
        <input type="submit" value="Create">
    </form>
    <?php
    if ($stmt->rowCount() > 0):
        ?>
        <h2>Wish list:</h2>
        <table border="1">
            <thead>
            <tr>
                <td>Wish</td>
                <td>Reference</td>
                <td>Additional information</td>
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
