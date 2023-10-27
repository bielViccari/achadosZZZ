<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cadastrar produto</title>

    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <x-app-layout>

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="relative min-h-screen flex items-center justify-center bg-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 bg-gray-500 bg-no-repeat bg-cover relative items-center"
                style="background-image: url(https://images.unsplash.com/photo-1511556820780-d912e42b4980?auto=format&fit=crop&q=80&w=1287&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D);">
                <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
                <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg z-10">
                    <div class="grid  gap-8 grid-cols-1">
                        <div class="flex flex-col ">
                            <div class="flex flex-col sm:flex-row items-center">
                                <h2 class="font-semibold text-lg mr-auto">Editando o produto - {{ $product->name }}</h2>
                                <div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
                            </div>
                            <div class="mt-5">
                                <div class="form">
                                    <div class="md:space-y-2 mb-3">
                                        <label class="text-xs font-semibold text-gray-600 py-2">Imagem do produto<abbr
                                                class="hidden" title="required">*</abbr></label>
                                        <div class="flex items-center py-6">
                                            <div class="w-30 h-30 mr-4 flex-none rounded-xl border overflow-hidden">
                                                <img id="oldImage" class="w-20 h-20 mr-4 object-cover"
                                                    src="{{ url('storage/', $product->image) }}" alt="Avatar Upload">
                                                <img id="previewImagem" class="w-40 h-40"
                                                    src="{{ url("storage/{$product->image}") }}" alt="Imagem Padrão"
                                                    style="display: none;">
                                            </div>
                                            <label class="cursor-pointer">
                                                <span
                                                    class="focus:outline-none text-white text-sm py-2 px-4 rounded-full bg-green-400 hover:bg-green-500 hover:shadow-lg">Procurar</span>
                                                <input type="file" id="inputImagem" name="image" class="hidden"
                                                    :multiple="multiple" :accept="accept">
                                            </label>
                                        </div>
                                    </div>
                                    <script>
                                        const inputImagem = document.getElementById('inputImagem');
                                        const previewImagem = document.getElementById('previewImagem');
                                        const oldImage = document.getElementById('oldImage');
                                        inputImagem.addEventListener('change', function() {
                                            if (inputImagem.files.length > 0) {
                                                // O usuário escolheu um arquivo, exibir a imagem selecionada
                                                const file = inputImagem.files[0];
                                                const reader = new FileReader();
                                                oldImage.style.display = 'none';
                                                reader.onload = function(e) {
                                                    previewImagem.src = e.target.result;
                                                    previewImagem.style.display = 'inline-block';
                                                };

                                                reader.readAsDataURL(file);
                                            } else {
                                                // O usuário não escolheu um arquivo, exibir a imagem padrão
                                                previewImagem.style.display = 'none';
                                            }
                                        });
                                    </script>

                                    <div class="md:flex flex-row md:space-x-4 w-full text-xs">
                                        <div class="mb-3 space-y-2 w-full text-xs">
                                            <label class="font-semibold text-gray-600 py-2">Nome do produto <abbr
                                                    title="required">*</abbr></label>
                                            <input value="{{ $product->name }}" placeholder="Ex:... Relógio"
                                                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
                                                required="required" type="text" name="name">
                                            <p class="text-red text-xs hidden">Por favor preencha este campo</p>
                                        </div>
                                        <div class="mb-3 space-y-2 w-full text-xs">
                                            <label class="font-semibold text-gray-600 py-2">Valor <abbr
                                                    title="required">*</abbr></label>
                                            <input value="{{ $product->amount }}" placeholder="Ex:... 19.99"
                                                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4"
                                                required="required" type="text" name="amount">
                                            <p class="text-red text-xs hidden">Por favor preencha este campo</p>
                                        </div>
                                    </div>
                                    <div class="mb-3 space-y-2 w-full text-xs">
                                        <label class=" font-semibold text-gray-600 py-2">Link do produto</label>
                                        <div class="flex flex-wrap items-stretch w-full mb-4 relative">
                                            <div class="flex">
                                                <span
                                                    class="flex items-center leading-normal bg-green-500 border-1 rounded-r-none border border-r-0 border-blue-300 px-3 whitespace-no-wrap text-grey-dark text-sm w-12 h-10 bg-blue-300 justify-center items-center  text-xl rounded-lg text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <input type="text" name="link" value="{{ $product->link }}"
                                                class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border border-l-0 h-10 border-grey-light rounded-lg rounded-l-none px-3 relative focus:border-blue focus:shadow"
                                                placeholder="https://">
                                        </div>
                                    </div>
                                    <div class="md:flex md:flex-row md:space-x-4 w-full text-xs">
                                        <div class="w-full flex flex-col mb-3">
                                            <label class="font-semibold text-gray-600 py-2">Categoria<abbr
                                                    title="required">*</abbr></label>
                                            <select
                                                class="block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg h-10 px-4 md:w-full "
                                                required="required" name="category">
                                                @foreach ($category as $c)
                                                    <option value="{{ $c->id }}">{{ $c->category }}</option>
                                                @endforeach
                                            </select>
                                            <p class="text-sm text-red-500 hidden mt-3" id="error">Por favor
                                                preencha esta campo.</p>
                                        </div>

                                    </div>

                                    <div class="flex-auto w-full mb-1 text-xs space-y-2">
                                        <label class="font-semibold text-gray-600 py-2">Descrição</label>
                                        <textarea required="" name="description" id="description"
                                            class="w-full min-h-[100px] max-h-[300px] h-28 appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded-lg  py-4 px-4"
                                            placeholder="Coloque as Informações do produto" spellcheck="false">{{ $product->description }}</textarea>
                                        <p id="charCount" class="text-xs text-gray-400 text-left my-3">Você inseriu 0
                                            caracteres</p>
                                    </div>

                                    <script>
                                        const textarea = document.getElementById('description');
                                        const charCount = document.getElementById('charCount');

                                        textarea.addEventListener('input', function() {
                                            const currentCharCount = textarea.value.length;
                                            charCount.textContent =
                                                `Você inseriu ${currentCharCount} caractere${currentCharCount !== 1 ? 's' : ''}, max permitido: 10000`;
                                        });
                                    </script>

                                    <p class="text-xs text-red-500 text-right my-3">Campos obrigatórios estarão
                                        marcados com <abbr title="Required field"> * </abbr></p>
                                    <div class="mt-5 text-right md:space-x-3 md:block flex flex-col-reverse">
                                        <button
                                            class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100"><a
                                                href="{{ route('painel') }}">Cancelar</a></button>
                                        <button
                                            class="mb-2 md:mb-0 bg-green-400 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-500">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </x-app-layout>
</body>

</html>
