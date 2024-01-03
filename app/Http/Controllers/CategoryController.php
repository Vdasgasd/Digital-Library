<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-category|edit-category|delete-category', ['only' => ['index', 'show']]);
        $this->middleware('can:create-category', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-category', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = Auth::user();
        $categories = Category::latest()->paginate(10);

        return view('categories.index', [
            'categories' => $categories
        ]);
        // if ($user->isAdmin()) {
        //     $categories = Category::latest()->paginate(3);
        // } else {
        //     $categories = Category::where('user_id', $user->id)->latest()->paginate(3);
        // }


        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view(
            'categories.create',
            [
                'permissions' => Permission::get()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create(['name' => $request->name]);

        // $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        // $categories->syncPermissions($permissions);

        return redirect()->route('categories.index')
            ->withSuccess('New category is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $categories): View
    {
        // return view(
        //     'categories.show',
        //     ['category' => $categories],
        //     compact('categories')
        // );
        $user = Auth::user();
        return view('categories.show', [
            'category' => $categories, 'permissions' => Permission::get()
        ],);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $this->authorize('edit-category', $category);

        return view('categories.edit', [
            'category' => $category,
            'permissions' => Permission::get(),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->authorize('edit-category', $category);

        $category->update(['name' => $request->name]);

        return redirect()->route('categories.index')
            ->withSuccess('Category is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->withSuccess('Category is deleted successfully.');
    }
}
