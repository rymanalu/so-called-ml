@extends('app')

@section('content')
    <section class="content-header">
        <h1>Test<h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="box box-primary" id="table-box">
                    <div class="box-header">
                        <h3 class="box-title">Test</h3>
                    </div>

                    <form action="{{ route('test:test') }}" method="post" autocomplete="off" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="box-body">
                            @include('flash::message')

                            <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                                <label for="sex" class="col-xs-6 col-sm-3 control-label">Sex</label>

                                <div class="col-sm-9">
                                    <select name="sex" class="form-control" id="sex">
                                        <option value=""></option>
                                    @foreach ($sexes as $key => $sex)
                                        <option value="{{ $key }}"{{ old('sex', $request->sex) == $key ? ' selected' : '' }}>{{ $sex }}</option>
                                    @endforeach
                                    </select>

                                    @if ($errors->has('sex'))
                                        <span class="help-block">{{ $errors->first('sex') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('education') ? ' has-error' : '' }}">
                                <label for="education" class="col-xs-6 col-sm-3 control-label">Education</label>

                                <div class="col-sm-9">
                                    <select name="education" class="form-control" id="education">
                                        <option value=""></option>
                                    @foreach ($educations as $key => $education)
                                        <option value="{{ $key }}"{{ old('education', $request->education) == $key ? ' selected' : '' }}>{{ $education }}</option>
                                    @endforeach
                                    </select>

                                    @if ($errors->has('education'))
                                        <span class="help-block">{{ $errors->first('education') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('marital_status') ? ' has-error' : '' }}">
                                <label for="marital_status" class="col-xs-6 col-sm-3 control-label">Marital Status</label>

                                <div class="col-sm-9">
                                    <select name="marital_status" class="form-control" id="marital_status">
                                        <option value=""></option>
                                    @foreach ($maritalStatuses as $key => $maritalStatus)
                                        <option value="{{ $key }}"{{ old('marital_status', $request->marital_status) == $key ? ' selected' : '' }}>{{ $maritalStatus }}</option>
                                    @endforeach
                                    </select>

                                    @if ($errors->has('marital_status'))
                                        <span class="help-block">{{ $errors->first('marital_status') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('age') ? ' has-error' : '' }}">
                                <label for="age" class="col-xs-6 col-sm-3 control-label">Age</label>

                                <div class="col-sm-9">
                                    <input type="number" value="{{ old('age', $request->input('age', 0)) }}" class="form-control" name="age" id="age" min="0">

                                    @if ($errors->has('age'))
                                        <span class="help-block">{{ $errors->first('age') }}</span>
                                    @endif
                                </div>
                            </div>

                        @for ($i = 1; $i <= 6; $i++)
                            <div class="form-group{{ $errors->has('payment_'.$i.'_late') ? ' has-error' : '' }}">
                                <label for="payment_{{ $i }}_late" class="col-xs-6 col-sm-3 control-label">Payment #{{ $i }} Late</label>

                                <div class="col-sm-9">
                                    <input type="number" value="{{ old('payment_'.$i.'_late', $request->input('payment_'.$i.'_late', 0)) }}" class="form-control" name="payment_{{ $i }}_late" id="payment_{{ $i }}_late" min="0">

                                    @if ($errors->has('payment_'.$i.'_late'))
                                        <span class="help-block">{{ $errors->first('payment_'.$i.'_late') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endfor
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Test</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
