    @extends('layouts.app')

    @section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <div class="float-start">
                            Edit Book
                        </div>
                        <div class="float-end">
                            @can('edit-books')
                                <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (Auth::check() && (Auth::user()->isAdmin() || Auth::id() === $book->user_id))
                                <form action="{{ route('books.update', $book->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3 row">
                                        <label for="title"
                                            class="col-md-4 col-form-label text-md-end text-start">Title</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                                id="title" name="title" value="{{ old('title', $book->title) }}">
                                            @if ($errors->has('title'))
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="mb-3 row">
                                        <label for="category_id"
                                            class="col-md-4 col-form-label text-md-end text-start">Category</label>
                                        <div class="col-md-6">
                                            <select class="form-control @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id">
                                                <option value="" selected disabled>Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category_id'))
                                                <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="description"
                                            class="col-md-4 col-form-label text-md-end text-start">Description</label>
                                        <div class="col-md-6">
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $book->description) }}</textarea>
                                            @if ($errors->has('description'))
                                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="pages"
                                            class="col-md-4 col-form-label text-md-end text-start">Pages</label>
                                        <div class="col-md-6">
                                            <input type="number" class="form-control @error('pages') is-invalid @enderror"
                                                id="pages" name="pages" value="{{ old('pages', $book->pages) }}">
                                            @if ($errors->has('pages'))
                                                <span class="text-danger">{{ $errors->first('pages') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="pdf_file" class="col-md-4 col-form-label text-md-end text-start">PDF
                                            File</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control @error('pdf_file') is-invalid @enderror"
                                                id="pdf_file" name="pdf_file">
                                            @if ($errors->has('pdf_file'))
                                                <span class="text-danger">{{ $errors->first('pdf_file') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="cover_image" class="col-md-4 col-form-label text-md-end text-start">Cover
                                            Image</label>
                                        <div class="col-md-6">
                                            <input type="file"
                                                class="form-control @error('cover_image') is-invalid @enderror" id="cover_image"
                                                name="cover_image">
                                            @if ($errors->has('cover_image'))
                                                <span class="text-danger">{{ $errors->first('cover_image') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    {{--
                                    <div class="mb-3 row">
                                        <label for="user_name"
                                            class="col-md-4 col-form-label text-md-end text-start">User</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="user_name"
                                                value="{{ $user->name }}" readonly>
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        </div>
                                    </div> --}}

                                    <div class="mb-3 row">
                                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update">
                                    </div>
                                </form>
                            @else
                                <h1>Unauthorized action.</h1>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @endsection
