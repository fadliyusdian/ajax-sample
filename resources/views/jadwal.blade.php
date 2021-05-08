@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('home') }}">< Kembali ke Home</a>
            <div class="card">
                <div class="card-header ">
                    <div class="row">
                        <h5 class="card-title col-md-6">Master Jadwal Pelajaran</h5>
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
                                    <th>Mata Pelajaran</th>
                                    <th>Hari</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($jadwal as $item)
                                    <tr id="row_{{ $item->id }}">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->mapel->nama }}</td>
                                        <td>{{ $item->hari->nama }}</td>
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
                  <label for="nama">Mata Pelajaran</label>
                  <select name="mapel" id="mapel" class="form-control">
                      @foreach ($mapel as $item)
                          <option value="{{ $item->id }}">{{ $item->nama }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group">
                  <label for="hari">Hari</label>
                  <select name="hari" id="hari" class="form-control">
                      @foreach ($hari as $item)
                          <option value="{{ $item->id }}">{{ $item->nama }}</option>
                      @endforeach
                  </select>
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
          <input type="hidden" class="form-control" id="edit_id">
          <div class="modal-body">
              <div class="form-group">
                  <label for="nama">Mata Pelajaran</label>
                  <select name="mapel" id="mapel" class="form-control">
                      @foreach ($mapel as $item)
                          <option value="{{ $item->id }}">{{ $item->nama }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group">
                  <label for="hari">Hari</label>
                  <select name="hari" id="hari" class="form-control">
                      @foreach ($hari as $item)
                          <option value="{{ $item->id }}">{{ $item->nama }}</option>
                      @endforeach
                  </select>
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
                url: "{{ route('jadwal-pelajaran.store') }}",
                method: "POST",
                data: $('#formAddModal').serialize(),
                success: function(result) {
                    console.log(result);
                    if(result.status) {
                        swal('Sukses!', result.msg, 'success');
                        Table.append(`<tr id="row_${result.data.id}">
                                        <td>${result.data.id}</td>
                                        <td>${result.data.mapel.nama}</td>
                                        <td>${result.data.hari.nama}</td>
                                        <td>${result.data.created_at}</td>
                                        <td>${result.data.updated_at}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="modalEdit(${result.data.id})">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="btnDelete(${result.data.id})">Delete</button>
                                        </td>
                                    </tr>`)
                    } else {
                        swal('Gagal!', result.msg, 'error');
                    }
                }
            })
        }

        function modalEdit(id) {
            $.get('{{ route("jadwal-pelajaran.index") }}/'+id, (result) => {
                FormEdit.find('select[name=mapel]').val(result.mata_pelajaran_id);
                FormEdit.find('select[name=hari]').val(result.hari_id);
                FormEdit.find('#edit_id').val(result.id);

                $('#editModal').modal('show');
            })
        }
        function btnEdit() {
            let id = $('#edit_id').val();
            $.ajax({
                url: "{{ route('jadwal-pelajaran.index') }}/"+id,
                method: "POST",
                data: FormEdit.serialize(),
                success: function(result) {
                    console.log(result)
                    if(result.status) {
                        swal('Sukses!', result.msg, 'success');
                        $('#row_'+id).html(`<td>${result.data.id}</td>
                                        <td>${result.data.mapel.nama}</td>
                                        <td>${result.data.hari.nama}</td>
                                        <td>${result.data.created_at}</td>
                                        <td>${result.data.updated_at}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="modalEdit(${result.data.id})">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="btnDelete(${result.data.id})">Delete</button>
                                        </td>`)
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
                        url: "{{ route('jadwal-pelajaran.index') }}/"+id,
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
