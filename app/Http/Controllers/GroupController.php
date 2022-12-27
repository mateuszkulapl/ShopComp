<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return view('group.index', [
            'groups' => Group::latest()->with('oldestProduct', 'latestPriceWeekRange','oldestProduct.oldestImage')->paginate(20)
        ]);
    }

    public function getShowView(Group $group)
    {
        return view('group.show', [
            'group' => $group,
            'products' => $group->products()->with('shop', 'prices', 'images')->get()
        ]);
    }

    public function show(Group $group, String $oldestProductTitleSlug = '')
    {
        $correctOldestProductTitleSlug = Str::slug($group->oldestProduct->title);
        if ($correctOldestProductTitleSlug == $oldestProductTitleSlug) {
            return $this->getShowView($group);
        } else {
            return redirect(route('group.show', [$group, 'title' => Str::slug($group->oldestProduct->title)]), 301);
        }
    }
}
