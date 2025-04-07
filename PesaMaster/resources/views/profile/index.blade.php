@extends('layouts.app')

@section('content')
{{-- profile/profile.blade.php --}}
<div class="container">
    <h2 class="text-center">User Profile</h2>
    <div class="row">
        <!-- Profile Overview Card -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" class="rounded-circle" width="150">
                    <h4 class="mt-2">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h4>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Staff No:</strong> {{ Auth::user()->staff_no }}</p>
                </div>
            </div>
        </div>

        <!-- Edit Profile Card -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Edit Profile</div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>First Name</label>
                            <input type="text" name="firstname" class="form-control" value="{{ Auth::user()->firstname }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Last Name</label>
                            <input type="text" name="lastname" class="form-control" value="{{ Auth::user()->lastname }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                        </div>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Update Password</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Upload Profile Picture Card -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Upload Profile Picture</div>
                <div class="card-body">
                    <form action="{{ route('profile.upload-picture') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label>Select Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-info">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
