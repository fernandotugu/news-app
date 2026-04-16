@extends('layouts.app')

@section('title', $news->title)

@section('content')

    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

        <h1 class="text-2xl font-bold mb-2">
            {{ $news->title }}
        </h1>

        <div class="text-sm text-gray-500 mb-4">
            Categoria:
            <span class="font-semibold">
            {{ $news->category->name ?? 'Sem categoria' }}
        </span>
            |
            Publicado em:
            <span>
            {{ $news->published_at?->format('d/m/Y H:i') ?? 'Não publicado' }}
        </span>
        </div>

        <div class="text-gray-700 leading-relaxed">
            {{ $news->content }}
        </div>

        <div class="mt-6">
            <a href="javascript:history.back()" class="text-sm text-blue-600 hover:underline">
                ← Voltar
            </a>
        </div>

    </div>

@endsection
