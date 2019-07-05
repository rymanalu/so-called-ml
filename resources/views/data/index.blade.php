@extends('app')

@section('content')
    <section class="content-header">
        <h1>Data<h1>
    </section>

    <section class="content">
        <div class="box box-primary" id="table-box">
            <div class="box-header">
                <h3 class="box-title">Data</h3>
                <div class="pull-right">
                    <a href="{{ route('data:train') }}" class="btn btn-primary" title="Train" id="train-button"><i class="fa fa-refresh"></i></a>
                </div>
            </div>

            <div class="box-body">
                <table id="datatable" class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Limit Balance (NT$)</th>
                            <th>Sex</th>
                            <th>Education</th>
                            <th>Marital Status</th>
                            <th>Age</th>
                            @for ($i = 1; $i <= 6; $i++)
                                <th>Pay {{ $i }}</th>
                            @endfor
                            <th>Next Month Default?</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            (function () {
                var columns = [
                    {data: 'id', name: 'id'},
                    {data: 'limit_balance_ntd', name: 'limit_balance', class: 'text-right'},
                    {data: 'sex_name', name: 'sex', searchable: false},
                    {data: 'education_name', name: 'education', searchable: false},
                    {data: 'marital_status_name', name: 'marital_status', searchable: false},
                    {data: 'age', name: 'age'}
                ];

                for (var i = 1; i <= 6; i++) {
                    columns.push({data: 'pay_'+i+'_name', name: 'pay_'+i, searchable: false});
                }

                columns.push({data: 'is_next_month_default_name', name: 'is_next_month_default', searchable: false})

                $('#datatable').DataTable({
                    ajax: '{{ route('data:datatables') }}',
                    columns: columns
                });
            })();

            $('#train-button').click(function () {
                $('#table-box').append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
            });
        });
    </script>
@endpush
