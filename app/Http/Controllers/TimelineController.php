<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Notifications\UserMentioned;
use Illuminate\Support\Facades\Auth;


class TimelineController extends Controller
{
    public function postToTimeline(Request $request)
    {

        if (!auth()->check()) {
            return redirect()->route('log')->with('error', 'You must be logged in to upload PICTURES.');
        }
        $request->validate([
            'text' => 'required|string',
            'image' => 'required|image|max:50000', // Adjust max file size as needed
        ]);

        $imagePath = time() . '.' . $request->file('image')->extension();

        $request->file('image')->move(public_path('image'), $imagePath);


        $post = new Post;
        $post->user_id = auth()->id();
        $post->text = $request->text;
        $post->image_path = $imagePath;
        $post->save();

        // Extract mentions from post text
        preg_match_all('/@([\w\s]+)/', $post->text, $matches);
        $mentionedUsers = User::whereIn('name', array_map('trim', $matches[1]))->get();

        // Attach mentions to post
        $post->mentions()->attach($mentionedUsers->pluck('id'));

        // Notify mentioned users
        foreach ($mentionedUsers as $user) {
            $user->notify(new UserMentioned($user, $post));
        }


        return redirect()->back()->with('success', 'Post created successfully but wait for the approval from Admin');
    }


    public function showPictures()
    {
        // Fetch all posts ordered by creation date
        $posts = Post::orderByDesc('created_at')->get();

        // Filter only approved posts
        $posts = $posts->where('status', 'approved');

        return view('pictures', ['posts' => $posts]);
    }


    public function delete(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully!');
    }


    public function like(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        if (!$user->likedPictures()->where('post_id', $id)->exists()) {
            $user->likedPictures()->attach($id);
        }

        return redirect()->back()->with('success', 'Picture liked .');
    }

    public function unlike(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        if ($user->likedPictures()->where('post_id', $id)->exists()) {
            $user->likedPictures()->detach($id);
        }

        return redirect()->back()->with('success', 'Picture Unliked.');
    }


    public function updateCaption(Request $request, $id)
    {
        $request->validate([
            'caption' => 'required|string|max:255',
        ]);

        $post = Post::findOrFail($id);
        $post->text = $request->caption;
        $post->save();

        return redirect()->back()->with('success', 'Caption updated successfully.');
    }


}
