@extends('dash.layouts.app')
@section('title' , 'posts')

@push('custom_css')
<link href="https://cdn.datatables.net/v/bs4/dt-2.0.3/datatables.min.css" rel="stylesheet">
@endpush
@push('custom_js')
<script src="https://cdn.datatables.net/v/bs4/dt-2.0.3/datatables.min.js"></script>

<script>
    let table = new DataTable('#postsTable');
</script>
@endpush

@section('content')


<div class="card col-12">
    <div class="card-body pa-0">
        <div class="table-wrap">
            <a href="{{ route('dashboard.posts.create') }}" class="btn btn-info">add new</a>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="postsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Img</th>
                            <th>Auther</th>
                            <th>Category</th>
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <th>Title {{ $localeCode }}</th>
                            <th>Content {{ $localeCode }}</th>
                            <th>Small Description {{ $localeCode }}</th>
                            <th>Tags {{ $localeCode }}</th>
                            @endforeach
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $data as $post )
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>

                            <td><img width="150" height="150"
                                    src="{{ $post->getMedia('post_image')->first()->getUrl('inMainIndex') }}" alt=""
                                    srcset="">
                            </td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->category->title }}</td>

                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            @php
                            $translations = $post->getTranslationsArray()[ $localeCode];
                            @endphp
                            <td>{{ $translations['title'] }}</td>
                            <td>{!! $translations['content'] !!}</td>
                            <td>{!! Str::limit($translations['small_description'], 15) !!}</td>
                            @php
                            $resultOfTags = explode(',' , $translations['tags'])
                            @endphp
                            <td>
                                @foreach ($resultOfTags as $tag )
                                <span class="badge badge-success badge-pill mt-15 mr-10">{{ $tag }}</span>
                                @endforeach
                            </td>
                            @endforeach

                            @if ($post->deleted_at)
                            <td>
                                <a href="{{ route('dashboard.posts.restore' , $post->id ) }}"
                                    class="btn btn-icon btn-primary btn-icon-style-1"><span class="btn-icon-wrap"><i
                                            class="icon-like"></i></span></a>
                                <a href="{{ route('dashboard.posts.erase' , $post->id ) }}"
                                    class="btn btn-icon btn-danger btn-icon-style-1"><span class="btn-icon-wrap"><i
                                            class="fa fa-trash"></i></span></a>
                            </td>
                            @else
                            <td>
                                <div class="button-list">

                                    <a href="{{ route('dashboard.posts.edit' , $post->id ) }}"
                                        class="btn btn-icon btn-secondary btn-icon-style-1"><span
                                            class="btn-icon-wrap"><i class="fa fa-pencil"></i></span></a>

                                    <div class="col-sm">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary p-3" data-toggle="modal"
                                            data-target="#exampleModalCenter{{ $post->id }}">
                                            <span class="btn-icon-wrap"><i class="icon-trash"></i></span>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalCenter{{ $post->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalCenter{{ $post->id }}"
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
                                                        <p>{{ $post->translate('en')->title }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <form action="{{ route('dashboard.posts.destroy', $post->id) }}"
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
