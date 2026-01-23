<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'max:1000'],
        ], [], [
            'name' => 'الاسم',
            'rating' => 'التقييم',
            'message' => 'التعليق',
        ]);

        Comment::create($validated);

        return back()->with('success', 'شكرا! تم إضافة تعليقك بنجاح.');
    }
}
