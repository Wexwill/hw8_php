<?php 
require_once './site/header.php';
require_once './site/navigation.php';
require_once './site/functions.php';
?>

<div class="katalog boxshadow3">
    <div class="container"> 
        <div class="katalog_top">   
            <h1>Аксессуары</h1>
        </div>
        <?php if (empty($_GET['id'])): ?>

            <div class="katalog_bot"> 
                <?php if (function_exists('Products')):
                    Products(); 
                endif; ?>
            </div>

        <?php else: ?>

            <div class="katalog_bot_solo">
                <?php if (function_exists('Products')):
                    Products(); 
                endif; 
                // echo '<pre>';
                // print_r($_COOKIE);
                // echo '</pre>';

                if (isset($_POST[$_GET['page']])) addCart();
                ?>
            </div>

        <?php endif; ?>
    </div>
</div>
    
<?php
require_once './site/footer.php';
