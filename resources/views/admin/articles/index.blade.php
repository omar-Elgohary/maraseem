@extends('admin.layouts.admin')
@section('title','المقالات')

@section('content')
    <section class="">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-light p-3">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">الواجهة</a></li>
        <li href="" class="breadcrumb-item" aria-current="page">المقالات</li>
        </ol>
    </nav>
    <div class="section_content content_view">
        <div class="info_holder d-flex align-items-center flex-wrap  gap-2 mb-2">
        <div class="up_element">
            <a href="{{ route('admin.articles.create') }}" class="btn btn-success">إضافة مقال</a>
        </div>
        </div>
        <div class="table-responsive">
        <table class="table table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>الصورة</th>
                    <th>عنوان المقال</th>
                    <th>المحتوى</th>
                    <th>تاريخ الإنشاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>

            <tbody>
            @foreach($articles as $key => $article)
                <tr>
                    <th>{{ $key+1 }}</th>
                    <td>
                        @if($article->image)
                            <img src="{{ asset('articles/' . $article->image) }}" alt="{{ $article->name }}" class="img-product img-thumbnail" width="100px">
                        @else
                            <img src="{{ asset('images/no-image.jpg') }}" alt="{{ $article->name }}" class="img-product img-thumbnail" width="100px">
                        @endif
                    </td>
                    <td class="text-nowrap">{{ $article->title }}</td>
                    <td class="text-nowrap">{{ Str::substr($article->content, 0, 30) }}</td>
                    <td class="text-nowrap">{{ $article->created_at }}</td>

                    <td class="text-nowrap">
                        <a href="{{ route('admin.articles.show', $article->id) }}" class="btn btn-info btn-sm text-nowrap">عرض <i class="fa fa-eye"></i></a>
                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-success btn-sm text-nowrap">تعديل <i class="fa fa-check"></i></a>

                        <button type="button" class="btn btn-danger btn-sm text-nowrap" data-bs-toggle="modal"
                        data-bs-target="#delete{{ $article->id }}">حذف <i class="fa fa-times"></i>
                        </button>
                    </td>

                    <td class="text-nowrap">
                        @include('admin.articles.action')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $articles->links() }}
        </div>
    </div>
    </section>
@endsection
