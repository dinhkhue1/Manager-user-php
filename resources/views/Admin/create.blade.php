@extends('Admin.userManager')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3>{{ isset($user) ? 'Chỉnh sửa thông tin sinh viên' : 'Thêm sinh viên' }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form class="modal-content animate" action="{{ isset($user) ? route('user.update', $user->id) : route('user.create-user') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Họ và tên</strong>
                                    <input type="text" placeholder="Enter name" name="name" required class="form-control" value="{{ isset($user) ? $user->name : '' }}">
                                </div>
                                <div class="form-group">
                                    <strong>Email</strong>
                                    <input type="text" placeholder="Enter email" name="email" class="form-control" required value="{{ isset($user) ? $user->email : '' }}">
                                </div>
                                <div class="form-group">
                                    <strong>Password</strong>
                                    <input type="password" placeholder="Enter Password" name="password" class="form-control" required>
                                </div>
                            </div>
                        
                        
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Gender</strong>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" value="male" id="male" {{ isset($user) && $user->gender == 'male' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" value="female" id="female" {{ isset($user) && $user->gender == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <strong>Role</strong>
                                    <select name="role" id="role" class="form-control" required>
                                        <?php
                                            $roles = ['Admin', 'User'];
                                            $userRole = isset($user) ? $user->role : null;
                                            ?>
                                        <?php foreach($roles as $role): ?>
                                            <option value="{{ $role }}" {{ $userRole == $role ? 'selected' : '' }}>
                                                {{ $role }}
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="img"><strong>Img</strong></label>
                                    <input type="file" name="img" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-2">{{ isset($user) ? 'Cập nhật' : 'Lưu' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

