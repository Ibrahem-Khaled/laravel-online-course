@extends('layouts.dashboard')

@section('content')
    <h1>Routes</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createRouteModal">
        Create New Route
    </button>
    @include('homeComponents.alerts')
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Target Group</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($routes as $route)
                <tr>
                    <td>{{ $route->id }}</td>
                    <td>{{ $route->name }}</td>
                    <td>{{ $route->target_group }}</td>
                    <td>{{ $route->description }}</td>
                    <td><img src="{{ $route->image }}" alt="{{ $route->name }}" width="50"></td>
                    <td>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#editRouteModal{{ $route->id }}">
                            Edit
                        </button>
                        <a class="btn btn-info" href="{{ route('route_courses.index', $route->id) }}">
                            View Courses
                        </a>
                        <form action="{{ route('routes.destroy', $route->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this route?')">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Route Modal for each route -->
                <div class="modal fade" id="editRouteModal{{ $route->id }}" tabindex="-1"
                    aria-labelledby="editRouteModalLabel{{ $route->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editRouteModalLabel{{ $route->id }}">Edit Route</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('routes.update', $route->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="edit_name{{ $route->id }}">Name</label>
                                        <input type="text" name="name" id="edit_name{{ $route->id }}"
                                            class="form-control" value="{{ $route->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_target_group{{ $route->id }}">Target Group</label>
                                        <input type="text" name="target_group" id="edit_target_group{{ $route->id }}"
                                            class="form-control" value="{{ $route->target_group }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_description{{ $route->id }}">Description</label>
                                        <textarea name="description" id="edit_description{{ $route->id }}" class="form-control">{{ $route->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_image{{ $route->id }}">Image URL</label>
                                        <input type="url" name="image" id="edit_image{{ $route->id }}"
                                            class="form-control" value="{{ $route->image }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    <!-- Create Route Modal -->
    <div class="modal fade" id="createRouteModal" tabindex="-1" aria-labelledby="createRouteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRouteModalLabel">Create New Route</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('routes.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="target_group">Target Group</label>
                            <input type="text" name="target_group" id="target_group" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image URL</label>
                            <input type="url" name="image" id="image" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
