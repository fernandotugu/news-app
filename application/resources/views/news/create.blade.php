@extends('layouts.app')

@section('title', 'Cadastrar Notícia')

@section('content')

    <div class="max-w-2xl mx-auto">
        <news-create-form :categories='@json($categories)'></news-create-form>
    </div>

@endsection
