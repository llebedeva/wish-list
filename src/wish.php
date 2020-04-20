<?php
/** @var array $variables */
/** @var PDOStatement $stmt */
$stmt = $variables['stmt'];
$row = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/wishlist.css">
    <title>Wish: </title>
</head>
<body>
    <h2>Wish: <?=$row['wish']?></h2>

    <div id="wishItem" class="list-group-item">
        <div><?=$row['wish']?></div>
        <div><a href="<?=$row['link']?>"><?=$row['link']?></a></div>
        <div><?=$row['description']?></div>
        <div>
            <input type="hidden" name="wish" value="<?=$row['wish']?>">
            <input type="hidden" name="link" value="<?=$row['link']?>">
            <input type="hidden" name="description" value="<?=$row['description']?>">
            <input type="hidden" name="id" value="<?=$row['id']?>">
            <button name="edit">Edit</button>
            <button name="delete">Delete</button>
        </div>
    </div>

    <a id="back" href="/">Back to wishlist</a>

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

    <script type="module" src="../js/wish.js"></script>
</body>
</html>
