<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Category;
use App\Tag;
use Parsedown;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public function __construct()
    {
        $categories = Category::orderBy('display_order')->limit(5)->get();
        View::share('categories', $categories);
    }
    public function home()
    {
        //$categories = Category::;
        $tags = Tag::orderBy('display_order', 'desc')->limit(20)->get();
        $articles = Article::with(['tags', 'category'])->where('status', 'active')->orderBy('click_count', 'desc')->limit(20)->get();
        $data['articles'] = $articles;
        $data['tags'] = $tags;
        //$data['categorys'] = $categories;
        return view('home', $data);
    }
    public function article($id)
    {
        $article = Article::with(['tags', 'category'])->find($id);
        $parsedown = new ParseDown;
        $article->htmlContent = $parsedown->text($article->content);
        $regex = '/<h(2|3)>(.*?)<\/h(2|3)>/';
        preg_match_all($regex, $article->htmlContent, $match);
        $headers = [];
        if(!empty($match[1]))
        {
            $count_h2 = $count_h3 = 0;
            foreach ($match[1] as $k => $v) {
                if($v == 2)
                {
                    $headers['h2_'.($count_h2+1)]['title'] = $match[2][$k];
                    $last_h2 = $count_h2;
                    $count_h2++;
                    $count_h3 = 0;
                }else{
                    $headers['h2_'.($last_h2+1)]['h3'][]= $match[2][$k];
                    $count_h3++;
                }
            }
        }
        $article->htmlContent = preg_replace('/\<h(2|3)>(.*?)<\/h(2|3)>/', '<h$1 id="$2">$2</h$1>', $article->htmlContent);
        $data['article'] = $article;
        $data['headers'] = $headers;
        return view('article', $data);
    }
    public function category($id)
    {
        $category = Category::find($id);
        $articles  = Article::where([
                                ['status', 'active'],
                                ['category_id', $id]
                            ])
                            ->orderBy('display_order')
                            ->get();
        $tag_list = [];
        foreach ($articles as $article) {
            foreach ($article->tags as $tag) {
                if(!isset($tag_list[$tag->id]))
                    $tag_list[$tag->id] = $tag;
            }
        }
        $data['category'] = $category;
        $data['articles'] = $articles;
        $data['related_tags'] = $tag_list;
        return view('category', $data);
    }
    public function tag($id)
    {
        $tag = Tag::find($id);
        $articles = $tag->articles()->get();
        $category_list = [];
        foreach ($articles as $article) {
            if(!isset($category_list[$article->category_id]))
                $category_list[] = $article->category;
        }
        $data['tag'] = $tag;
        $data['articles'] = $articles;
        $data['related_categories'] = $category_list;
        return view('tag', $data);
    }
}
