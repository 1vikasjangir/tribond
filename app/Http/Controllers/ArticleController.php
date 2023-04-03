<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Blog;

class ArticleController extends Controller
{
    //
    public function index(Request $request, $slug=null) {
        session(['contact_hidden_csrf' => rand(1000, 9999)]);
        $categories = Category::with('posts')->where('status', '1')
            ->whereHas('posts', function ($query) {
                $query->where('status', "1");
            })->get();

        $blogs = Blog::query();

        if(isset($request->q) && $request->q != ''){
            $title = $request->q;
            $blogs->where('title','LIKE','%'.$title.'%')
            ->whereHas('categories', function ($query) {
                $query->where('status', "1");
            });
        }

        if(isset($request->q) && $request->q != ''){
            $title = $request->q;
            $blogs->orWhereHas('categories', function ($query) use ($title) {
                $query->where('status', "1")->where('title', 'like', '%'.$title.'%');
            });
        }
        $slugDetail = array();
        if (!$slug) {
            $blogs = $blogs->with('categories')->where('status', '1')
            ->whereHas('categories', function ($query) {
                $query->where('status', "1");
            })->paginate(config('article.number_of_pages.page_count'));
        } else {
            $blogs = $blogs->with('categories')->where('status', '1')
            ->whereHas('categories', function ($query) use ($slug){
                $query->where('status', "1")
                ->where("slug", $slug);
            })->paginate(config('article.number_of_pages.page_count'));
            $slugDetail = Category::where("slug", $slug)->first();
        }

        $topPosts = Blog::where('status', '1')
        ->whereHas('categories', function ($query) {
            $query->where('status', "1");
        })->latest('id')->take(5)->get();

        return view('frontend.blog', compact('categories', 'blogs', 'topPosts', 'slugDetail'));
    }

    public function show($id)
    {
        $blogDetail = Blog::with('categories', 'getMedia')->where('slug', $id)->where('status', "1")->first();

        if ($blogDetail) {
            $previous = Blog::where('id', '<', $blogDetail->id)->max('slug');

            $next = Blog::where('id', '>', $blogDetail->id)->min('slug');

            // get the related categories id of the $post
            $related_category_ids = $blogDetail->categories()->pluck('categories.id');

            // get the related post of the categories $related_category_ids
            $related_posts = Blog::whereHas('categories', function ($q) use($related_category_ids) {
                    $q->whereIn('category_id', $related_category_ids);
                })
                ->where('id', '<>', $blogDetail->id)
                ->take(4)
                ->paginate(10);

            $topPosts = Blog::where('status', '1')->latest('id')->take(5)->get();
        }
        $socialShare = \Share::currentPage($blogDetail->title
        )->facebook()
        ->twitter()
        ->linkedin();

        //p($previous); die;

        return view('frontend.blog-detail', compact('blogDetail', 'previous', 'next', 'related_posts', 'topPosts', 'socialShare'));
    }


    public function pageNotFound() {
        return view('frontend.errors.404');
    }
}
