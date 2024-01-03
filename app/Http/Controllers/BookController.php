<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Category;
use App\Models\User;
use App\Http\Requests\StoreBooksRequest;
use App\Http\Requests\UpdateBooksRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-books|edit-books|delete-books', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-books', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-books', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-books', ['only' => ['destroy']]);
    }
    public function index(Request $request): View
    {

        $user = Auth::user();
        $categories = Category::all();
        $selectedCategory = $request->input('category_filter');

        // Use a more descriptive variable name like $booksQuery to represent the base query
        $booksQuery = $user->isAdmin() ? Books::latest() : Books::where('user_id', $user->id)->latest();

        if ($selectedCategory) {
            $booksQuery->where('category_id', $selectedCategory);
        }

        // Get the paginated result after applying filters
        $books = $booksQuery->paginate(10);

        return view('books.index', [
            'books' => $books,
            'categories' => $categories,
            'user' => $user,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {

        $categories = Category::all();
        $user = Auth::user(); // Get the authenticated user
        return view('books.create', ['categories' => $categories, 'user' => $user, 'permissions']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBooksRequest $request): RedirectResponse
    {


        $user = Auth::user();
        $book = Books::create($request->all());

        // Create a folder for the book using its ID
        $folderPathPdf = 'public/pdf_files';
        Storage::makeDirectory($folderPathPdf);

        // Store the PDF file in the created folder
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $pdfPath = $pdfFile->storeAs($folderPathPdf, $book->id . '_book.pdf'); // Adjust the path and filename as needed
            $book->update(['pdf_file' => $pdfPath]);
        }

        // Handle cover image upload
        $folderPathCover = 'public/cover_images';
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $coverImagePath = $coverImage->storeAs($folderPathCover, $book->id . '_cover.jpg'); // Adjust the path and filename as needed
            $book->update(['cover_image' => $coverImagePath]);
        }


        return redirect()->route('books.index')->withSuccess('New book is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Books $book): View
    {


        return view('books.show', [
            'books' => $book
        ],);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Books $book): View
    {
        $this->authorize('edit-books', $book);

        $categories = Category::all();
        $user = Auth::user();

        return view('books.edit', [
            'book' => $book,
            'categories' => $categories,
            'user' => $user,
            'permissions' => Permission::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBooksRequest $request, Books $book): RedirectResponse
    {


        $user = Auth::user();
        $book->update($request->all());

        // Update PDF file if a new file is provided
        if ($request->hasFile('pdf_file')) {
            $folderPathPdf = 'public/pdf_files';
            Storage::delete($book->pdf_file); // Delete the old PDF file
            $pdfFile = $request->file('pdf_file');
            $pdfPath = $pdfFile->storeAs($folderPathPdf, $book->id . '_book.pdf'); // Store the new PDF file
            $book->update(['pdf_file' => $pdfPath]);
        }

        // Update cover image if a new image is provided
        if ($request->hasFile('cover_image')) {
            $folderPathCover = 'public/cover_images';
            Storage::delete($book->cover_image); // Delete the old cover image
            $coverImage = $request->file('cover_image');
            $coverImagePath = $coverImage->storeAs($folderPathCover, $book->id . '_cover.jpg'); // Store the new cover image
            $book->update(['cover_image' => $coverImagePath]);
        }

        return redirect()->route('books.index')->withSuccess('Book is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Books $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('books.index')
            ->withSuccess('Book is deleted successfully.');
    }
}
