<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;

class MySubcategoriesProjectsController extends Controller
{
    public function mySubcategories($id)
    {
        $subcategories = Subcategory::where('category_id', $id)->get();

        return view('projects.mySubcategories', compact('subcategories'));
    }
}
