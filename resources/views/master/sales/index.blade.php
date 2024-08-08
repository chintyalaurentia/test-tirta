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
            <h3>Master Sales</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center jusitfy-content-between">Master Sales
            <div class="btn-group ml-auto" role="group" aria-label="Basic example">
                <button class="btn btn-outline-dark btn-sm" type="button" data-toggle="collapse" data-target="#filters" aria-controls="filters"><i class="fas fa-filter"></i> Filter</button>
                <button class="btn btn-outline-dark btn-sm" type="button" id="reload"><i class="fas fa-sync fa-xs"></i> Reload</button>
                <button class="btn btn-outline-dark btn-sm excBtn" id="export" role="button" ><i class="fa fa-solid fa-file-excel"></i> Excel</button>
                <a class="btn btn-outline-dark btn-sm " href="{{ route('master.sales.create')}}" target="" type="button" aria-expanded="false">+ Create</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-4 collapse" id="filters">
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
            </div>

            <table class="table table-striped table-bordered table-hover table-sm w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col"  class="text-center align-middle">No</th>
                        <th scope="col"  class="text-center align-middle">Kode</th>
                        <th scope="col"  class="text-center align-middle">Nama</th>
                        <th scope="col"  class="text-center align-middle">Action</th>
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
        // $(document).on('click', '#deleteBtn', function(e){
        //     var id = $(this).data('id');
        //     // console.log(id);
        //     var csrfToken = $('meta[name="csrf-token"]').attr('content');
        //     Swal.fire({
        //         title: "Are you sure want to delete ?",
        //         icon: "info",
        //         showCancelButton: true,
        //         confirmButtonText: "Yes",
        //         cancelButtonText: "No",
        //         reverseButtons: true,
        //     }).then((result) => {
        //         console.log(result);
        //         if (result && result.value) {
        //             $.ajax({
        //                 url: route('ppms.formPpms.destroy', id),
        //                 type: 'DELETE',
        //                 headers: {
        //                     'X-CSRF-TOKEN': csrfToken
        //                 },
        //                 success: function (response) {
        //                     // console.log(response);
        //                     if(response.success){
        //                         Swal.fire({
        //                             title: "Success",
        //                             text: "Data deleted successfully",
        //                             icon: "success",
        //                             showConfirmButton: false,
        //                             timer: 3000
        //                         }).then(function () {
        //                             $("#reload").trigger('click');
        //                         });
        //                     }
        //                     else{
        //                         Swal.fire({
        //                             title: "Error",
        //                             text: "Failed to delete data",
        //                             icon: "error",
        //                             showConfirmButton: false,
        //                             timer: 3000
        //                         }).then(function () {
        //                             $("#reload").trigger('click');
        //                         });
        //                     }
        //                 },
        //                 error: function (xhr, status, error) {
        //                     console.log(xhr.responseText);
        //                 }
        //             });
        //         }

        //     });
        // })

        var baseurl = '{{ route("master.sales.datatable") }}';
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
                    if($('#startDate').val() === ''){
                        d.startDate = $('#startDate').val();
                    }
                    else {
                        d.startDate = moment($('#startDate').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
                    }
                    if($('#endDate').val() === ''){
                        d.endDate = $('#endDate').val();
                    }
                    else{
                        d.endDate = moment($('#endDate').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
                    }
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-left align-middle"},
                {data: 'kode_sales', name: 'kode_sales', orderable: true, searchable: true, className: "align-middle"},
                {data: 'nama_sales', name: 'nama_sales', className: "text-left align-middle"},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center align-middle"},
            ],
            drawCallback: function(settings) {
                $('#startDate, #endDate').off('change').on('change', function() {
                    var table = $('#data-table').DataTable();
                    table.draw();
                });
                $('#itemFilter').on('change', function() {
                    var selectedValue = $(this).val();
                    //clear
                    if (selectedValue === '') {
                        var table = $('#data-table').DataTable();
                        table.draw();
                    }
                    //ada value
                    else {
                        var table = $('#data-table').DataTable();
                        table.draw();
                    }

                });
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




    })
</script>
@endsection
