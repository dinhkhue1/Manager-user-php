@extends('Admin.userManager')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Quản lý user</h3>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('create-user')}}" class="btn btn-primary float-end">Thêm mới</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>gender</th>
                                <th>role</th>
                                <th>IMG</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->gender}}</td>
                                    <td>{{$item->role}}</td>
                                    <td>
                                        @if ($item->img)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($item->img) }}" alt="User Image" style="max-width: 100px; max-height: 100px;">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{route('user.destroy', $item->id)}}" method="POST">
                                            <a href="{{route('user.edit', $item->id)}}" class="btn btn-info">Sửa</a>
                                            @csrf
                
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{$user->links()}}
            </div>
        </div>
    </div>
@endsection

