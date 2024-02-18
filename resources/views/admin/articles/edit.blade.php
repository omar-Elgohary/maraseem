@extends('admin.layouts.admin')
@section('title', 'تعديل مقال')

@section('content')
    <section class="" id="app">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb bg-light p-3">
                <li href="" class="breadcrumb-item" aria-current="page">
                    تعديل مقال
                </li>
            </ol>
        </nav>

        <div class="content_view">
            <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="row row-gap-24">
                    <div class="col-6">
                        <label>الصورة</label>
                        <input type="file" name="image" id="image" class="form-control mt-3">
                    </div>

                    <div class="col-6">
                        <label>عنوان المقال</label>
                        <input type="text" required name="title" value="{{ $article->title }}" class="form-control mt-3" value="{{ old('title') }}">
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-6 text-center">
                        <img src="{{ asset('articles/' . $article->image) }}" width="300" height="400" alt="">
                    </div>

                    <div class="col-6">
                        <label>المحتوى</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control mt-3" required>{{ ($article->content) }}</textarea>
                        @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </div>
                </div>
        </div>
        </form>
        </div>
    </section>
@endsection
