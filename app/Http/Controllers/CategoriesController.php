<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;
class CategoriesController extends Controller
{
    //

    public function show(Category $category,TopicRequest $request)
    {
        $topics = Topic::withOrder($request->order)->where('category_id',$category->id)->paginate(30);
        return view('topics.index',compact('topics','category'));
    }
}
