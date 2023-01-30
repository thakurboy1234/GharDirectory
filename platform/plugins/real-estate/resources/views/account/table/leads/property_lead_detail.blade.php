@extends('plugins/real-estate::account.layouts.skeleton')
@section('content')

\

@if ($consult)
    <div class="container page-content">
        <div class="row">
            <div class="col-md-9">
                <div class="widget meta-boxes">
                    <div class="widget-title">
                        <h4>
                            <span> Consult information</span>
                        </h4>
                    </div>
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-md-6">
                                    <p><strong>{{ trans('plugins/real-estate::consult.time') }}</strong>: <i>{{ $consult->created_at }}</i></p>
                                    <p><strong>{{ trans('plugins/real-estate::consult.consult_id') }}</strong>: <i>AB00000{{ $consult->id }}</i></p>
                                    <p><strong>{{ trans('plugins/real-estate::consult.form_name') }}</strong>: <i>{{ $consult->name }}</i></p>


                                    {{-- <p><strong>{{ trans('plugins/real-estate::consult.content') }}</strong>: <i>{{ $consult->content ?: '...' }}</i></p> --}}
                                    <p><strong>Message</strong>: <i>{{ $consult->content ?: '...' }}</i></p>
                            </div>
                            <div class="col-md-6">
                                    <p><strong>{{ trans('plugins/real-estate::consult.email.header') }}</strong>: <i><a href="mailto:{{ $consult->email }}">{{ $consult->email }}</a></i></p>
                                    <p><strong>{{ trans('plugins/real-estate::consult.phone') }}</strong>: <i>@if ($consult->phone) <a href="tel:{{ $consult->phone }}">{{ $consult->phone }}</a> @else N/A @endif</i></p>
                                    @if ($consult->project_id && $consult->project)
                                        <p><strong>{{ trans('plugins/real-estate::consult.project') }}</strong>: <a href="{{ $consult->project->url }}" target="_blank"><i>{{ $consult->project->name }}</i></a></p>
                                    @endif
                                    @if ($consult->property_id && $consult->property)
                                        <p><strong>{{ trans('plugins/real-estate::consult.property') }}</strong>: <a href="{{ $consult->property->url }}" target="_blank"><i>{{ $consult->property->name }}</i></a></p>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


@stop
</div>

</div>
