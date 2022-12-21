<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return view('group.index', [
            'groups' => Group::latest()->paginate(5)
        ]);
    }

    public function show(Group $group)
    {
        return view('group.show', [
            'group' => $group
        ]);
    }
}
