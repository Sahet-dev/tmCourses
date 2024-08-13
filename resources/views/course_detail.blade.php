<!-- resources/views/course-detail.blade.php -->
@extends('layouts.app')

@section('content')
    <div id="app">
        <course-detail></course-detail>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/app.js') }}" defer></script>
@endpush
