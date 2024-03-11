<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\ProductDetail;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Http\Request;
use PDF;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.transaction.index", [
            "transactions" => Transaction::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transaction = Transaction::create([
            'num' => strtoupper(Str::random(15))
        ]);

        return redirect()->route('transaction.show', $transaction->num);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return view('pages.transaction.show', [
            'transaction' => $transaction,
            'products' => Product::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        if ($request->has('addProduct')) {
            $request->validate([
                'product' => 'required',
                'sum' => 'required'
            ]);

            $product = Product::where('id', $request->get('product'))->first();

            for ($i = 1; $i <= intval($request->get('sum')); $i++) {
                $detail = $product->detail->where('transaction_id', null)->first();
                $detail->transaction_id = $transaction->id;
                $detail->save();

                $transaction->total += $product->price;
                $transaction->save();
            }

            return redirect()->back()->with('success', 'produk berhasil ditambah ke transaksi');
        }

        if ($request->has('deleteProduct')) {
            $product = ProductDetail::where('id', $request->get('id'))->first();
            $product->transaction_id = null;
            $product->save();

            $transaction->total -= $product->product->price;
            $transaction->save();

            return redirect()->back()->with('success', 'produk berhasil dihapus dari transaksi');
        }

        if ($request->has('paidTransaction')) {
            $transaction->paid = $request->get('paid');
            $request->get('paid') > $transaction->total ? $transaction->return = $request->get('paid') - $transaction->total : $transaction->return = 0;
            $transaction->save();

            return redirect()->route('transaction.index')->with('success', 'transaksi berhasil');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $items = ProductDetail::where('transaction_id', $transaction->id)->get();

        foreach ($items as $item) {
            $item->transaction_id = null;
            $item->save();
        }

        $transaction->delete();
        return redirect()->route('transaction.index');
    }

    public function generateInvoice(Request $request)
    {
        $pdf = Pdf::loadView('print.invoice', [
            'transaction' => Transaction::where('num', $request['num'])->get()->first(),
        ]);

        return $pdf->download('invoice.pdf'); // Unduh file PDF dengan nama tertentu
    }
}
