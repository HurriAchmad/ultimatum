<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('user')->get();
        return view('welcome', compact('posts'));
    }

    public function post($id) {
        $post = Post::with('user')->firstWhere('id', $id);
        return view('post', compact('post'));
    }

    public function editor_create() {
        return view('editor');
    }

    public function insert(Request $request) {
        function makeCode($length = 6):string {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return env('ARCHIVE_PREFIX').$randomString;
        }

        $post = new Post();
        $user = Auth::user();

        $post->title = $request->title;
        $file        = $request->file('thumbnail');
        $filename    = makeCode(10) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/', $filename);
        $post->thumbnail = 'public/' . $filename;
        $post->content = $request->contents;
        $post->user()->associate($user);
        $post->save();

        return response()->json(array('t'=>'y'));
    }

    public function edit($id) {
        $post = Post::with('user')->firstWhere('id', $id);
        return view('editor', compact('post'));
    }

    public function update(Request $request) {
        function makeCode($length = 6):string {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_()@';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return env('ARCHIVE_PREFIX').$randomString;
        }

        $post = Post::with('user')->firstWhere('id', $request->id);
        $file        = $request->file('thumbnail');
        $filename    = makeCode(10) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/', $filename);
        $post->title = $request->title;
        $post->thumbnail = 'public/' . $filename;
        $post->content = $request->contents;
        $post->save();
        return response()->json(array('t'=>'y'));
    }

    public function delete($id) {
        $post = Post::with('user')->firstWhere('id', $id);
        $post->delete();
        return redirect()->back();
    }

    public function print($id) {
        $post = Post::with('user')->firstWhere('id', $id);
        return view('print', compact('post'));
    }

    public function routeImg(Request $request) {
        $temp = explode(".", $_FILES["image_param"]["name"]);
        $extension = end($temp);
        $name = sha1(microtime()).".".$extension;
        move_uploaded_file($_FILES["image_param"]["tmp_name"],"".$name);
        $response = (object)null;
        $response->link = "".$name;
        echo stripslashes(json_encode($response));
    }
}
