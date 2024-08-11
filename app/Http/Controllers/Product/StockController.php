<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Log;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class StockController extends Controller
{
    public function index(Request $request)
    {
        return view('product.stock.stock');
    }
    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $data = Stock::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->setTransformer(function ($stock) {
                    if (auth()->user()->can('product-stock-admin')) {
                        $editUrl = route('product.stock.edit', $stock->id);
                        $editButton = '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>';
                        // delete button with onclick event

                        // $deleteButton = '<button class="delete btn btn-danger btn-sm" onclick="deleteData(' . $stock->id . ' )">Delete</button>';

                        // $buttonList = $editButton . ' ' . $deleteButton;
                        $buttonList = $editButton;
                        return [
                            'id' => $stock->id,
                            'item_name' => $stock->item->name,
                            'quantity' => number_format($stock->quantity, 0, '.', ','),
                            'total_price' => number_format($stock->quantity * $stock->Item->sell_price, 0, '.', ','),
                            'action' => $buttonList,
                        ];
                    } else {
                        return [
                            'id' => $stock->id,
                            'item_name' => $stock->item->name,
                            'quantity' => number_format($stock->quantity, 0, '.', ','),
                            'total_price' => number_format($stock->quantity * $stock->Item->sell_price, 0, '.', ','),
                        ];
                    }
                })
                ->make(true);
        }
    }

    // public function Create(Request $request)
    // {
    //     return view('product.stock.stock_create');
    // }

    // public function CreateSubmit(Request $request)
    // {
    //     $stock = new Stock();
    //     $stock->item_id = $request->item_id;
    //     $stock->quantity = $request->quantity;

    //     $stock->save();
    //     return redirect()->route('product.stock.index');
    // }

    public function Update(Request $request)
    {
        $id = $request->id;

        $detail = Stock::where('id', $id)->first();
        $list_item = Item::all();
        return view('product.stock.stock_detail', compact('detail', 'list_item'));
    }

    public function UpdateSubmit(Request $request)
    {
        if (!$request->quantity) {
            return redirect()->back()->with('error', 'Quantity must be filled');
        } else if ($request->quantity < 0) {
            return redirect()->back()->with('error', 'Quantity cannot be negative');
        }

        $id_Stock = $request->id;
        $find = Stock::where('id', $id_Stock)->first();

        $log = new Log();
        $log->message = 'Update Stock ' . $find->item->name . ' from ' . $find->quantity . ' to ' . $request->quantity;
        $log->created_by = auth()->user()->id;

        $log->save();

        $find->quantity = $request->quantity;
        $find->save();
        return redirect()->route('product.stock.index');
    }

    // public function Delete(Request $request)
    // {
    //     $id = $request->id;
    //     $deleted = Stock::where('id', $id)->delete();

    //     return response()->json([
    //         'success' => 'Record deleted successfully!'
    //     ]);
    // }

    // public function Import(Request $request)
    // {
    //     Excel::import(new StockImport, request()->file('file'));
    //     return response()->json([
    //         'success' => 'Record imported successfully!'
    //     ]);
    // }
}
