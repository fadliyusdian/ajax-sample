@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('home') }}">< Kembali ke Home</a>
            <div class="card">
                <div class="card-header ">
                    <h5 class="card-title">Jadwal Pelajaran</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Mata Pelajaran</label>
                        <select name="mapel" id="mapel" class="form-control">
                            <option value="">PILIH MATA PELAJARAN</option>
                            @foreach ($mapel as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="tableData">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hari</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>

                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
    <script>
        const Table = $('#tableData');
        const TableBody = $('#tableData tbody');
        const MAPEL = $('#mapel');
        
        MAPEL.change(() => {
            let value = MAPEL.val();

            $.post("{{ route('jadwal.mapel') }}", {_token: "{{ csrf_token() }}", mapel: value}, (result) => {
                console.log(result)
                TableBody.html('');
                if(result.status) {
                    result.data.forEach(item => {
                        TableBody.append(`<tr id="row_${item.id}">
                                        <td>${item.id}</td>
                                        <td>${result.mapel.nama}</td>
                                        <td>${item.hari.nama}</td>
                                        <td>${item.created_at}</td>
                                        <td>${item.updated_at}</td>
                                    </tr>`);
                    });
                } else {
                    alert(result.msg)
                }
            })
        })
    </script>
@endpush
