<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    private function ensureAdmin(Request $request)
    {
        if (!$request->session()->get('is_admin')) {
            return redirect()->route('admin.login');
        }

        return null;
    }

    public function index(Request $request)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        $comments = Comment::query()
            ->latest()
            ->get();

        return view('admin.comments.index', [
            'comments' => $comments,
        ]);
    }

    public function toggle(Request $request, Comment $comment)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        $comment->is_visible = !$comment->is_visible;
        $comment->save();

        return redirect()->route('admin.comments.index')->with('success', 'تم تحديث حالة التعليق.');
    }

    public function destroy(Request $request, Comment $comment)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'تم حذف التعليق.');
    }
}

