@extends('admin.layouts.admin')
@section('title','إضافة مقال')

@section('content')
    <section class="" id="app">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb bg-light p-3">
                <li href="" class="breadcrumb-item" aria-current="page">
                    اضافة  مقال
                </li>
            </ol>
        </nav>

        <div class="content_view">
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="row row-gap-24">
                    <div class="col-6">
                        <label>الصورة</label>
                        <input type="file" name="image" id="image" class="form-control mt-3">
                    </div>

                    <div class="col-6">
                        <label>عنوان المقال</label>
                        <input type="text" required name="title" class="form-control mt-3" value="{{ old('title') }}">
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-6">
                        <label>المحتوى</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control mt-3" required>{{ old('content') }}</textarea>
                        @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
