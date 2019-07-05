@extends('app')

@section('content')
    <section class="content-header">
        <h1>Tree<h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary" id="table-box">
                    <div class="box-header">
                        <h3 class="box-title">Tree</h3>
                    </div>

                    <div class="box-body">
                        <pre>{{ $tree }}</pre>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
