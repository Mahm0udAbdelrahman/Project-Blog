@extends('dash.layouts.app')
@section('title' , 'categories')

@push('custom_css')
<link href="https://cdn.datatables.net/v/bs4/dt-2.0.3/datatables.min.css" rel="stylesheet">
@endpush
@push('custom_js')
<script src="https://cdn.datatables.net/v/bs4/dt-2.0.3/datatables.min.js"></script>

<script>
    let table = new DataTable('#categoriesTable');
</script>
@endpush

@section('content')


<div class="card col-12">
    <div class="card-body pa-0">
        <div class="table-wrap">
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-info">add new</a>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="categoriesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Img</th>
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <th>name {{ $localeCode }}</th>
                            <th>Content {{ $localeCode }}</th>
                            @endforeach
                            <th>Parent</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $data as $category )
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>

                            <td><img width="150" height="150"
                                    src="{{ $category->getMedia('category_image')->first()->getUrl('old-picture') }}"
                                    alt="" srcset=""></td>
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            @php
                            $translations = $category->getTranslationsArray()[ $localeCode];
                            @endphp
                            <td>{{ $translations['title'] }}</td>
                            <td>{{ $translations['content'] }}</td>
                            @endforeach

                            <td>{{ $category->parentData->title ?? 'Main Category' }}</td>
                            @if ($category->deleted_at)
                            <td>
                                <a href="{{ route('dashboard.categories.restore' , $category->id ) }}"
                                    class="btn btn-icon btn-primary btn-icon-style-1"><span class="btn-icon-wrap"><i
                                            class="icon-like"></i></span></a>
                                <a href="{{ route('dashboard.categories.erase' , $category->id ) }}"
                                    class="btn btn-icon btn-danger btn-icon-style-1"><span class="btn-icon-wrap"><i
                                            class="fa fa-trash"></i></span></a>
                            </td>
                            @else
                            <td>
                                <div class="button-list">

                                    <a href="{{ route('dashboard.categories.edit' , $category->id ) }}"
                                        class="btn btn-icon btn-secondary btn-icon-style-1"><span
                                            class="btn-icon-wrap"><i class="fa fa-pencil"></i></span></a>

                                    <div class="col-sm">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary p-3" data-toggle="modal"
                                            data-target="#exampleModalCenter{{ $category->id }}">
                                            <span class="btn-icon-wrap"><i class="icon-trash"></i></span>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalCenter{{ $category->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenter{{ $category->id }}"
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
                                                        <p>{{ $category->translate('en')->title }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <form
                                                            action="{{ route('dashboard.categories.destroy', $category->id) }}"
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
