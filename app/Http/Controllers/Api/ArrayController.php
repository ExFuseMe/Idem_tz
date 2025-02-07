<?php

namespace App\Http\Controllers\Api;

use App\Http\Action\FormTree;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArrayRequest;
use Illuminate\Http\Request;

class ArrayController extends Controller
{
    public function __invoke(ArrayRequest $request)
    {
        $array = $request->validated()['array'];

        $tree = (new FormTree())->form($array);

        return response()->json($tree);
    }
}
