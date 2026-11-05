@extends('layouts.app')
@section('title', 'Edit Jalur - BikePath')
@section('inline_errors', '1')
@section('content')
<div class="form-page animate-slide-in">
    <div class="page-title"><x-icon name="pencil" :size="36" color="#00a8e8" /><h1>EDIT JALUR</h1></div>
    <div class="card-duo">
        <form method="POST" action="{{ route('jalur.update', $jalur) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('jalur._form')
            <div class="form-actions">
                <a href="{{ route('activity') }}#jalur" class="btn-duo btn-outline">BATAL</a>
                <button type="submit" class="btn-duo btn-primary">UPDATE</button>
            </div>
        </form>
    </div>
</div>
@endsection
