<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
         
        //Item::create($request->all());
        //return redirect()->route('items.index');

        // Hanya masukkan atribut yang diizinkan
         Item::create($request->only(['name', 'description']));
        return redirect()->route('items.index')->with('success', 'Item added successfully.');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
         
        //$item->update($request->all());
        //return redirect()->route('items.index');
        // Hanya masukkan atribut yang diizinkan
         $item->update($request->only(['name', 'description']));
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        
       // return redirect()->route('items.index');
       $item->delete();
       return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
