@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.settings.currencies.add-title') }}
@stop

@section('content')
    <div class="content">

        <form method="POST" action="{{ route('admin.currencies.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.currencies.index') }}'"></i>

                        {{ __('admin::app.settings.currencies.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.settings.currencies.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()

                    {!! view_render_event('module.admin.settings.currencies.create.before') !!}

                    <accordian title="{{ __('admin::app.settings.currencies.general') }}" :active="true">
                        <div slot="body">

                            <div class="control-group" :class="[errors.has('code') ? 'has-error' : '']">
                                <label for="code" class="required">{{ __('admin::app.settings.currencies.code') }}</label>
                                <input v-validate="'required|min:3|max:3'" class="control" id="code" name="code" value="{{ old('code') }}" data-vv-as="&quot;{{ __('admin::app.settings.currencies.code') }}&quot;" style="text-transform:uppercase" v-code/>
                                <span class="control-error" v-if="errors.has('code')">@{{ errors.first('code') }}</span>
                            </div>

                            <div class="control-group" :class="[errors.has('name') ? 'has-error' : '']">
                                <label for="name" class="required">{{ __('admin::app.settings.currencies.name') }}</label>
                                <input v-validate="'required'" class="control" id="name" name="name" data-vv-as="&quot;{{ __('admin::app.settings.currencies.name') }}&quot;" value="{{ old('name') }}"/>
                                <span class="control-error" v-if="errors.has('name')">@{{ errors.first('name') }}</span>
                            </div>

                            <div class="control-group">
                                <label for="symbol">{{ __('admin::app.settings.currencies.symbol') }}</label>
                                <input class="control" id="symbol" name="symbol" value="{{ old('symbol') }}"/>
                            </div>

                            <div class="control-group">
                                <label for="decimal">{{ __('admin::app.settings.currencies.decimal') }}</label>
                                <input class="control" id="decimal" name="decimal" value="{{ old('decimal') }}"/>
                            </div>
                        </div>
                    </accordian>

                    {!! view_render_event('module.admin.settings.currencies.create.after') !!}
                </div>
            </div>
        </form>
    </div>
@stop