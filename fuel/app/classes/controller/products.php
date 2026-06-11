<?php

use Fuel\Core\Response;
use Fuel\Core\Format;
use Fuel\Core\Controller;
use Fuel\Core\Input;

class Controller_Products extends Controller
{
    private $products = array(
        array(
            'id' => 1,
            'name' => 'Laptop',
            'price' => 999.99,
            'stock' => 10,

        ),
        array(
            'id' => 2,
            'name' => 'Smartphone',
            'price' => 499.99,
            'stock' => 20,
        ),
    );

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
        return $this->json_response($this->products);
    }

    public function action_view($id)
    {
        foreach ($this->products as $product) {
            if ($product['id'] === (int) $id) {
                return $this->json_response($product);
            }
        }

        return $this->json_response(array('error' => 'Product not found'), 404);
    }

    public function action_create()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $newProduct = [
            'id' => count($this->products) + 1,
            'name' => $data['name'],
            'price' => (int) $data['price'],
            'stock' => (int) $data['stock'],
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
