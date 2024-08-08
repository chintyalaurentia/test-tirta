@extends('layouts.app')

@section('css')
<style>
    .select2-results__option--highlighted[aria-selected] {
        color: black!important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3>Total Transaction</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center jusitfy-content-between">Total Transaction
            <div class="btn-group ml-auto" role="group" aria-label="Basic example">
                {{-- <button class="btn btn-outline-dark btn-sm" type="button" data-toggle="collapse" data-target="#filters" aria-controls="filters"><i class="fas fa-filter"></i> Filter</button> --}}
                <button class="btn btn-outline-dark btn-sm" type="button" id="reload"><i class="fa fa-refresh" aria-hidden="true"></i> Reload</button>
                <button class="btn btn-outline-dark btn-sm excBtn" id="export" role="button" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</button>
                {{-- <a class="btn btn-dark btn-sm" href="{{ route('master.sales.create')}}" target="" type="button" aria-expanded="false"><i class="fa fa-plus" aria-hidden="true"></i> Create</a> --}}
            </div>
        </div>

        <div class="card-body">
            {{-- <div class="row mb-4 collapse" id="filters">
                <div class="col-md-1">
                    <label class="col-form-label" for="">Nama</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control select-item" name="itemFilter" id="itemFilter" data-allow-clear="true">
                        <option disabled selected></option>

                    </select>
                </div>

                <div class="col-md-1">

                </div>

                <div class="col-md-1">
                    <label class="col-form-label" for="">Tanggal</label>
                </div>
                <div class="col-md-5">
                    <div class="input-group mb-1">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                        <input type="text" class="form-control datepicker" id="startDate" name="startDate" placeholder="Start Date">
                        <div class="input-group-append"><span class="input-group-text">-</span></div>
                        <input type="text" class="form-control datepicker" id="endDate" name="endDate" placeholder="Finish Date">
                        <div class="input-group-append"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="0" id="showAll">
                        <label class="form-check-label" for="defaultCheck1">Show All</label>
                    </div>
                </div>
            </div> --}}

            <table class="table table-striped table-bordered table-hover table-sm w-100" id="data-table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col"  class="text-center align-middle">No</th>
                        <th scope="col"  class="text-center align-middle">Nama</th>
                        <th scope="col"  class="text-center align-middle">Nominal</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@routes()
@section('js')
<script>
    $(document).ready(function(){
        var baseurl = '{{ route("transaction.datatable") }}';
        let table = $('#data-table').dataTable({
            processing: true,
            orderClasses: false,
            responsive: true,
            serverSide: true,
            responsive: true,
            // scrollX: true,
            order : [],
            ajax: {
                url: baseurl,
                data: function(d) {
                    d.nama = $('#itemFilter').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-left align-middle"},
                {data: 'kode', name: 'kode', orderable: true, searchable: true, className: "align-middle"},
                {data: 'nominal', name: 'nominal', className: "text-left align-middle"},
            ],
            drawCallback: function(settings) {
                // $('#startDate, #endDate').off('change').on('change', function() {
                //     var table = $('#data-table').DataTable();
                //     table.draw();
                // });
                // $('#itemFilter').on('change', function() {
                //     var selectedValue = $(this).val();
                //     //clear
                //     if (selectedValue === '') {
                //         var table = $('#data-table').DataTable();
                //         table.draw();
                //     }
                //     //ada value
                //     else {
                //         var table = $('#data-table').DataTable();
                //         table.draw();
                //     }

                // });
            }
        });

        $(document).on('click', '#deleteBtn', function(){
            var id = $(this).data('id');
            // alert(id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('master.sales.destroy', '') }}/" + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            // console.log(data.status)
                            if(data.Code == 200){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.Message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                            else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred while processing your request'
                                });
                            }
                            table.api().ajax.reload();
                        }
                    });
                }
            });
        });

        $("#export").on("click",function(){
            window.location.href = "{{ route('transaction.export') }}";
        })

        $('#reload').on('click', function() {
            table.api().ajax.reload();
        });




    })
</script>
@endsection
