<?php

namespace App\Exports;

use App\Models\Books;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\Storage;

class BooksExport implements FromCollection, WithMapping, WithTitle
{
    private $bookId;

    public function __construct($bookId)
    {
        $this->bookId = $bookId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Books::with('category')->where('id', $this->bookId)->get(['title', 'description', 'pages', 'category_id', 'pdf_file', 'cover_image']);
    }

    public function map($book): array
    {
        return [
            'title' => $book->title,
            'description' => $book->description,
            'pages' => $book->pages,
            'category' => $book->category->name ?? '',
            'pdf_file' => Storage::url($book->pdf_file),
            'cover_image' => Storage::url($book->cover_image),
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $book = Books::findOrFail($this->bookId);
        return $book->title;
    }
}
