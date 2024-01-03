@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="cardheader">
            <h3 class="m-2 flex"> Book List</h3>
            <div class="float-end me-5 flex">
                <form action="{{ route('books.index') }}" method="" class="form-inline">

                    <div class="form-group mx-2">

                        <label for="category_filter" class="sr-only">Filter by Category</label>
                        <select class="form-control" id="category_filter" name="category_filter">
                            <option value="" selected>All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm mt-1 flex float-end me-3 ">Filter</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @can('create-books')
                <a href="{{ route('books.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add
                    New
                    Book</a>
            @endcan
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Category</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->description }}</td>
                            <td>{{ $book->category->name }}</td>
                            <td>
                                <form action="{{ route('books.destroy', $book->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-warning btn-sm"><i
                                            class="bi bi-eye"></i>Show Detail</a>

                                    @can('edit-books')
                                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm"><i
                                                class="bi bi-pencil-square"></i> Edit</a>
                                    @endcan

                                    @can('delete-books')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Do you want to delete this book?');"><i
                                                class="bi bi-trash"></i> Delete</button>
                                    @endcan

                                    <a href="{{ route('export.books') }}" class="btn btn-success btn-sm"><i
                                            class="bi bi-file-excel"></i> Export Excel</a>

                                    @if ($book->pdf_file)
                                        <a href="{{ asset('storage/pdf_files/' . basename($book->pdf_file)) }}"
                                            target="_blank" class="btn btn-info btn-sm">Download PDF</a>
                                    @else
                                        No PDF file available.
                                    @endif

                                </form>
                            </td>
                        </tr>
                    @empty
                        <td colspan="4">
                            <span class="text-danger">
                                <strong>No Book Found!</strong>
                            </span>
                        </td>
                    @endforelse





                </tbody>
            </table>

            {{ $books->links() }}

        </div>
    </div>
@endsection
