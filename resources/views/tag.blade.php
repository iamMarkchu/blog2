@extends('layouts.app')

@section('content')
<main class="container">
    <div class="row">
        <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">标签：{{ $tag->tag_name }}</div>
                    <div class="panel-body">
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
                </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default tag-panel aside-panel">
            <div class="panel-heading"><h3 class="panel-title">相关类别</h3></div>
            <div class="panel-body">
                @if(!empty($related_categories))
                    @foreach($related_categories as $category)
                        <a href="" class="btn btn-primary btn-sm">{{ $category->category_name }}</a>
                    @endforeach
                @endif
            </div>
        </div>
        </div>
    </div>
</main>
@endsection