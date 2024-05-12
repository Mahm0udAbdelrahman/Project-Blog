@extends('dash.layouts.app')
@section('title' , 'Settings0')

@push('custom_css')
<link href="https://cdn.datatables.net/v/bs4/dt-2.0.3/datatables.min.css" rel="stylesheet">
@endpush
@push('custom_js')
<script src="https://cdn.datatables.net/v/bs4/dt-2.0.3/datatables.min.js"></script>

<script>
    let table = new DataTable('#usersTable');
</script>
@endpush

@section('content')


<div class="card col-12">
    <div class="card-body pa-0">
        <div class="table-wrap">
            <a href="{{ route('dashboard.users.create') }}" class="btn btn-info">add new</a>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="usersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>role</th>
                            <th>email</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $data as $user )
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>

                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->email }}</td>
                            @if ($user->deleted_at)
                            <td>
                                <a href="{{ route('dashboard.users.restore' , $user->id ) }}"
                                    class="btn btn-icon btn-primary btn-icon-style-1"><span class="btn-icon-wrap"><i
                                            class="icon-like"></i></span></a>
                                <a href="{{ route('dashboard.users.erase' , $user->id ) }}"
                                    class="btn btn-icon btn-danger btn-icon-style-1"><span class="btn-icon-wrap"><i
                                            class="fa fa-trash"></i></span></a>
                            </td>
                            @else
                            <td>
                                <div class="button-list">

                                    <a href="{{ route('dashboard.users.edit' , $user->id ) }}"
                                        class="btn btn-icon btn-secondary btn-icon-style-1"><span
                                            class="btn-icon-wrap"><i class="fa fa-pencil"></i></span></a>

                                    <div class="col-sm">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary p-3" data-toggle="modal"
                                            data-target="#exampleModalCenter{{ $user->id }}">
                                            <span class="btn-icon-wrap"><i class="icon-trash"></i></span>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalCenter{{ $user->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenter{{ $user->id }}"
                                            style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">do you want to delete </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ $user->email }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <form action="{{ route('dashboard.users.destroy', $user->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger">Delete</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

@endsection