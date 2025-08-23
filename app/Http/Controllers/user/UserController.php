<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class UserController extends Controller
{
    public function shop()
    {   
        $items = Item::paginate(12);
        return view('User.shop', compact('items'));
    }

    public function index()
    {
        $items = Item::with('category')->get();
        return view('User.cart', compact('items'));
    }

    public function storeInvoice(Request $request) 
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10|max:100',
            'postal_code' => 'required|digits:5',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function() use($request){
            $total = 0;
            $invoice = Invoice::create([
                'invoice_number' => 'INV-' . strtoupper(Str::random(6)),
                'shipping_address' => $request->shipping_address,
                'postal_code' => $request->postal_code,
                'total' => 0, // sementara, nanti update
            ]);

            foreach ($request->items as $item) 
            {
                $product = Item::find($item['product_id']);
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ]);
            }

            $invoice->update(['total' => $total]);
        });

        return redirect()->back()->with('success', 'Faktur berhasil dibuat!');
    }

    public function addToCart(Request $request, $id)
    {
        $product = Item::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) 
        {
            $cart[$id]['quantity'] += $request->qty ?? 1;
        } 
        else 
        {
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => $request->qty ?? 1,
                'price' => $product->price,
                'photo' => $product->photo,
                'category' => $product->category->name
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('shop')->with('success', 'Item berhasil ditambahkan ke cart!');
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item berhasil dihapus dari cart!');
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($request->cart as $id => $item) {
            if(isset($cart[$id])) {
                $cart[$id]['quantity'] = $item['quantity'];
            }
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Cart berhasil diperbarui!');
    }

}


