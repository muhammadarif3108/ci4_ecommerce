<?php
// app/Controllers/Cart.php
namespace App\Controllers;

class Cart extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Shopping Cart',
            'cart' => session()->get('cart') ?? []
        ];

        return view('cart', $data);
    }

    public function add()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity') ?? 1;

        $productModel = new \App\Models\ProductModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image' => $product['image']
            ];
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart')->with('success', 'Product added to cart');
    }

    public function update()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]);
            }
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart')->with('success', 'Cart updated');
    }

    public function remove($productId)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->set('cart', $cart);

        return redirect()->to('/cart')->with('success', 'Product removed from cart');
    }

    public function clear()
    {
        session()->remove('cart');
        return redirect()->to('/cart')->with('success', 'Cart cleared');
    }
}
