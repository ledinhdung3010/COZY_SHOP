@extends('admin_layout')
@section('title','AddCategories')
@section('breadcrumb-item-1','Categories')
@section('breadcrumb-item-2','Add')
@push('stylesheets')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
<style>
    .mult-select-tag .wrapper{
        padding-left: 0 !important;
    }
    .ck-editor__editable{
        min-height: 500px !important;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <h5 class="text-center">Add Category</h5>
        <a href="{{route('admin.category')}}" class="btn btn-primary my-3">Back to list categories</a>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('admin.category.create')}}" class="border p-3" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                    </div>
                    <div class="mb-3">
                        <label for="">Icon</label>
                        <input type="file" class="form-control" name="icon" value="">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <label for="">Status</label>
                        <select name="status" id="" class="form-control">
                            <option value="">-- Chose --</option>
                            <option value="1"  {{old('status')=="1" ? 'selected': ''}}>Active</option>
                            <option value="2" {{old('status')=="2" ? 'selected': ''}}>In Active</option>
                        </select>
                    </div> 
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="mb-3">
                        <label for="">Description</label>
                        <textarea name="description" id="editor"  class="form-control" rows="10">
                        </textarea>
                    </div>
                    <button  type="submit" class="btn btn-primary btn-lg">Submit</button>
                </div>
            </div>
            
            
        </form>
    </div>
</div>
@endsection