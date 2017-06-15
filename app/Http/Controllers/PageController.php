<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Category;
use App\Tag;
use Parsedown;

class PageController extends Controller
{
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
}
