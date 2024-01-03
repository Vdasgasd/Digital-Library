@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Category List</div>
        <div class="card-body">
            @can('create-category')
                <a href="{{ route('categories.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i>
                    Add New Category</a>
            @endcan
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $category->name }}</td>
                            <td>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <div class="flex">
                                        @can('edit-category')
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                        @endcan

                                        @can('delete-category')
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="post">


                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Do you want to delete this category?');">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <td colspan="3">
                            <span class="text-danger">
                                <strong>No Category Found!</strong>
                            </span>
                        </td>
                    @endforelse
                </tbody>
            </table>

            {{ $categories->links() }}

        </div>
    </div>
@endsection
