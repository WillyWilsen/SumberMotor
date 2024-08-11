<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Log;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        return view('product.transaction.transaction');
    }
    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->setTransformer(function ($transaction) {
                    // $editUrl = route('product.transaction.edit', $transaction->id);
                    // $editButton = '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>';
                    // delete button with onclick event

                    // $deleteButton = '<button class="delete btn btn-danger btn-sm" onclick="deleteData(' . $transaction->id . ' )">Delete</button>';

                    // $buttonList = $editButton . ' ' . $deleteButton;

                    $color = $transaction->quantity < 0 ? 'red' : 'inherit';
                    return [
                        'id' => $transaction->id,
                        'item_name' => '<span style="color: ' . $color . '">' . $transaction->item_name  . '</span>',
                        'quantity' => '<span style="color: ' . $color . '">' . number_format($transaction->quantity, 0, '.', ',') . '</span>',
                        'total_price' => '<span style="color: ' . $color . '">' . number_format($transaction->total_price, 0, '.', ',') . '</span>',
                        'created_by' => '<span style="color: ' . $color . '">' . $transaction->user->name . '</span>',
                        'date' => '<span style="color: ' . $color . '">' . $transaction->created_at->format('Y/m/d H:i:s') . '</span>',
                        // 'action' => $buttonList,
                    ];
                })
                ->make(true);
        }
    }

    public function Create(Request $request)
    {
        $list_item = Item::all();
        return view('product.transaction.transaction_create', compact('list_item'));
    }

    public function CreateSubmit(Request $request)
    {
        if (!$request->item_id) {
            return redirect()->back()->with('error', 'Item must be selected');
        } else if (!$request->quantity) {
            return redirect()->back()->with('error', 'Quantity must be filled');
        } else if ($request->quantity > Stock::where('item_id', $request->item_id)->first()->quantity) {
            return redirect()->back()->with('error', 'Quantity must be less than stock');
        } else if (!$request->total_price) {
            return redirect()->back()->with('error', 'Total Price must be filled');
        }

        $transaction = new Transaction();
        $transaction->item_id = $request->item_id;
        $transaction->item_name = Item::where('id', $request->item_id)->first()->name;
        $transaction->quantity = $request->quantity;
        $transaction->total_price = $request->total_price;
        $transaction->created_by = auth()->user()->id;

        $transaction->save();

        $stock = Stock::where('item_id', $request->item_id)->first();
        $stock->quantity = $stock->quantity - $request->quantity;

        $stock->save();

        $log = new Log();
        $log->message = 'Create Transaction ' . $transaction->item_name . ' with quantity ' . $transaction->quantity . ' and total price ' . $transaction->total_price;
        $log->created_by = auth()->user()->id;

        $log->save();
        return redirect()->route('product.transaction.index');
    }

    // public function Update(Request $request)
    // {

    //     $id = $request->id;

    //     $detail = Transaction::where('id', $id)->first();
    //     return view('product.transaction.transaction_detail', compact('detail'));
    // }

    // public function UpdateSubmit(Request $request)
    // {
    //     $id_transaction = $request->id;
    //     $find = Transaction::where('id', $id_transaction)->first();
    //     $find->item_id = $request->item_id;
    //     $find->quantity = $request->quantity;
    //     $find->total_price = $request->total_price;
    //     $find->save();

    //     return redirect()->route('product.transaction.index');
    // }

    // public function Delete(Request $request)
    // {
    //     $id = $request->id;
    //     $deleted = Transaction::where('id', $id)->delete();

    //     return response()->json([
    //         'success' => 'Record deleted successfully!'
    //     ]);
    // }

    // public function Import(Request $request)
    // {
    //     Excel::import(new TransactionImport, request()->file('file'));
    //     return response()->json([
    //         'success' => 'Record imported successfully!'
    //     ]);
    // }
}
