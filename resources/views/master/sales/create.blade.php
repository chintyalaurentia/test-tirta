@extends('layouts.app')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3>Sales - {{ ($data['form'] == 'create') ? 'Create' : 'Edit' }}</h3>
        </div>
    </div>


    <form id="formInput" class="needs-validation" novalidate action="{{ ($data['form'] == 'create') ? route('master.sales.store') : route('master.sales.update', $data['dataModel']->kode_sales) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
        <div class="card">
            <div class="card-header d-flex align-items-center jusitfy-content-between"><b><i class="fa fa-solid fa-clock mr-2"></i>{{ ($data['form'] == 'create') ? 'Create' : 'Edit' }} Sales</b>
                <div class="btn-group ml-auto" role="group" aria-label="Basic example">
                    <a class="btn btn-outline-dark btn-sm" href="{{ route('master.sales.index') }}" role="button"><i class="fa fa-solid fa-angle-left"></i> Back</a>
                    <button type="submit" class="btn btn-outline-dark btn-sm" id="save"><i class="fa fa-solid fa-save"></i> Save</button>
                </div>
            </div>
            <div class="card-body">
                <div id="deleteContainer">

                </div>

                @if($data['form'] == 'edit')
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="col-form-label" for="">Code <span class="required">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" name="kode" id="kode" value="{{ ($data['form'] == 'create') ? "" : $data['dataModel']->kode_sales }}"required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="col-form-label" for="">Name<span class="required">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" name="nama" id="nama" value="{{ ($data['form'] == 'create') ? "" : $data['dataModel']->nama_sales }}" required>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-8">
                            <div class="btn-group mt-3" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-success btn-sm" id="tambah"><i class="fa fa-solid fa-plus-square"></i> Add</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="kurang"><i class="fa fa-solid fa-minus-square"></i> Remove</button>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="btn-group mt-3" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-success btn-sm" id="import" data-toggle="modal" data-target="#modalImport"><i class="fa fa-file-excel-o"></i> Import</button>
                            </div>
                        </div>
                    </div>
                    <div id="listFrekuensi">
                        <div class="card mt-3 rowFrekuensi" data-row="1">
                            <div class="card-header d-flex align-items-center jusitfy-content-between">
                                <strong id="">Sales 1</strong>
                                <input type="hidden" id="idx1" name="Idx[]" value="1">
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="col-form-label" for="">Code <span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group has-validation">
                                            <input type="text" class="form-control" name="kode[]" id="kode" value="{{ ($data['form'] == 'create') ? "" : $data['val']->Kode }}"required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label class="col-form-label" for="">Name<span class="required">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group has-validation">
                                            <input type="text" class="form-control" name="nama[]" id="nama" value="{{ ($data['form'] == 'create') ? "" : $data['val']->Nama }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </form>

    <form method="POST" action="{{ route('master.sales.import') }}" enctype="multipart/form-data" id="formExcel">
        <div class="modal fade" id="modalImport" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Import </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="col-label" for="">Template</label>
                            </div>
                            <div class="col-md-9">
                                <a href="{{ asset('ListSales.xlsx') }}" type="button" id="import-template" class="btn btn-sm btn-outline-secondary" title="Download File Template">
                                    <i class="fas fa-file-excel"></i>
                                    <span class="ml-2 d-none d-md-inline">Download Template</span>
                                </a>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="col-form-label" for="">File</label>
                            </div>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="excel" id="excel" accept=".xlsx">
                                    <label class="form-control custom-file-label" >Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        $(document.body).on('change', '.custom-file-input', function(e){
            var fileName = e.target.files[0].name;
            $(this).next('.custom-file-label').html(fileName);
        })

        $(document).on('click', '#tambah', function() {
            let lastRowData = $('#listFrekuensi .rowFrekuensi:last-child').data('row');
            let curr_id = lastRowData !== undefined ? lastRowData + 1 : 1;

            // let curr_id = $('#listFrekuensi .rowFrekuensi:last-child').data('row') + 1;
            let length = $('#listFrekuensi .rowFrekuensi').length + 1;
            // alert(btnClicked);

            let template = '\
            <div class="card mt-3 rowFrekuensi" data-row="'+curr_id+'" id="frekuensi'+curr_id+'">\
                <div class="card-header d-flex align-items-center jusitfy-content-between">\
                    <strong id="titleFrek">Sales '+length+'</strong>\
                    <input type="hidden" class="frekIdx" id="idx'+curr_id+'" name="Idx[]" value="'+curr_id+'">\
                    <div class="btn-group ml-auto" role="group" aria-label="Basic example">\
                        <button type="button" class="btn btn-danger btn-md hapus" data-row="'+curr_id+'"><i class="fa fa-solid fa-trash"></i></button>\
                    </div>\
                </div>\
                <div class="card-body">\
                    <div class="row mb-3">\
                        <div class="col-md-3">\
                            <label class="col-form-label" for="">Code <span class="required">*</span></label>\
                        </div>\
                        <div class="col-md-9">\
                            <div class="input-group has-validation">\
                                <input type="text" class="form-control" name="kode[]" id="kode'+curr_id+'" required>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="row mb-3">\
                        <div class="col-md-3">\
                            <label class="col-form-label" for="">Name<span class="required">*</span></label>\
                        </div>\
                        <div class="col-md-9">\
                            <div class="input-group has-validation">\
                                <input type="text" class="form-control" name="nama[]" id="nama'+curr_id+'" required>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>\
            ';

            $('#listFrekuensi').append(template);
        })


        $('#kurang').on('click', function() {
            var lastCard = $('#listFrekuensi').children('.rowFrekuensi[data-row]:last-child');
            // const removedCard =lastCard.closest('.rowFrekuensi');
            var dataRowVal = lastCard.data('row');

            var html = "<input type='hidden' name='deletedRow[]' value='"+dataRowVal+"'>";
                        $("#deleteContainer").append(html);

            lastCard.remove();
            tambahKurangButtons();
        });

        $(document.body).on("click",".hapus",function(e){
                e.preventDefault();

                const removedCard = $(this).closest('.rowFrekuensi');

                Swal.fire({
                title: 'Are You sure want to delete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.value) {
                        // calculateSubTotal(objRow);
                        var html = "<input type='hidden' name='deletedRow[]' value='"+removedCard.find(".frekIdx").val()+"'>";
                        $("#deleteContainer").append(html);
                        removedCard.remove();
                        $('.rowFrekuensi').each(function(index) {
                            const newRow = index + 1;
                            $(this).find('#titleFrek').text('Sales ' + newRow);
                        })

                        tambahKurangButtons();

                        // objRow.remove();

                    }
                })
        });

        $('#formExcel').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('master.sales.import') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response.success){
                        var result = response.injected;
                        $('#modalImport').modal('hide');
                        $('#listFrekuensi').html('');

                        let curr_row = 1;
                        result.forEach(element => {
                            $('#tambah').click();
                            $('#kode'+curr_row).val(element[1]);
                            $('#nama'+curr_row).val(element[2]);
                            curr_row += 1;
                        });

                    }


                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        function validationForm() {
            var result = {
                req: true,
                labelTexts: []
            };

            // var req = true;
            const form = document.getElementById('formInput');
            const requiredInputs = form.querySelectorAll('input[required], select[required], textarea[required]');

            requiredInputs.forEach(function(input) {
                if (!input.value.trim()) {
                    result.req = false;
                    result.labelTexts.push(input.name);
                    return result;
                }
            });
            // console.log(requiredInputs);
            return result;
        }

        $("#formInput").submit(function (e) {
            e.preventDefault();

            var check = validationForm();
            // console.log(check)

            if(!check.req){
                Swal.fire("Please fill all require inputs");
                // toastr.error("Errror", "Please fill all require inputs");
                return false;
            }

            var formData = new FormData(this);
            var action = $(this).find('button[type=submit]:focus').data('action');
            // Append the action to the formData
            formData.append('action', action);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                }
            });

            var typeForm = "{{ $data['form'] }}";
            if(typeForm == "edit"){
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: 		$("#formInput").attr('action'),
                method: 	'POST',
                data:  		formData,
                processData: false,
                contentType: false,
                dataType : 'json',
                encode  : true,
                beforeSend: function(){
                    Swal.fire({
                        title: 'Please Wait',
                        text: 'Your request is being processed',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            })
            .done(function(data){
                // $('#formInput').unblockMessage();
                Swal.close();

                // Handle the successful response here
                if (data.Code == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.Message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route("master.sales.index") }}';
                    });
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request'
                    });
                }
                // console.log(data);

            })
            .fail(function(e) {
                // $('#formInput').unblockMessage();

                Swal.close();

                // Show error message with SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request'
                });
            })
        });
    });
</script>



@endsection
