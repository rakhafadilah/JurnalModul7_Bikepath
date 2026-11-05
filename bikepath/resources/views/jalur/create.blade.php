@extends('layouts.app')
@section('title', 'Tambah Jalur - BikePath')
@section('inline_errors', '1')
@section('content')
<div class="form-page animate-slide-in">
    <div class="page-title"><x-icon name="plus-circle" :size="36" color="#00a8e8" /><h1>TAMBAH JALUR</h1></div>
    <div class="card-duo">
        <form method="POST" action="{{ route('jalur.store') }}" enctype="multipart/form-data">
            @csrf
            @include('jalur._form')
            <div class="form-actions">
                <a href="{{ route('activity') }}#jalur" class="btn-duo btn-outline">BATAL</a>
                <button type="submit" class="btn-duo btn-primary">SIMPAN</button>
            </div>
        </form>
    </div>
</div>
@endsection
