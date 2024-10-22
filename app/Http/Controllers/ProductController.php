<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(){

        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create(){
        return view('products.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Armazenar a imagem se houver
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }
    
        $product = Product::create($validatedData);
        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }

    public function edit($id){
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $product = Product::find($id);
    
        // Verificar se uma nova imagem foi enviada
        if ($request->hasFile('image')) {
            // Excluir a imagem antiga se existir
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Armazenar a nova imagem
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }
    
        $product->update($validatedData);
        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id){
        $product = Product::find($id);
        
        // Excluir a imagem do produto se existir
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index');
    }

    public function cardapio(){

        $products = Product::all();
        return view('products.cardapio', compact('products'));
    }
}
