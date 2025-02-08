<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Like;
use Auth;
use Illuminate\Http\Request;
use Validator;

class BlogController extends Controller
{
    public function blog()
    {

        return view('user.blog');
    }

    public function createBlog(Request $request)
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'image' => $request->input('id') ? '' : 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()], 422);

        $blog = Blog::find($request->input('id'));
        if ($request->image != null) {
            $extension = $request->image->extension();
            $filename = "product_" . time() . "." . $extension;
            $request->image->storeAs('public/images', $filename);
        }

        $user = Auth::user();

        Blog::updateOrCreate([
            'id' => $request->input('id')
        ], [
            'user_id' => $user->id,
            'title' => $request->title,
            'content' => $request->content,
            'image' => !isset($request->image) && $blog ? $blog->image : $filename,
        ]);

    }

    public function editBlog($id)
    {
        $blog = Blog::where('id', $id)->first();
        $data = [
            'blog' => $blog
        ];

        return view('user.blog', $data);
    }
    public function deleteBlog(Request $request)
    {
        $blog = Blog::where('id', $request->input('id'))->first();
        $blog->delete();
        return response()->json(['message' => 'Blog deleted successfully'], 200);
    }


    public function toggleLike(Request $request)
    {
        $blogId = $request->input('blog_id');
        $blog = Blog::findOrFail($blogId);
        $userId = auth()->id();

        $existingLike = Like::where('user_id', $userId)->where('blog_id', $blogId)->first();

        if ($existingLike) {
            $existingLike->delete();
            $isLiked = false;
        } else {
            Like::create([
                'user_id' => $userId,
                'blog_id' => $blogId,
            ]);
            $isLiked = true;
        }

        return response()->json([
            'success' => true,
            'is_liked' => $isLiked,
            'likes_count' => $blog->likes->count(),
        ]);
    }

    public function search()
    {
        $search = request()->input('search');
        $blogs = Blog::where('title', 'LIKE', "%{$search}%")->paginate(3);

        return view('user.home', compact('blogs', 'search'));
    }

    public function show($id)
    {
        $blog = Blog::with('user', 'likes')->findOrFail($id);
        return view('user.readMore', compact('blog'));
    }

    public function comment(Request $request)
    {

        $rules = [
            'blog_id' => 'required',
            'comment' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'comment.required' => 'You cannot post empty comment'
        ]);
        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()], 422);

        $comment = Comment::create([
            'blog_id' => $request->input('blog_id'),
            'user_id' => Auth::user()->id,
            'comment' => $request->input('comment'),
        ]);

        return response()->json([
            'success' => true,
            'username' => Auth::user()->name,
            'comment' => $comment->comment
        ]);
    }

}
