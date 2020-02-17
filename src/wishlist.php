<?php
/** @var array $variables */
/** @var PDOStatement $stmt */
/** @var string|null $id */
$stmt = $variables['stmt'];
$id = $variables['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Wishlist</title>
</head>
<body>
    <form action="/" method="POST">
        <h2>I wish...</h2>
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
        <input type="submit" name="add" value="Create">
    </form>
    <?php if ($stmt->rowCount() > 0): ?>
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
                <form action="/" method="POST">
                <?php if ($id===$row['id']):?>
                    <tr>
                        <td><input type="text" name="wish" value="<?=$row['wish'];?>"></td>
                        <td><input type="text" name="link" value="<?=$row['link'];?>"></td>
                        <td><input type="text" name="description" value="<?=$row['description'];?>"></td>
                        <td><input type="hidden" name="hidden" value="<?=$row['id'];?>"></td>
                        <td><input type="submit" name="update" value="Save"></td>
                        <td><input type="submit" name="cancel" value="Cancel"></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?=$row['wish'];?></td>
                        <td><a href="<?=$row['link'];?>"><?=$row['link'];?></td>
                        <td><?=$row['description'];?></td>
                        <td><input type="hidden" name="hidden" value="<?=$row['id'];?>"></td>
                        <td><input type="submit" name="edit" value="Edit"></td>
                        <td><input type="submit" name="delete" value="Delete"></td>
                    </tr>
                <?php endif; ?>
                </form>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
