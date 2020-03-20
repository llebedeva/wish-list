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
    <link rel="stylesheet" type="text/css" href="wishlist.css">
    <title>Wishes</title>
</head>
<body>
    <h2>I wish...</h2>
    <?php if ($stmt->rowCount() === 0): ?>
        <p>You don't have any wishes yet. Please, create your first wish.</p>
    <?php endif; ?>

    <!--    Create button -->
    <button id="createButton">New wish</button>

    <!--    Modal form  -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="/" method="POST">
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
                <input type="submit" name="add" value="Yes, I wish this">
            </form>
        </div>
    </div>

    <!--     Wish table -->
    <?php if ($stmt->rowCount() > 0): ?>
<!--        <h2>Wish list:</h2>-->
        <table id="wishTable" border="1">
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
                        <td><input type="hidden" name="id" value="<?=$row['id'];?>"></td>
                        <td><input type="submit" name="update" value="Save"></td>
                        <td><input type="submit" name="cancel" value="Cancel"></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?=$row['wish'];?></td>
                        <td><a href="<?=$row['link'];?>"><?=$row['link'];?></td>
                        <td><?=$row['description'];?></td>
                        <td><input type="hidden" name="id" value="<?=$row['id'];?>"></td>
                        <td><input type="submit" name="edit" value="Edit"></td>
                        <td><input type="submit" name="delete" value="Delete"></td>
                    </tr>
                <?php endif; ?>
                </form>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <script src="wishlist.js"></script>
</body>
</html>
