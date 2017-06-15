@extends('layouts.app')

@section('content')
<main class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default article-panel">
            <div class="panel-body my-markdown-editor">
                <h1 class="panel-title text-center">{{ $article->title }}</h1>
                {!! $article->htmlContent !!}
            </div>
        </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default" data-spy="affix" data-offset-top="0" data-offset-bottom="10" style="width: 250px;">
                    <div class="panel-heading"><h3 class="panel-title">目录</h3></div>
                    <div class="panel-body" id="my-menu">
                        <ol class="nav">
                        @foreach($headers as $order => $header)
                                <li><a href="#{{ $header['title'] }}">{{ $loop->index+1 }}.{{ $header['title'] }}</a></li>
                                @if (!empty($header['h3']))
                                <ul class="">
                                    @foreach($header['h3'] as $h3)
                                        <li><a href="#{{ $h3 }}">{{ $h3 }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                        @endforeach
                        </ol>
                    </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('page_css')
<link rel="stylesheet" href="http://cdn.bootcss.com/highlight.js/9.10.0/styles/solarized-dark.min.css">
@endsection
@section('page_js')
<script src="http://cdn.bootcss.com/highlight.js/9.10.0/highlight.min.js"></script>
<script>
        $(function(){
            $('pre code').each(function(i, block) {
                hljs.highlightBlock(block);
            });
        });
</script>
@endsection