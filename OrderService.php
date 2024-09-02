<?php

class OrderService {
    static public function index($productId){
        var_dump(self::getProduct($productId));
        $orders = self::getOrders();
        if(is_array($orders)){
            foreach($orders as $order){
                if(isset($order['productId']) && $order['productId'] === $productId){
                    $orderArray[] = $order;
                }
            }
            foreach($orderArray as $orderArr){
                var_dump($orderArr);
            }
        }
    }
    static public function show($id){
        $orders = self::getOrders();
        if(is_array($orders)){
            foreach($orders as $order){
                if(isset($order['id']) && $order['id'] === $id){
                    var_dump($order);
                    break;
                }
            }
        }
        $product = self::getProduct($order['productId']);
        var_dump($product);
    }
    static public function create($productId, $quantity) {
        $product = self::getProduct($productId);
    
        if (!$product) {
            die('Product not found');
        }
    
        $totalPrice = $quantity * $product['price'];
        $newOrder = [
            "id" => uniqid(),
            "productId" => $productId,
            "total_price" => $totalPrice
        ];
    
        $orders = self::getOrders(); 
        $orders[] = $newOrder; 
    
        file_put_contents('orders.json', json_encode($orders, JSON_PRETTY_PRINT));
    }
    static public function update($id, $productId, $quantity){
        $product = self::getProduct($productId);
    
        if (!$product) {
            die('Product not found');
        }
    
        $totalPrice = $quantity * $product['price'];
        $orders = self::getOrders();
        $orderFound = false;
    
        foreach ($orders as $key => $order) {
            if (isset($order['id']) && $order['id'] === $id) {
                $orders[$key]['id'] = $id;
                $orders[$key]['productId'] = $productId;
                $orders[$key]['total_price'] = $totalPrice;
                $orderFound = true;
                break;
            }
        }
    
        if (!$orderFound) {
            die("Order not found.");
        }
    
        file_put_contents('orders.json', json_encode($orders, JSON_PRETTY_PRINT));
    }
    static public function delete($id){
        $orders = self::getOrders();
        $orderFound = false;
            foreach ($orders as $key => $order) {
                if (isset($order['id']) && $order['id'] === $id) {
                    unset($orders[$key]);
                    $orderFound = true;
                    break;
                }

            }
        if (!$orderFound) {
            echo 'Product not found';
            return;
        }
        file_put_contents('orders.json', json_encode($orders, JSON_PRETTY_PRINT));
    }
    static public function getOrders(){
        $orders = json_decode(file_get_contents("orders.json"), true);
        if(is_array($orders)){
            return $orders;
        }
    }
    static public function getProduct($productId){
        $products = json_decode(file_get_contents('products.json'), true);
        $productFound = false;
        if (is_array($products)) {
            foreach ($products as $product) {
                if (isset($product['id']) && $product['id'] === $productId) {
                    $productFound = true;
                    return $product;
                }
            }
        }
        if(!$productFound){
            die('Product not found');
        }

    }
}
// OrderService::getProduct('66b3c822ae4a2');
// OrderService::create('66b3c822ae3d7',4);
// OrderService::create('66b3c822ae4a2',2);
// OrderService::create('66b3c822ae517',2);
// OrderService::update('66b3ca43365df','66b3caac9d1f1',2);
// OrderService::delete('66b3ca4336739');
OrderService::index('66b3c822ae3d7');
// OrderService::show('66b3ca43366ab');


