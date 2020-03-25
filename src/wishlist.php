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

    <button id="createButton">New wish</button>

    <?php if ($stmt->rowCount() > 0): ?>
        <table>
            <thead>
            <tr>
                <td>Wish</td>
                <td>Reference</td>
                <td>Additional information</td>
                <td>Priority</td>   <!---Temporary field---->
                <td>Edit</td>
                <td>Delete</td>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $stmt->fetch()): ?>
                <tr>
                    <td><?=$row['wish']?></td>
                    <td><a href="<?=$row['link']?>"><?=$row['link']?></td>
                    <td><?=$row['description']?></td>
                    <td><?=$row['priority']?></td>  <!---Temporary field---->
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

    <div id="wishModal" class="modal">
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
                <label for="priority">Priority:</label> <!---Temporary field---->
                <br>
                <input type="text" id="priority" name="priority">
                <input type="hidden" name="id">
                <input type="submit" name="update" id="update" value="Save">
                <input type="submit" name="add" id="add" value="Create">
            </form>
        </div>
    </div>

    <script src="wishlist.js"></script>
</body>
</html>
