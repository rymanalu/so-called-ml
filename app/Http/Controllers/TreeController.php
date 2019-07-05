<?php

namespace App\Http\Controllers;

use C45\TreeNode;
use Storage;

class TreeController extends Controller
{
    public function index()
    {
        $tree = 'AI haven\'t trained!';

        if (Storage::disk('local')->exists('tree')) {
            $tree = TreeNode::createFromFile(storage_path('app/tree'))->toString();
        }

        return view('tree.index', compact('tree'));
    }
}
