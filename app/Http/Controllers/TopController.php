<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TopController extends Controller
{
    //
    public function index()
    {
        $item = $this->getItem();

        return view('welcome', compact('item'));
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
}
