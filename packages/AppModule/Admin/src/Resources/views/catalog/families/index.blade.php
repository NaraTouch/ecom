@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.catalog.families.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.catalog.families.title') }}</h1>
            </div>

            <div class="page-action">
                @if (bouncer()->hasPermission('catalog.families.create'))
                    <a href="{{ route('admin.catalog.families.create') }}" class="btn btn-lg btn-primary">
                        {{ __('admin::app.catalog.families.add-family-btn-title') }}
                    </a>
                @endif
            </div>
        </div>

        {!! view_render_event('module.admin.catalog.families.list.before') !!}

        <div class="page-content">
            <datagrid-plus src="{{ route('admin.catalog.families.index') }}"></datagrid-plus>
        </div>

        {!! view_render_event('module.admin.catalog.families.list.after') !!}

    </div>
@stop
