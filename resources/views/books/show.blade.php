@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="-start">
                        Book Information
                    </div>
                    <div class="float-end">
                        <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                </div>
                @if (Auth::check() && (Auth::user()->isAdmin() || Auth::id() === $books->user_id))
                    <div class="card-body">

                        <div class="row">
                            <label for="title"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Title:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $books->title }}
                            </div>
                        </div>

                        <div class="row">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $books->description }}
                            </div>
                        </div>

                        <div class="row">
                            <label for="pages"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Pages:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $books->pages }}
                            </div>
                        </div>

                        <div class="row">
                            <label for="category"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Category:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $books->category->name }}
                            </div>
                        </div>

                        <div class="row">
                            <label for="pdf_file" class="col-md-4 col-form-label text-md-end text-start"><strong>PDF
                                    File:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                @if ($books->pdf_file)
                                    <a href="{{ asset('storage/pdf_files/' . basename($books->pdf_file)) }}"
                                        target="_blank">View PDF</a>
                                @else
                                    No PDF file available.
                                @endif
                            </div>

                        </div>

                        <div class="row">
                            <label for="cover_image" class="col-md-4 col-form-label text-md-end text-start"><strong>Cover
                                    Image:</strong></label>
                            <div class="col-md-6">
                                @if ($books->cover_image)
                                    <img src="{{ asset('storage/cover_images/' . basename($books->cover_image)) }}"
                                        alt="Cover Image" style="max-width: 100%;">
                                @else
                                    No cover image available.
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <label for="user"
                                class="col-md-4 col-form-label text-md-end text-start"><strong>Author:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $books->user->name }}
                            </div>
                        </div>

                    </div>
                @else
                    <h1>Unauthorized action.</h1>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
