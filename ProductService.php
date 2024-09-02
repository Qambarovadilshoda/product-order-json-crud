<?php

//ProductService degan class yaratamiz u ProductInterface dan implementatsiya qiladi
class ProductService {
    //index metodi getProduct()metodidan olib barcha productlarni var_dump qiladi
    static public function index() {
        $products = self::getProducts();
        var_dump($products);
    }

    //show metodi $id parametrini qabul qiladi va kiritilgan id bo'yicha productni topib var_dump qiladi
    static public function show($id)
    {
        $products = self::getProducts();

        if (is_array($products)) {
            foreach ($products as $product) {
                if (isset($product['id']) && $product['id'] === $id) {
                    var_dump($product);
                }
            }
        }

        return null;
    }
    //create metodi $name , $price paramlarni qabul qilib json faylga yozadi
    static public function create($name, $price) {
        $products = self::getProducts();
    
        $newProduct = [
            "id" => uniqid(),// id yaratadi
            "name" => $name,
            "price" => $price
        ];
        $products[] = $newProduct; 
        file_put_contents('products.json', json_encode($products, JSON_PRETTY_PRINT));
    }

    static public function update($id, $newName, $newPrice) {

        //json formatdan arrayga otkzamiz
        $products = self::getProducts();
        $productFound = false;

        //array boylab sikl aylantiramiz
        foreach ($products as $key=>$product) {

            //product idsi bor bo'lsa va u parametrdan kelayotgan idga teng bo'lsa yangilaymiz
            if (isset($product['id']) && $product['id'] === $id) {
                $products[$key]['id'] = $id;
                $products[$key]['name'] = $newName;
                $products[$key]['price'] = $newPrice;
                $productFound = true;
                break;
            }
        }
        //id topilmasa mahsulot topilmadi degan xabar chiqariladi
        if (!$productFound) {
            echo "Product not found.";
        }
        //yangilangan massivi yana json faylga yozamiz
        file_put_contents('products.json', json_encode($products, JSON_PRETTY_PRINT));   
    }

        static public function delete($id) {
            $products = json_decode(file_get_contents('products.json'), true);
            $productFound = false;
        
            foreach ($products as $key => $product) {
                //product idsi bor bo'lsa va u parametrdan kelayotgan idga teng bo'lsa o'chiramiz
                if (isset($product['id']) && $product['id'] == $id) {
                    unset($products[$key]); 
                    $productFound = true;
                    break;
                }
            }
            //paramdan kelayotgan id dagi mahsulot topilmasa ↓ xabari chop etamiz
            if (!$productFound) {
                echo 'Product not found';
                return;
            }
            //yana json fayliga saqlimz
            file_put_contents('products.json', json_encode($products, JSON_PRETTY_PRINT));
        }
        // getProducts metodi json_decode qiladi va arrayni qaytaradi
        static public function getProducts()
        {
            $products = json_decode(file_get_contents('products.json'), true);
            return $products;
        }
}

// ProductService::create("Olma", 100000);
// ProductService::update('66b35fe130eba', 'Olma yangilandi', 110000);
// ProductService::delete('66b35fe130eba');
// ProductService::create("Nok", 200000);
// ProductService::update('66b1c4cb4f104', 'Nok yangilandi', 220000);
// ProductService::delete('66b1c4cb4f104');
// ProductService::create("Qovun", 300000);
// ProductService::create("Banan",400000);
// ProductService::update('66b1c4cb4f3a0', 'Qovun yangilandi', 330000);
// ProductService::delete('66b1c4cb4f3a0');
// ProductService::show('66b1c4cb4f042');
// ProductService::index();

?>