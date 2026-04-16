@extends('layouts.app')

@section('content')

    <div class="max-w-6xl mx-auto pt-2">
        @php
            $from = $news->firstItem();
            $to = $news->lastItem();
            $total = $news->total();
        @endphp

        <h1 class="text-xl font-bold mb-4">
            {{ $total }} Resultados para a Busca: "{{ $query }}"
        </h1>

        <div class="mb-4 text-sm text-gray-600">
           <strong>Exibindo:</strong> {{ $from }} de {{ $to }}
        </div>

        @forelse($news as $item)
            <div class="bg-white p-4 mb-3 rounded shadow">

                <h2 class="font-bold text-lg">
                    {!! str_ireplace($query, "<mark>{$query}</mark>", e($item->title)) !!}
                </h2>

                <p class="text-sm text-gray-600">
                    <Strong>Categoria:</Strong> {!! str_ireplace($query, "<mark>{$query}</mark>", e($item->category->name)) !!}
                </p>

                <p class="text-sm text-gray-600">
                    {{ \Illuminate\Support\Str::limit($item->content, 140) }}
                </p>

                <a href="/news/{{ $item->uuid }}" class="text-blue-600">
                    Acessar
                </a>

            </div>
        @empty
            <p>Nenhuma notícia encontrada.</p>
        @endforelse

        <div class="mt-6">
            {{ $news->links() }}
        </div>

    </div>

@endsection
