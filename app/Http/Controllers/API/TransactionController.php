<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request)
    {   
        $id     = $request->input('id');
        $limit  = $request->input('limit', 6);
        $status = $request->input('status');

        if($id)
        {
            $transaction = Transaction::with(['items'])->find($id);
            if($transaction){
                return ResponseFormatter::success(
                    $transaction,
                    'Berhasil Menampilkan Data Transaksi'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Tidak Ada Data Transaksi',
                    404
                );
            }
        }

        $transaction = Transaction::with(['items'])->where('user_id', Auth::user()->id);

        if($status){
            $transaction->where('status', $status);
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Berhasil Menampilkan List Data Transaksi'
        );
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items'          => 'required|array',
            'items.*.id'     => 'exists:products,id',
            'total_price'    => 'required',
            'shipping_price' => 'required',
            'status'         => 'required|in:Pending, Success, Cancelled, Failed, Shipping, Shipped'
        ]);

        $transaction = Transaction::create([
            'user_id'        => Auth::user()->id,
            'address'        => $request->address,
            'total_price'    => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'status'         => $request->status
        ]);

        foreach ($request->items as $product) {
            TransactionDetail::create([
                'user_id'           => Auth::user()->id,
                'product_id'        => $product['id'],
                'transaction_id'    => $transaction->id,
                'quantity'          => $product['quantity']
            ]);
        }

        return ResponseFormatter::success($transaction->load('items'), 'Transaksi Berhasil');
    }
}
