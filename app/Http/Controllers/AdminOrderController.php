<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
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

        $q = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');
        $from = (string) $request->query('from', '');
        $to = (string) $request->query('to', '');
        $perPage = (int) $request->query('per_page', 10);
        if (!in_array($perPage, [10, 25, 50], true)) {
            $perPage = 10;
        }

        $query = Order::query()->latest();

        if ($q !== '') {
            $query->where(function ($qb) use ($q) {
                $qb->where('customer_name', 'like', "%{$q}%")
                   ->orWhere('customer_phone', 'like', "%{$q}%");
            });
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        if ($from !== '') {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to !== '') {
            $query->whereDate('created_at', '<=', $to);
        }

        $orders = $query->paginate($perPage)->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'filters' => compact('q', 'status', 'from', 'to', 'perPage'),
        ]);
    }

    public function show(Request $request, Order $order)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:new,processing,done,cancelled'],
        ], [], [
            'status' => 'الحالة',
        ]);

        $order->status = $validated['status'];
        $order->save();

        return redirect()->route('admin.orders.show', $order)->with('success', 'تم تحديث حالة الطلب.');
    }

    public function destroy(Request $request, Order $order)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'تم حذف الطلب.');
    }

    public function export(Request $request)
    {
        if ($redirect = $this->ensureAdmin($request)) {
            return $redirect;
        }

        $q = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');
        $from = (string) $request->query('from', '');
        $to = (string) $request->query('to', '');

        $query = Order::query()->latest();

        if ($q !== '') {
            $query->where(function ($qb) use ($q) {
                $qb->where('customer_name', 'like', "%{$q}%")
                   ->orWhere('customer_phone', 'like', "%{$q}%");
            });
        }

        if ($status !== '') {
            $query->where('status', $status);
        }

        if ($from !== '') {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to !== '') {
            $query->whereDate('created_at', '<=', $to);
        }

        $orders = $query->get();

        $filename = 'orders-export-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'Customer Name', 'Customer Phone', 'Total', 'Status', 'Created At']);
            foreach ($orders as $order) {
                fputcsv($out, [
                    $order->id,
                    $order->customer_name,
                    $order->customer_phone,
                    $order->total,
                    $order->status,
                    optional($order->created_at)->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
