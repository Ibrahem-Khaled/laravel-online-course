<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        return view('dashboard.routes.index', compact('routes',));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:routes|max:255',
            'target_group' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|url',
        ]);

        $route = Route::create($request->all());

        return redirect()->back()->with('success', 'Route added successfully.');
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'name' => 'required|max:255|unique:routes,name,' . $route->id,
            'target_group' => 'nullable|max:255',
            'description' => 'nullable',
            'image' => 'nullable|url',
        ]);

        $route->update($request->all());

        return redirect()->back()->with('success', 'Route updated successfully.');
    }

    public function destroy(Route $route)
    {
        $route->delete();

        return redirect()->back()->with('success', 'Route removed successfully.');
    }
}
