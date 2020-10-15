<?php
function Products() {
    $data = file_get_contents('./site/products.json');
    $data = json_decode($data, true);

    if (empty($data)) return;

    if (empty($_GET['id'])): 
        foreach ($data[$_GET['page']] as $product) {
            echo '
                <a href="' . $_SERVER['REQUEST_URI'] . $product['id'] . '/" class="katalog_item">
                    <img src="' . $product['img'] . '" alt="' . $product['title'] . '">
                    <h3>' . $product['title'] . '</h3>
                    <p>' . $product['price'] . '</p>
                </a>
            ';
        }
    else:
        $newID = $_GET['id'] - 1;
        $param = $data[$_GET['page']][$newID];
        echo '
        <div class="katalog_bot_solo_left">
            <img src="' . $param['img'] . '" alt="' . $param['title'] . '">
        </div>   
        <div class="katalog_bot_solo_right"> 
            <h2>' . $param['title'] . '</h2>
            <p>' . $param['description'] . '</p>
            <div class="price">' . $param['price'] . '</div>

            <form method="post">
                <button type="submit" name="' . $_GET['page'] . '" value="' . $_GET['id'] . '">Добавить в корзину</button>
            </form>
        </div>
        ';

    endif;
}


function addCart() {
    $cart = [];

    if (!empty($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
    }
    $index = $_GET['page'] . $_GET['id'];

    $cart[$index] = $_GET['id'];

    setcookie('cart',  json_encode($cart), time() + 86400, '/');

    // print_r($_POST);
    header('Location:' . $_SERVER['REQUEST_URI']);
    exit;   
}

function getCart() {
    $count = 0;

    if (!empty($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
        $count = count($cart);
    }

    echo $count;
}

function showCart() {
    $data = file_get_contents('./site/products.json');
    $data = json_decode($data, true);

    
        // Обновление корзины
    if (!isset($_COOKIE['cart_quantity'])):
        $cart_quantity = [];
    else: $cart_quantity = json_decode($_COOKIE['cart_quantity'], true);
    endif;


    if (isset($_POST['cart_update'])):
        setcookie('cart_quantity', json_encode($cart_quantity), time() - 10, '/');

        $number = 1;
        if (!empty($_POST['cart_quantity'])): 
            foreach ($_POST['cart_quantity'] as $index) {
                $cart_quantity[$number] = $index;
                $number ++;
            }
        endif;

        setcookie('cart_quantity', json_encode($cart_quantity), time() + 86400, '/');
    endif;

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';

    $cart = json_decode($_COOKIE['cart'], true);

    // echo '<pre>';
    // print_r($cart);
    // echo '</pre>';

    $count = 1;
    $price = 0;
    foreach ($cart as $key => $item) {    
        $newID = $item - 1;
        $newData = $data[mb_substr($key, 0, -1)][$newID];

        if (empty($cart_quantity[$count])):
            $int = 1;
        else: $int = $cart_quantity[$count];
        endif;
        echo '
        <div class="cart_bot_item">
            <div class="product_count">' . $count . '</div>
            <div class="product_img" style="background-image:url(' . $newData['img'] . ')"></div>
            <div class="product_name">' . $newData['title'] . '</div>
            <input type="number" name="cart_quantity[]" min="1" max="20" value="' . $int . '" />
            <div class="product_price">Цена: ' . (float)$newData['price'] * $int . '</div>        
        </div>
        ';

        $price += (float)$newData['price'] * $int;
        $count++;
    }
    
    
    echo '
        <div class="final_price">К оплате: <span>' . $price . '</span> руб.</div>
            <div class="buttons">
                <button class="btn1" name="cart_clear">Очистить корзину</button>
                <button class="btn2" name="cart_update" type="submit">Обновить</button>
                <button class="btn3" name="cart_order">Оформить заказ</button>
            </div>
    ';

}

function cartClear() {
    setcookie('cart_quantity', '', time() - 10, '/');
    setcookie('cart', '', time() - 10, '/');

    header('Location: /');
    exit;
    // echo '111';
}
?>
