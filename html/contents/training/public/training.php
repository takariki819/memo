<?php 
require("../../data/training_data.php");
$tr=new Training();
$tr->training();
new token_set();
$training_menu=$tr->get_training_column();
array_shift($training_menu);
array_pop($training_menu);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../add/index.css">
    <title>training</title>
</head>
<body>
    <header>
        <div><img src="../../img/goku2.png"></div>
        <div id="new">new</div>
        <div id="history">history</div>
    </header>
    <main>
        <ul>
            <?php foreach($training_menu as $training): ?>
                <li>
                    <span class="menu"><?=$training;?></span>
                    <span><input type="number"></span>
                </li>
            <?php endforeach; ?>
            <button>register</button>
        </ul>
    </main>
    <script src="../add/index.js"></script>
    <script src="../add/history.js"></script>
</body>
</html>