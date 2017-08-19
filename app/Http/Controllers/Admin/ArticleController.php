<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Article::with('category', 'tags')->paginate($request->input('limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Article::rules());
        $article = new Article;
        $article->category_id = $request->category_id;
        $article->user_id = Auth::id();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->display_order = $request->display_order;
        $article->status = 'republish';
        $article->source = $request->source;
        $article->click_count = 0;
        $article->vote_count = 0;
        $article->save();
        if($request->has('tag_ids') & !empty($request->tag_ids))
        {
            $article->tags()->attach($request->tag_ids);
        }

        return response()->json($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Article::with('tags')->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, Article::rules($id));
        $article = Article::with('tags')->find($id);
        $article->category_id = $request->category_id;
        $article->title = $request->title;
        $article->content = $request->content;
        $article->display_order = $request->display_order;
        $article->source = $request->source;

        if($request->has('tag_ids'))
        {
            if(!empty($request->tag_ids))
            {
                $article->tags()->sync($request->tag_ids);
            }else{
                $article->tags()->detach();
            }
        }
        $article->save();
        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article= Article::find($id);
        $article->status = 'deleted';
        $article->save();
        return response('1');
    }

    public function status(Request $request, $id)
    {
        if($request->has('status'))
        {
            $article= Article::find($id);
            $article->status = $request->status;
            $article->save();
            return response('1');
        }else{
            return response('0', 422);
        }
    }
}
