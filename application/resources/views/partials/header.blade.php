<header class="fixed top-0 left-0 right-0 h-16 bg-gray-200 border-b z-50">

    <div class="max-w-6xl mx-auto h-full flex items-center justify-between px-4">

        <div class="font-bold text-lg">
            LOGO
        </div>

        <div class="flex items-center gap-6">

            <a href="{{ route('news.create') }}" class="text-sm hover:opacity-70">
                Cadastrar Notícias
            </a>

            <a href="{{ route('news.index') }}" class="text-sm hover:opacity-70">
                Exibir Notícias
            </a>

            <div class="relative w-64">

                <form method="GET" action="/news/search" class="relative w-64">
                    <input
                        name="q"
                        class="w-full rounded-full pl-4 pr-10 py-2 border text-sm"
                        placeholder="Buscar..."
                    />

                    <button type="submit"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                        🔍
                    </button>
                </form>

            </div>

        </div>

    </div>

</header>
