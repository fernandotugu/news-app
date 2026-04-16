@extends('layouts.app')

@section('title', 'Notícias')

@section('content')

    <news-list :initial-news='@json($initialNews)' />

@endsection
