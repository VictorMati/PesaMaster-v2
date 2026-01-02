@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Contact Support</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('support.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="message" class="form-label">Your Message</label>
            <textarea class="form-control" id="message" name="message" rows="4"
                      placeholder="Describe your issue here..." required>{{ old('message') }}</textarea>
            @error('message')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div><br>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane me-2"></i> Send Message
        </button>
    </form>
</div>
@endsection
