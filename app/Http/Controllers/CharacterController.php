<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use App\Models\Post;

class CharacterController extends Controller
{
    public function index_my(Character $character)
    {
        return view('characters.index')->with(['posts' => $character->getByCharacter()]);
    }
    
    public function index_vs(Character $character)
    {
        return view('characters.index')->with(['posts' => $character->getByCharacter_vs()]);
    }
    
    public function search(Request $request, Character $character)
    {
        $search_my = $request->input('search_my');
        
        return view('posts.search')->with(['characters' => $character->get(), 'search_my' => $search_my]);
        
    }
    
    public function search_my(Request $request, Character $character)
    {
        $search_my = $request['search_my'];
        
        $posts = Post::whereHas('character', function ($query) use ($search_my) {
            $query->where('id', $search_my);
        })->orderBy('updated_at', 'DESC')->paginate(15);
        
        return view('characters.index', 
        [
            'posts' => $posts
        ])->with(['characters' => $character->get()]);
    }
    
    public function search_vs(Request $request, Character $character)
    {
        $search_vs = $request['search_vs'];
        
        $posts = Post::whereHas('character_vs_character', function ($query) use ($search_vs) {
            $query->where('id', $search_vs);
        })->orderBy('updated_at', 'DESC')->paginate(15);
        
        return view('characters.index', 
        [
            'posts' => $posts
        ])->with(['characters' => $character->get()]);
    }
    
    // public function search_myvs(Request $request, Character $character)
    // {
    //     $search_my = $request['search_my'];
    //     $search_vs = $request['search_vs'];
        
    //     $posts_my = Post::whereHas('character', function ($query) use ($search_my) {
    //         $query->where('id', $search_my);
    //     });
            
    //     $posts_vs = Post::whereHas('character_vs_character', function ($query) use ($search_vs) {
    //         $query->where('id', $search_vs);
    //     });
        
    //     $posts = Post::
        
    //     return view('characters.index', 
    //     [
    //         'posts' => $posts
    //     ])->with(['characters' => $character->get()]);
    // }
}
