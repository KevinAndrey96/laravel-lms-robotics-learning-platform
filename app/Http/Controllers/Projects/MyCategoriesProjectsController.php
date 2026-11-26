<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Category;

class MyCategoriesProjectsController extends Controller
{
    public function myCategories()
    {
        $categories = Category::all();

        return view('projects.myCategories', compact('categories'));
    }
}
