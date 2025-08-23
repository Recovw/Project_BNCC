<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


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
        $cart = session()->get('cart', []); 
        return view('User.cart', compact('items', 'cart'));
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Cart kosong, tidak bisa checkout!');
        }
        return view('User.checkout', compact('cart'));
    }

    public function storeInvoice(Request $request) 
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10|max:100',
            'postal_code' => 'required|digits:5',
        ]);

        DB::transaction(function() use($request){
            $cart = session()->get('cart', []);
            $total = 0;

            $invoice = Invoice::create([
                'invoice_number' => 'INV-' . strtoupper(Str::random(6)),
                'shipping_address' => $request->shipping_address,
                'postal_code' => $request->postal_code,
                'total' => 0, 
            ]);

            // Masukkan item dari cart ke tabel invoice_items
            foreach ($cart as $id => $item) {
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ]);
            }

            $invoice->update(['total' => $total]);

            session()->forget('cart');
        });

        return redirect()->route('checkout')->with('success', 'Invoice berhasil dibuat!');
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

    public function invoices()
    {
        $invoices = Invoice::latest()->get();

        return view('User.invoices', compact('invoices'));
    }

    public function showInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $items = InvoiceItem::where('invoice_id', $id)->get();

        return view('User.showInvoice', compact('invoice', 'items'));
    }


}


