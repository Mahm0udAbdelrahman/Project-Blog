@extends('dash.layouts.app')
@section('title' , 'Settings0')

@section('content')


<div class="card col-12">
    <div class="card-body pa-0">
        <div class="table-wrap">
            <a href="{{ route('dashboard.setting.create') }}" class="btn btn-info">add new</a>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>logo</th>
                            <th>favicon</th>
                            <th>facebook</th>
                            <th>phone</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $data as $setting )
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            @foreach ($setting->media as $imgs )
                            <td>
                                {{-- {!! $imgs->img()->attributes(['loading' => 'lazy']) !!} --}}
                                <img src="{{ $imgs->getUrl() }}" width="75" height="75" alt="">
                                {{-- <img src="{{ asset('media/'.$imgs->id.'/'.$imgs->file_name) }}" alt=""> --}}
                            </td>
                            @endforeach
                            <td>{{ $setting->facebook }}</td>
                            <td>{{ $setting->phone }}</td>
                            <td>
                                <div class="button-list">
                                    <a href="{{ route('dashboard.setting.edit' , $setting->id ) }}"
                                        class="btn btn-icon btn-secondary btn-icon-style-1"><span
                                            class="btn-icon-wrap"><i class="fa fa-pencil"></i></span></a>


                                    <form action="{{ route('dashboard.setting.destroy', $setting->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-icon btn-info btn-icon-style-1"><span
                                                class="btn-icon-wrap"><i class="icon-trash"></i></span></button>
                                    </form>



                                </div>
                            </td>
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