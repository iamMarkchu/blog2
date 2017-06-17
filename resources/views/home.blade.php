@extends('layouts.app')

@section('content')
<main class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                @foreach($articles as $article)
                    <div class="col-md-4">
                            <div class="panel panel-default home-recommand-block">
                                <div class="panel-heading">
                                    <a href="{{ route('article', ['id' => $article->id ])}}"><img src="/default_logo.jpg" alt="" class="img-responsive"></a>
                                </div>
                                <div class="panel-body">
                                    <h3><a href="{{ route('article', ['id' => $article->id ])}}">{{ $article->title }}</a></h3>
                                </div>
                            </div>
                    </div>
                @endforeach
            </div>
        </div>
        @include('aside', ['tags' => $tags])
    </div>
</main>
@endsection
