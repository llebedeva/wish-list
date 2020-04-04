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

    <?php if ($stmt->rowCount() > 0): ?>
    <div id="list" class="list-group col">
        <?php while ($row = $stmt->fetch()): ?>
        <div class="list-group-item">
            <input type="hidden" name="priority" value="<?=$row['priority']?>">
            <div><?=$row['wish']?></div>
            <div><a href="<?=$row['link']?>"><?=$row['link']?></a></div>
            <div><?=$row['description']?></div>
            <div>
                <button name="edit" class="inline">Edit</button>
                <form action="/" method="POST" class="inline">
                    <input type="hidden" name="id" value="<?=$row['id']?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>

    <button id="createButton">New wish</button>

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
    <script type="module" src="drag&drop.js"></script>
</body>
</html>
