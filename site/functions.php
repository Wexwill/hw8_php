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

    setcookie('cart',  json_encode($cart), time() + 86400);

    print_r($_POST);
    // header('Location:' . $_SERVER['REQUEST_URI']);
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
        echo '
        <div class="cart_bot_item">
            <div class="product_count">' . $count . '</div>
            <div class="product_img" style="background-image:url(' . $newData['img'] . ')"></div>
            
            <div class="product_name">' . $newData['title'] . '</div>
            <div class="product_price">Цена: ' . $newData['price'] . '</div>
         
        </div>
        ';

        $price += (float)$newData['price'];
        $count++;
    }

    echo '
        <div class="final_price">К оплате: <span>' . $price . '</span> руб.</div>
    ';
}