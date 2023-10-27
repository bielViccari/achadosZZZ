<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Product, Category}; 

class CategoryController extends Controller
{
    public function store(Request $request) {
        $data = $request->all();

        Category::create($data);
        return redirect()->route('painel', compact('data'))->with('mensagem', 'Categoria criada com sucesso!');
    }

    public function destroy(string|int $id) {
        $category = Category::findOrFail($id);

        // Excluir os produtos relacionados
        $category->products()->delete();
    
        // Agora, exclua a categoria
        $category->delete();
    
        return redirect()->back()->with('mensagem', 'Categoria e produtos relacionados excluídos com sucesso!');
    }
}

