<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Category;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function showCreate()
    { 
        $categories = Category::all(); 
        return view('Admin.createItem', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(Request $req) 
    { 
        $validated = $req->validate([ 
            'name' => 'required|string|max:255', 
            'category_id' => 'required|exists:categories,id', 
            'price' => 'required|numeric|min:0', 
            'stock' => 'required|integer|min:0', 
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048', 
        ], 
        [ 
            'name.required' => 'The name must be filled!', 
            'category_id.required' => 'The category must be filled!', 
            'price.required' => 'The price cannot be empty!', 
            'stock.required' => 'The stock cannot be empty!', 
            'image.required' => 'Image is required!', 
        ]); 
    
        $imagePath = $req->file('image')->store('items', 'public'); 
        Item::create([ 
            'name' => $validated['name'], 
            'category_id' => $validated['category_id'], 
            'price' => $validated['price'], 
            'stock' => $validated['stock'], 
            'image' => $imagePath, 
        ]); 
        return back(); 
    }

    public function createCategory(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], 
        [
            'name.required' => 'Category name is required!',
            'name.unique' => 'This category already exists!',
        ]);

        Category::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('createItem')->with('success', 'Category created successfully!');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $items = Item::with('category')->get();
        $categories = Category::all();

        return view('admin.listItems', compact('items', 'categories'));
    }

    public function showByCategory($id)
    {   
        $items = Item::with('category')->where('category_id', $id)->get();
        $categories = Category::all();
        $category = Category::find($id);

        return view('admin.listItems', compact('items', 'categories', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::findOrFail($id); 

        return view('updateItems', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
        $validated = $req->validate([ 
            'name' => 'required|string|min:5|max:80', 
            'category_id' => 'required|exists:categories,id', 
            'price' => 'required|numeric|min:0', 
            'stock' => 'required|integer|min:0', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ], 
        [ 
            'name.min' => 'The name must be atleast 5 letters',
            'name.max' => 'The name cannot exceed 80 letters',
            'name.required' => 'The name must be filled!', 
            'category_id.required' => 'The category must be filled!', 
            'price.required' => 'The price cannot be empty!', 
            'stock.required' => 'The stock cannot be empty!', 
        ]); 
        
        $item = Item::findOrFail($id);
        $data = $req->only([
            'name', 
            'category_id', 
            'price', 
            'stock'
        ]); 
        
        if ($req->hasFile('image'))
        { 
            $path = $req->file('image')->store('items', 'public'); 
            $data['image'] = $path; 
        } 
        
        $item->update($data); 
        
        return redirect()->route('seeItems')->with('success', 'Item updated successfully');
    }

    public function showUpdate($id)
    {
        $item = Item::findOrFail($id);
        return view('Admin.updateItem', compact('item'));
    }   

    /**
     * Remove the specified resource from storage.
     */
    public function destroyItem($id)
    {
        $item = Item::findOrFail($id);

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('seeItems')->with('success', 'Item deleted successfully!');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

}
