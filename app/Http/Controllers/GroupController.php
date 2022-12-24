<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return view('group.index', [
            'groups' => Group::latest()->with('oldestProduct', 'latestPriceWeekRange')->paginate(5)
        ]);
    }

    public function show(Group $group)
    {

        return view('group.show', [
            'group' => $group,
            'products' => $group->products()->with('shop', 'prices', 'images')->get()
        ]);
    }
}
