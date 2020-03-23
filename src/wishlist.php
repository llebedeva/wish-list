<?php
/** @var array $variables */
/** @var PDOStatement $stmt */
$stmt = $variables['stmt'];
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

    <!--     Wish table -->
    <?php if ($stmt->rowCount() > 0): ?>
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
                    <td><?=$row['wish']?></td>
                    <td><a href="<?=$row['link']?>"><?=$row['link']?></td>
                    <td><?=$row['description']?></td>
                    <td>
                        <button name="edit">Edit</button>
                    </td>
                    <td>
                        <form action="/" method="POST">
                            <input type="hidden" name="id" value="<?=$row['id']?>">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!--    Modal form  -->
    <div id="modal" class="modal">
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
                <input type="hidden" name="id">
                <input type="submit" name="update" id="update" value="Save">
                <input type="submit" name="add" id="add" value="Create">
            </form>
        </div>
    </div>
    <script src="wishlist.js"></script>
</body>
</html>
