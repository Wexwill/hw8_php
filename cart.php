<?php 
require_once './site/header.php';
require_once './site/navigation.php';
require_once './site/functions.php';
?>

<div class="katalog boxshadow3">
    <div class="container"> 

        <div class="katalog_top">   
            <h1>Корзина товаров</h1>
        </div>

        <div class="cart_bot">

            <?php 
            if (function_exists('showCart') && !empty($_COOKIE['cart'])):
                showCart();   
            else:
                header('Location: /');
            endif;
            ?>

        </div>


    </div>
</div>


<?php
require_once './site/footer.php';


