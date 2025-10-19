@extends('layouts.app')

@section('content')
    <!-- PAGE HERO -->
    <section class="relative py-10 bg-gradient-to-br from-orange-50 to-white">
        <div class="container mx-auto px-4 md:px-8">
            <div class="text-center mb-8 animate-fade-in">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 text-gray-800">{{ $page->title }}</h1>
            </div>
        </div>
    </section>

    <!-- PAGE CONTENT -->
    <section class="py-10 bg-white">
        <div class="container mx-auto px-4 md:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="prose prose-lg max-w-none">
                    {!! Purifier::clean($page->content) !!}
                </div>
            </div>
        </div>
    </section>
@endsection