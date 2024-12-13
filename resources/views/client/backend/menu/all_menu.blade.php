@extends('client.client_dashboard')
@section('client')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Semua Menu</h4>
                    <div class="page-title-right">
                        <ol class="m-0 breadcrumb">
                            <a href="{{ route('add.menu') }}" class="btn btn-primary waves-effect waves-light">Add Menu</a>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name Menu</th>
                                    <th>Image</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menu as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->menu_name }}</td>
                                    <td><img src="{{ asset($item->image) }}" alt="" style="width: 70px; height:40px;"></td>
                                    <td>
                                        <a href="{{ route('edit.menu', $item->id) }}" class="btn btn-info waves-effect waves-light">Edit</a>
                                        <a href="{{ route('delete.menu', $item->id) }}" class="btn btn-danger waves-effect waves-light" id="delete">Hapus</a>
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
@endsection
