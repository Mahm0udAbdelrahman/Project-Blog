@extends('dash.layouts.app')
@section('title' , 'Settings0')

@section('content')
<div class="col-xl-12">
    <section class="hk-sec-wrapper">
        <h5 class="hk-sec-title">Default Layout</h5>
        <p class="mb-25">More complex forms can be built using the grid classes. Use these for form layouts that require
            multiple columns, varied widths, and additional alignment options.</p>
        <div class="row">
            <div class="col-sm">
                <form action="{{ route('dashboard.setting.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="input-group-prepend">
                                <span class="input-group-text">logo</span>
                            </div>
                            <div class="form-control text-truncate" data-trigger="fileinput"><i
                                    class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                    class="fileinput-filename"></span></div>
                            <span class="input-group-append">
                                <span class=" btn btn-primary btn-file"><span class="fileinput-new">Select
                                        file</span><span class="fileinput-exists">Change</span>
                                    <input type="file" name="logo">
                                </span>
                                <a href="#" class="btn btn-secondary fileinput-exists"
                                    data-dismiss="fileinput">Remove</a>
                            </span>
                        </div>
                        @error('logo')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="input-group-prepend">
                                <span class="input-group-text">favicon</span>
                            </div>
                            <div class="form-control text-truncate" data-trigger="fileinput"><i
                                    class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                    class="fileinput-filename"></span></div>
                            <span class="input-group-append">
                                <span class=" btn btn-primary btn-file"><span class="fileinput-new">Select
                                        file</span><span class="fileinput-exists">Change</span>
                                    <input type="file" name="favicon">
                                </span>
                                <a href="#" class="btn btn-secondary fileinput-exists"
                                    data-dismiss="fileinput">Remove</a>
                            </span>
                        </div>
                        @error('favicon')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">facebook</span>
                            </div>
                            <input type="text" name="facebook" class="form-control" aria-label="Default"
                                aria-describedby="inputGroup-sizing-default">
                        </div>
                        @error('facebook')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">linkedin</span>
                            </div>
                            <input type="text" name="linkedin" class="form-control" aria-label="Default"
                                aria-describedby="inputGroup-sizing-default">
                        </div>
                        @error('linkedin')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">phone</span>
                            </div>
                            <input type="text" name="phone" class="form-control" aria-label="Default"
                                aria-describedby="inputGroup-sizing-default">
                        </div>
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">email</span>
                            </div>
                            <input type="text" name="email" class="form-control" aria-label="Default"
                                aria-describedby="inputGroup-sizing-default">
                        </div>
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- multi lang Title & content --}}
                    <div class="card hk-dash-type-1 overflow-hide">
                        <div class="card-header pa-0">
                            <div class="nav nav-tabs nav-light nav-justified" id="dash-tab" role="tablist">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a class="d-flex align-items-center justify-content-center nav-item nav-link {{ $loop->index == 0 ? 'active' : '' }}"
                                    id="dash-tab-{{ $localeCode }}" data-toggle="tab" href="#nav-dash-{{ $localeCode }}"
                                    role="tab" aria-selected="true">
                                    <div class="d-flex">
                                        <div>
                                            <span class="d-block mb-5"><span class="display-4">
                                                    {{ $properties['native']}}</span></span>

                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="nav-tabContent">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <div class="tab-pane fade {{ $loop->index == 0 ? 'active show' : '' }} "
                                    id="nav-dash-{{ $localeCode }}" role="tabpanel"
                                    aria-labelledby="dash-tab-{{ $localeCode }}">
                                    <div id="e_chart_{{ $localeCode }}" class="echart"
                                        style="height: 310px; user-select: none; position: relative;">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"
                                                        id="inputGroup-sizing-default{{ $localeCode }}">Title {{
                                                        $localeCode }} </span>
                                                </div>
                                                <input type="text" name="{{ $localeCode }}[title]" class="form-control"
                                                    aria-label="Default"
                                                    aria-describedby="inputGroup-sizing-default{{ $localeCode }}">
                                            </div>
                                            @error("{{ $localeCode }}[title]")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <textarea name="{{ $localeCode }}[content]" class="form-control mt-15"
                                                    rows="3" placeholder="Textarea"></textarea>
                                            </div>
                                            @error("{{ $localeCode }}[content]")
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-primary" type="submit">create</button>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection