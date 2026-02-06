@extends('layouts.app')

@section('content')
<div class="admin-layout">
    @include('admin.partials.sidebar')

    <section>
        <div class="admin-hero p-4 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold mb-2">تعاليق الزبناء</h1>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25">💬 إجمالي: {{ $comments->count() }}</span>
                    <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25">✅ ظاهر: {{ $comments->where('is_visible', true)->count() }}</span>
                    <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-25">🚫 مخفي: {{ $comments->where('is_visible', false)->count() }}</span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm p-3 rounded-4">
            @if($comments->isEmpty())
                <div class="text-muted p-4 text-center">لا توجد تعاليق بعد.</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="bg-light">
                        <tr>
                            <th class="border-0 rounded-start">#</th>
                            <th class="border-0">الاسم</th>
                            <th class="border-0">التقييم</th>
                            <th class="border-0">التعليق</th>
                            <th class="border-0">الحالة</th>
                            <th class="border-0">تاريخ الإضافة</th>
                            <th class="border-0 rounded-end" style="width:180px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($comments as $c)
                            <tr>
                                <td class="fw-bold text-muted">{{ $c->id }}</td>
                                <td class="fw-bold">{{ $c->name }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-1 text-warning">
                                        <span class="fw-bold text-dark">{{ $c->rating }}</span>
                                        <small>★</small>
                                    </div>
                                </td>
                                <td style="max-width:260px;">
                                    <div class="small text-muted text-wrap">{{ $c->message }}</div>
                                </td>
                                <td>
                                    @if($c->is_visible)
                                        <span class="badge bg-success bg-opacity-10 text-success px-3">ظاهر</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3">مخفي</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $c->created_at?->format('Y-m-d') }}</td>
                                <td class="text-end">
                                    <form method="post" action="{{ route('admin.comments.toggle', $c) }}" class="d-inline">
                                        @csrf
                                        @method('patch')
                                        <button class="btn btn-sm {{ $c->is_visible ? 'btn-outline-secondary' : 'btn-outline-success' }} rounded-pill px-3" type="submit">
                                            {{ $c->is_visible ? 'إخفاء' : 'إظهار' }}
                                        </button>
                                    </form>
                                    <form method="post" action="{{ route('admin.comments.destroy', $c) }}" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-light border text-danger rounded-circle ms-1" type="submit"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا التعليق؟');" title="حذف">
                                            &times;
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
