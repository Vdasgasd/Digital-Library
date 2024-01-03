<?php

namespace App\Exports;

use App\Models\Books;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Storage;

class BooksExport implements FromCollection, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Books::with('category')->get(['title', 'description', 'pages', 'category_id', 'pdf_file', 'cover_image']);
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
}
