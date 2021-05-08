@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('home') }}">< Kembali ke Home</a>
            <div class="card">
                <div class="card-header ">
                    <div class="row">
                        <h5 class="card-title col-md-6">Master Mata Pelajaran</h5>
                        <div class="col-md-6">

                            <button class=" btn btn-sm btn-secondary float-right" type="button" data-toggle="modal" data-target="#addModal">Tambah Data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tableData">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($mapel as $item)
                                    <tr id="row_{{ $item->id }}">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="modalEdit({{ $item->id }})">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="btnDelete({{ $item->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Tambah Mata Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formAddModal">
          @csrf
          <div class="modal-body">
              <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" name="nama">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="btnCreate()">Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Tambah Mata Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formeditModal">
          @csrf
          @method('PUT')
          <div class="modal-body">
              <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" name="nama">
                  <input type="hidden" class="form-control" id="edit_id">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="btnEdit()">Save changes</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('js')
    <script>
        const Table = $('#tableData');
        const FormAdd = $('#formAddModal');
        const FormEdit = $('#formeditModal');
        function btnCreate() {
            $.ajax({
                url: "{{ route('mapel.store') }}",
                method: "POST",
                data: $('#formAddModal').serialize(),
                success: function(result) {
                    if(result.status) {
                        swal('Sukses!', result.msg, 'success');
                        Table.append(`<tr id="row_${result.data.id}">
                                        <td>${result.data.id}</td>
                                        <td>${result.data.nama}</td>
                                        <td>${result.data.created_at}</td>
                                        <td>${result.data.updated_at}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="modalEdit(${result.data.id})">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="btnDelete(${result.data.id})">Delete</button>
                                        </td>
                                    </tr>`)
                        $('#addModal').modal('hide')
                    } else {
                        swal('Gagal!', result.msg, 'error');
                    }
                }
            })
        }

        function modalEdit(id) {
            $.get('{{ route("mapel.index") }}/'+id, (result) => {
                FormEdit.find('input[name=nama]').val(result.nama);
                FormEdit.find('#edit_id').val(result.id);

                $('#editModal').modal('show');
            })
        }
        function btnEdit() {
            let id = $('#edit_id').val();
            $.ajax({
                url: "{{ route('mapel.index') }}/"+id,
                method: "POST",
                data: FormEdit.serialize(),
                success: function(result) {
                    console.log(result)
                    if(result.status) {
                        swal('Sukses!', result.msg, 'success');
                        $('#row_'+id).html(`<td>${result.data.id}</td>
                                        <td>${result.data.nama}</td>
                                        <td>${result.data.created_at}</td>
                                        <td>${result.data.updated_at}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="modalEdit(${result.data.id})">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="btnDelete(${result.data.id})">Delete</button>
                                        </td>`)
                        $('#editModal').modal('hide')
                                
                    } else {
                        swal('Gagal!', result.msg, 'error');
                    }
                }
            })
        }

        function btnDelete(id) {
            swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this record!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('mapel.index') }}/"+id,
                        method: "DELETE",
                        data: {
                            _token : "{{ csrf_token() }}"
                        },
                        success: function (result) {
                            if(result.status) {
                                swal(result.msg, {
                                    icon: "success",
                                }).then(() =>
                                    $('#row_'+id).remove()
                                );
                            }
                        }
                    })
                } else {
                    swal("Your record file is safe!");
                }
            });
        }
    </script>
@endpush
