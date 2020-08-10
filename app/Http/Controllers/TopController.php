<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class TopController extends Controller
{
    //
    public function index()
    {
        $item = $this->getItem();

        $cache = Cache::get('cache', '（キャッシュなし）');

        return view('welcome', compact('item', 'cache'));
    }

    public function post(Request $request)
    {
        $item = $this->getItem();
        $item->name = $request->input('name');
        $item->save();

        return redirect()->back();
    }

    private function getItem(): Item
    {
        return Item::firstOrCreate(['id' => 1], [
            'name' => 'AWSでLaravelのインフラを作る',
            'image' => '',
        ]);
    }

    public function uploadImage(Request $request)
    {
        $path = $request->file('file')->store('images', 'public');

        $item = $this->getItem();
        $item->image = $path;
        $item->save();

        return redirect()->back();
    }

    public function saveCache(Request $request)
    {
        Cache::put('cache', $request->input('cache'));

        return redirect()->back();
    }

    public function clearCache(Request $request)
    {
        Cache::forget('cache');

        return redirect()->back();
    }
}
