@extends('layouts.app')

@section('content')
    <div class="admin-hero p-4 rounded-4 text-white d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h5 fw-bold mb-1">تعاليق الزبناء</h1>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-white/10 text-white border border-white/20">💬 إجمالي: {{ $comments->count() }}</span>
                <span class="badge bg-white/10 text-white border border-white/20">✅ ظاهر: {{ $comments->where('is_visible', true)->count() }}</span>
                <span class="badge bg-white/10 text-white border border-white/20">🚫 مخفي: {{ $comments->where('is_visible', false)->count() }}</span>
            </div>
        </div>
        <form method="post" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-outline-light rounded-pill" type="submit">تسجيل الخروج</button>
        </form>
    </div>

    <div class="card p-3">
        @if($comments->isEmpty())
            <div class="text-muted">لا توجد تعاليق بعد.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>التقييم</th>
                        <th>التعليق</th>
                        <th>الحالة</th>
                        <th>تاريخ الإضافة</th>
                        <th style="width:180px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->rating ? $c->rating . ' / 5' : '-' }}</td>
                            <td style="max-width:260px;">
                                <div class="small text-muted text-wrap">{{ $c->message }}</div>
                            </td>
                            <td>
                                @if($c->is_visible)
                                    <span class="badge text-bg-success">ظاهر في الموقع</span>
                                @else
                                    <span class="badge text-bg-secondary">مخفي</span>
                                @endif
                            </td>
                            <td>{{ $c->created_at?->format('Y-m-d') }}</td>
                            <td class="text-end">
                                <form method="post" action="{{ route('admin.comments.toggle', $c) }}" class="d-inline">
                                    @csrf
                                    @method('patch')
                                    <button class="btn btn-sm btn-outline-dark rounded-pill px-3" type="submit">
                                        {{ $c->is_visible ? 'إخفاء' : 'إظهار' }}
                                    </button>
                                </form>
                                <form method="post" action="{{ route('admin.comments.destroy', $c) }}" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" type="submit"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا التعليق؟');">
                                        حذف
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
@endsection
