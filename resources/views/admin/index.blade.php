<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-semibold leading-tigh py-2">
        Listagem dos produtos
        <a href="{{ route('products.create') }}" class="bg-blue-900 rounded-full text-white px-4 text-sm">+</a>
    </h1>
    

    <form action="" method="get" class="py-5">
        <input type="text" name="search" placeholder="Pesquisar" class="md:w-1/6 bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
        <button class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Pesquisar</button>
    </form>
    
    <table class="min-w-full leading-normal shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr>
              <th
                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
              >
                Nome
              </th>
              <th
                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
              >
                Descrição
              </th>
              <th
                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
              >
                Editar
              </th>
              <th
                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
              >
                Detalhes
              </th>
              <th
                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider"
              >
                Apagar
              </th>
            </tr>
          </thead>
          <tbody>
        @foreach ($product as $p)
            <tr>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <img src="{{ url("storage/{$p->image}") }}" alt="{{ $p->name }}" class="object-cover w-20">
                    {{ $p->name }}
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $p->description }}</td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <a href="{{ route('products.edit', $p->id) }}" class="bg-green-200 rounded-full py-2 px-6">Editar</a>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                    <a href="{{ route('products.show', $p->id) }}" class="bg-orange-200 rounded-full py-2 px-6">Detalhes</a>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                   <form action="{{ route('products.delete', $p->id) }}" method="post">
                    @method('delete')
                    @csrf
                   <button type="submit" ><a class="bg-red-200 rounded-full py-2 px-6">Apagar</a></button>
                   </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>