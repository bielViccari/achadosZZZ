<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;  
use App\Models\{Product, Category}; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{


    public function index(Product $product, Category $category) {
        $product = Product::latest()->paginate(15);
        $category = Category::get()->all();
        return view('admin/dashboard', compact('product', 'category'));
    }

    public function searchAsAdmin(Request $request, Category $category) {
        $query = $request->input('query');
        $category = Category::get()->all();
        if ($request && trim($query) !== '') {

            $product = Product::where('name', 'like', '%' . $query . '%')->latest()->paginate(10);
            if ($product->isEmpty()) {
                return redirect()->back()->with('error', 'Nenhum Produto Encontrado...');
            }
            return view('admin/dashboard', compact('product', 'category'));
        } else {
            return redirect()->back();
        }
    }


    public function search(Request $request, Category $category) {
        $category = Category::get()->all();
        $query = $request->input('query');
        if($query && trim($query) !== '') {
            
            $product = Product::where('name', 'like', '%' . $query . '%')->latest()->paginate(10);
            if ($product->isEmpty()) {
                return redirect()->back()->with('error', 'nenhum produto encontrado...');
            }
            return view('welcome', compact('product', 'category'));
        } else {
            return redirect()->back();
        }
    }

    public function indexGuest(Product $product, Category $category) {
        $product = Product::latest()->paginate(15);
        $category = Category::get()->all();
        return view('welcome', compact('product','category'));
    }

    public function filter(Request $request, Category $category) {
        $category = Category::get()->all();
        $filter = $request->input('filter');
  
            $product = Product::where('category_id', $filter)->latest()->paginate(10);
            if ($product->isEmpty()) {
                return redirect()->back()->with('error', 'nenhum produto encontrado, voltando a página inicial...');
            }
            return view('welcome', compact('product','category'));
    }



    //retorna a view de formulário para criação do produto
    public function create(Category $category) {
        $categoria = Category::get()->all();
        return view('products.create', compact('categoria'));
    }



    //Persiste os dados do formulário de produtos no BD
    public function store(ProductRequest $request) {
        $data = $request->all();

        $numeroComVirgula = $request->input('amount');
        if (strpos($numeroComVirgula, ',') !== false) {
            // Se houver vírgula, substitua por ponto
            $numeroComPonto = str_replace(',', '.', $numeroComVirgula);
        } else {
            // Se não houver vírgula, use o número como está
            $numeroComPonto = $numeroComVirgula;
        }
        $data['amount'] = $numeroComPonto;

        if($request->image) {
            $data['image'] = $request->image->store('products');
        }

        $data['category_id'] = $request->input('category');
        Product::create($data);
        return redirect()->route('painel')->with('mensagem', 'Produto cadastrado com sucesso');
    }



    public function show(string|int $id) {

        if (!$product = Product::find($id)) {
            return redirect()->back()->with('mensagem', 'Produto não encontrado');
        };
        return view('products.show', compact('product'));
    }



    public function destroy(string|int $id) {
        if(!$product = Product::find($id)) {
            return redirect()->back()->with('mensagem', 'Produto não encontrado');
        }

        $product->delete();
        return redirect()->route('painel')->with('mensagem', 'Produto deletado com sucesso');
    }



    public function edit(string|int $id, Category $category) {
        if (!$product = Product::find($id)) {
            return redirect()->route('painel')->with('mensagem', 'Produto não encontrado');
        }

        $category = Category::get()->all();

        return view('products.edit', compact(['product','category']));
    }



    public function update(string|int $id, ProductRequest $request) {
        // Validar os dados do formulário
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'link' => 'required|url',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adapte conforme necessário
        ]);
    
        // Buscar o produto
        $product = Product::find($id);
    
        if (!$product) {
            return redirect()->back()->with('error', 'Produto não encontrado');
        }
    
        // Excluir a imagem antiga, se existir
        if ($request->hasFile('image') && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }
    
        // Fazer o upload da nova imagem, se fornecida
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $imagePath = $uploadedFile->store('products');
            $product->image = $imagePath;
        }
    
        // Atualizar os outros dados
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->amount = $request->input('amount');
        $product->link = $request->input('link');
    
        // Salvar as alterações no banco de dados
        $product->save();
    
        return redirect()->route('painel')->with('mensagem', 'Produto atualizado com sucesso');
    }
}

