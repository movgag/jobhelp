<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Region;
use App\Models\Skill;
use App\Models\Type;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function dashboard()
    {
        $data = array();
        $data['title'] = 'Home';

        return view('admin.home',compact('data'));
    }

    public function getRegions()
    {
        $data = array();
        $data['title'] = 'Regions';

        $data['regions'] = Region::get_regions();

        return view('admin.regions',compact('data'));
    }

    public function getSkills()
    {
        $data = array();
        $data['title'] = 'Skills';

        $data['skills'] = Skill::get_skills();

        return view('admin.skills',compact('data'));
    }

    public function getCategories()
    {
        $data = array();
        $data['title'] = 'Categories';

        $data['categories'] = Category::get_categories();

        return view('admin.categories',compact('data'));
    }

    public function getTypes()
    {
        $data = array();
        $data['title'] = 'Types';

        $data['types'] = Type::get_types();

        return view('admin.types',compact('data'));
    }

    public function getLanguages()
    {
        $data = array();
        $data['title'] = 'Languages';

        $data['languages'] = Language::get_languages();

        return view('admin.languages',compact('data'));
    }



}
