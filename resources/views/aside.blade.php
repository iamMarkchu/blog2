<div class="col-md-3">
        <div class="panel panel-default aside-panel">
            <div class="panel-heading"><h3 class="panel-title">热门文章</h3></div>
            <div class="panel-body">
                暂时没有数据
            </div>
        </div>
        <div class="panel panel-default tag-panel aside-panel">
            <div class="panel-heading"><h3 class="panel-title">热门标签</h3></div>
            <div class="panel-body">
                @foreach($tags as $tag)
                <a href="" class="btn btn-success btn-sm">{{ $tag->tag_name }}</a>
                @endforeach
            </div>
        </div>
            <div class="panel panel-default aside-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">最新文章</h3>
                </div>
                <div class="panel-body">
                    暂时没有数据
                </div>
        </div>
</div>