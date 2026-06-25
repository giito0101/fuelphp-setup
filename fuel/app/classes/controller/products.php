<?php

use Fuel\Core\Response;
use Fuel\Core\Format;
use Fuel\Core\Controller;
use Fuel\Core\Validation;
use Fuel\Core\Log;

class Controller_Products extends Controller
{
    public function before()
    {
        header('Access-Control-Allow-Origin: http://localhost:5173');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit;
        }
    }

    public function action_index()
    {
        $products = Model_Product::find('all');
        return $this->json_response($products);
    }

    public function action_view($id)
    {
        $product = Model_Product::find((int) $id);
        if (!$product) {
            return $this->json_response(array('error' => 'Product not found'), 404);
        }
        return $this->json_response($product);
    }

    public function action_create()
    {
        $products = Model_Product::find('all');
        $data = json_decode(file_get_contents('php://input'), true);

        $val = Validation::forge();

        $val->add('name', '商品名')
            ->add_rule('required')
            ->add_rule('max_length', 250);

        $val->add('price', '価格')
            ->add_rule('required')
            ->add_rule('valid_string', ['numeric'])
            ->add_rule('numeric_min', 1);

        $val->add('stock', '在庫数')
            ->add_rule('required')
            ->add_rule('valid_string', ['numeric'])
            ->add_rule('numeric_min', 0);

        $val->add('description', '商品説明')
            ->add_rule('max_length', 500);  

        if (!$val->run($data)) {
            return $this->json_response(array('errors' => [
                'name' => $val->error('name') ? $val->error('name')->get_message() : null,
                'price' => $val->error('price') ? $val->error('price')->get_message() : null,
                'stock' => $val->error('stock') ? $val->error('stock')->get_message() : null,
                'description' => $val->error('description') ? $val->error('description')->get_message() : null,
            ]), 422);
        }

        $newProduct = [
            'name' => $data['name'],
            'price' => (int) $data['price'],
            'stock' => (int) $data['stock'],
            'description' => $data['description'],
        ];

        $product = Model_Product::forge($newProduct);
        $product->save();

        return $this->json_response($newProduct, 201);
    }

    private function json_response($data, $status = 200)
    {
        return Response::forge(
            Format::forge($data)->to_json(),
            $status,
            array(
                'Content-Type' => 'application/json',
            )
        );
    }
}
