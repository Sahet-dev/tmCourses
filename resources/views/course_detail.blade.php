<!-- resources/views/course_detail.blade.php -->
@extends('layouts.app')

@section('content')
    <course-detail :id="{{ $id }}"></course-detail>
@endsection
