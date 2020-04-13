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
    <div id="list" class="list-group col">
        <?php while ($row = $stmt->fetch()): ?>
        <div class="list-group-item">
            <div><?=$row['wish']?></div>
            <div><a href="<?=$row['link']?>"><?=$row['link']?></a></div>
            <div><?=$row['description']?></div>
            <div>
                <input type="hidden" name="id" value="<?=$row['id']?>">
                <button name="edit">Edit</button>
                <button name="delete">Delete</button>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>

    <div id="wishModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3></h3>
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
            <button id="update">Save</button>
            <button id="add">Create</button>
        </div>
    </div>

    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p></p>
            <button name="ok">Ok</button>
            <button name="cancel">Cancel</button>
        </div>
    </div>

    <script type="module" src="wishlist.js"></script>
    <script type="module" src="drag&drop.js"></script>
</body>
</html>
