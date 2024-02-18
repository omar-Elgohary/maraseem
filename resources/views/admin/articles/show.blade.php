@extends('admin.layouts.admin')
@section('title', 'عرض مقال')

@section('content')
    <section class="show-user">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb bg-light p-3">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">الواجهة</a></li>
                <li href="" class="breadcrumb-item" aria-current="page">
                    عرض مقال
                </li>
            </ol>
        </nav>

        <div class="content_view">
            <div class="row">

                <div class="col-6">
                    @if($article->image)
                    <img src="{{ asset('articles/' . $article->image) }}" height="400" width="300" alt="{{ $article->name }}">
                    @else
                    <img src="{{ asset('images/no-image.jpg') }}" alt="{{ $article->name }}" class="img-product img-thumbnail" width="100px">
                    @endif
                </div>

                <div class="col-6">
                    <label class="small-label">عنوان المقال</label>
                <input readonly type="text" value="{{ $article->title }}" class="form-control">
            </div>

            <div class="col-6">
                <label class="small-label">محتوى المقال</label>
                <textarea name="content" cols="30" rows="10" class="form-control">{{ $article->content }}</textarea>
            </div>

            <div class="col-6">
                <label class="small-label">تاريخ إنشاء المقال</label>
                <input readonly type="text" value="{{ $article->created_at }}" class="form-control">
            </div>
        </div>

        </div>
    </section>
@endsection
