<?php 
require("data/login.php");
$login=new Login();
$login->log();
?>
<!DOCTYPE html>
<html lang="js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="memo/add/css/index.css">
    <title>contents</title>
</head>
<body>
    <header>
        <button>
            <span></span>
            <span></span>
            <span></span>
            <ul>
                <li id="del">del</li>
                <li id="task">task</li>
                <li id="favorite">favorite</li>
            </ul>
        </button>
        <span id="login">login</span>
    </header>
    <main>
        <section>
            <a href="#"><div>training</div></a>
        </section>
        <section>
            <ul>
                <li></li>
                <li></li>
                <li id="add"><a href="memo/public/add.php">add</a></li>
                <li id="edit"><a href="memo/public/edit.php">edit</a></li>
            </ul>
            <a href="../index.html"><span>TopPage</span></a>
        </section>
    </main>
    <script src="data/login.js"></script>
</body>
</html>