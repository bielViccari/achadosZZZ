<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('lista de funcionalidades disponíveis') }}
        </h2>
    </x-slot>

    @if (Session::has('mensagem'))
        <script>
            Swal.fire({
                position: 'top',
                icon: 'success',
                title: '{{ Session::get('mensagem') }}',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            Swal.fire({
                position: 'top',
                icon: 'error',
                title: '{{ Session::get('mensagem') }}',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between ">
                    <a id="openModalButton" class="pr-4" href="#">Criar nova categoria</a>


                    <!-- Modal -->
                    <div id="myModal" class="modal hidden fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50">
                        <div class="modal-content bg-white w-1/2 mx-auto my-10 p-4">
                            <!-- Conteúdo do Modal -->
                            <p class="text-xl font-semibold mb-4">Crie uma nova categoria</p>
                            <form action="{{ route('category.store') }}" method="post">
                                @csrf
                                <div class="mb-3 space-y-2 w-full text-xs">
                                    <label class="font-semibold text-gray-600 py-2">Nome da categoria <abbr
                                            title="required">*</abbr></label>
                                    <input placeholder="Ex:... Camiseta"
                                        class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
                                        required="required" type="text" name="category">
                                    <p class="text-red text-xs hidden">Por favor preencha este campo</p>
                                </div>
                                <button
                                    class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                    type="submit">Criar</button>
                                <button id="closeModalButton"
                                    class="mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Cancelar
                                </button>
                            </form>
                            <!-- Botão para fechar o modal -->
                        </div>
                    </div>

                    <script>
                        // JavaScript para manipular a exibição do modal
                        document.getElementById('openModalButton').addEventListener('click', function() {
                            document.getElementById('myModal').classList.remove('hidden');
                        });

                        document.getElementById('closeModalButton').addEventListener('click', function() {
                            document.getElementById('myModal').classList.add('hidden');
                        });
                    </script>

                    <a id="openModalButton2" href="#">Apagar categoria</a>
                    <!-- Modal -->
                    <div id="myModal2" class="modal hidden fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50">
                        <div class="modal-content bg-white w-1/2 mx-auto my-10 p-4">
                            <!-- Conteúdo do Modal -->
                            <p class="text-xl font-semibold mb-4">Apagar Categoria</p>
                            <small>Selecione somente uma categoria, ao clicar ela será apagada !</small>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach ($category as $c)
                                <form id="deleteCategoryForm" action="{{ route('category.destroy', $c->id) }}" method="post" class="bg-white p-4 shadow rounded">
                                    @csrf
                                    @method('delete')
                                
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" name="opcao" value="{{ $c->id }}" class="mr-2">
                                        <label for="checkbox" class="block font-semibold">{{ $c->category }}</label>
                                    </div>
                                
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 h-7 rounded flex items-center">Apagar</button>
                                </form>
                                @endforeach
                            </div>
                            <button id="closeModalButton2" type="button"
                                class="mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </button>
                        </div>
                    </div>

                    <script>
                        // Adicionando um evento de clique ao botão
                        document.getElementById('enviar').addEventListener('click', function() {
                            // Encontrando a checkbox marcada
                            var checkboxMarcada = document.querySelector('input.opcao-checkbox:checked');
                    
                            // Verificando se alguma checkbox está marcada
                            if (checkboxMarcada) {
                                // Obtendo o valor da checkbox marcada
                                var valorCheckbox = checkboxMarcada.value;
                    
                                // Redirecionando para a rota com o valor como parâmetro
                                window.location.href = "{{ route('category.destroy', " + valorCheckbox + ") }}";
                            } else {
                                alert('Selecione uma opção antes de enviar.');
                            }
                        });
                    </script>

                    <script>
                        // JavaScript para manipular a exibição do modal
                        document.getElementById('openModalButton2').addEventListener('click', function() {
                            document.getElementById('myModal2').classList.remove('hidden');
                        });

                        document.getElementById('closeModalButton2').addEventListener('click', function() {
                            document.getElementById('myModal2').classList.add('hidden');
                        });
                    </script>


                    <a class="pr-4" href="{{ route('products.create') }}">Cadastrar novo produto</a>
                    <a class="pr-4" href="#">Alterar imagens da página inicial</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold leading-tight py-2">
                Listagem dos produtos
                <a href="{{ route('products.create') }}" class="bg-blue-900 rounded-full text-white px-4 text-sm">+</a>
            </h1>

            <form action="{{ route('painel.search') }}" method="post" class="flex items-center">
                @csrf
                <input type="text" name="query" placeholder="Pesquisar"
                    class="flex-grow bg-gray-200 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                <button
                    class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Pesquisar</button>
                <a href="{{ route('painel') }}" class="cursor-pointer py-2 px-4 rounded">Limpar</a>
            </form>

            @if (Session::has('error'))
                <script>
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: '{{ Session::get('error') }}',
                        showConfirmButton: false,
                        timer: 2000
                    });
                </script>
            @endif
        </div>
        <table class="min-w-full leading-normal shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Nome
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Descrição
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Editar
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Detalhes
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Apagar
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product as $p)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <img src="{{ url("storage/{$p->image}") }}" alt="{{ $p->name }}"
                                class="object-cover w-20">
                            {{ $p->name }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $p->description }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a href="{{ route('products.edit', $p->id) }}"
                                class="bg-green-200 rounded-full py-2 px-6">Editar</a>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <a target="_blank" href="{{ $p->link }}"
                                class="bg-orange-200 rounded-full py-2 px-6">Detalhes</a>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <form id="deleteForm" action="{{ route('products.delete', $p->id) }}" method="post">
                                @method('delete')
                                @csrf
                                <button id="deleteButton" type="button"
                                    data-url="{{ route('products.delete', $p->id) }}"
                                    class="bg-red-200 rounded-full py-2 px-6">Apagar</button>
                            </form>

                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const deleteButton = document.getElementById('deleteButton');
                                    const deleteForm = document.getElementById('deleteForm');

                                    deleteButton.addEventListener('click', function() {
                                        Swal.fire({
                                            title: 'Tem certeza?',
                                            text: 'Esta ação não pode ser revertida!',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Sim, excluir!',
                                            cancelButtonText: 'Cancelar',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // Use a função submit do formulário para enviar manualmente
                                                deleteForm.submit();
                                            }
                                        });
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Exibir links de paginação -->
        {{ $product->links('pagination::tailwind') }}
    </div>
</x-app-layout>
