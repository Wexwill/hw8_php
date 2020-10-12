<?php 
require_once './site/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/media.css">
    <title>Fumer.by</title>
</head>
<body>
 		
    <div class="header">
        <div class="container">
    

            <div class="header_left">
                <div class="logo">
                    <a href="/"><img src="/images/logo1.jpg" alt="Company logo"></a>
                </div>
                <div class="site">
                    <p>
                        Fumer.by
                    </p>
                </div>
            </div>

            <div class="header_right">
                <div class="info">
                    <h3>Контактная информация:</h3>
                    <p>
                        Телефон: +375 33 660-08-33<br>
                        Эл. почта: info@Fumerhookah.by
                    </p>
                </div>
                <a class="cart" href="/cart/">
                    <?php if (isset($_COOKIE['cart'])): ?>
                    <div class="number"><?php getCart() ?></div>
                    <?php endif; ?>
                </a>
            </div>

        </div>	
    </div>