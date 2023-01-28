<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductStock;
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
            $data = ProductStock::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->setTransformer(function ($item) {
                    $editUrl = route('product.stock.edit', $item->id);
                    $editButton = '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>';
                    // delete button with onclick event

                    $deleteButton = '<button class="delete btn btn-danger btn-sm" onclick="deleteData(' . $item->id . ' )">Delete</button>';

                    $buttonList = $editButton . ' ' . $deleteButton;
                    return [
                        'id'         => $item->id,
                        'product_name' => $item->product_name,
                        'current_stock' => $item->current_stock,
                        'total_stock' => $item->total_stock,
                        'code' => $item->code,
                        'sell_price' => number_format($item->sell_price, 0, '.', ','),
                        'action' => $buttonList,
                    ];
                })
                ->make(true);
        }
    }

    public function Create(Request $request)
    {
        return view('product.stock.stock_create');
    }

    public function CreateSubmit(Request $request)
    {
        $stock = new ProductStock();
        $stock->product_name = $request->product_name;
        $stock->current_stock = $request->current_stock;
        $stock->total_stock = $request->total_stock;
        $stock->code = $request->code;
        $stock->sell_price = $request->sell_price;

        $stock->save();
        return redirect()->route('product.stock.index');
    }

    public function Update(Request $request)
    {

        $id = $request->id;

        $detail = ProductStock::where('id', $id)->first();
        return view('product.stock.stock_detail', compact('detail'));
    }

    public function UpdateSubmit(Request $request)
    {
        $id_stock = $request->id;
        $find = ProductStock::where('id', $id_stock)->first();
        $find->product_name = $request->product_name;
        $find->current_stock = $request->current_stock;
        $find->total_stock = $request->total_stock;
        $find->code = $request->code;
        $find->sell_price = $request->sell_price;
        $find->save();

        return redirect()->route('product.stock.index');
    }
    public function Delete(Request $request)
    {
        $id = $request->id;
        $deleted = ProductStock::where('id', $id)->delete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    // public function Import(Request $request)
    // {
    //     Excel::import(new ProductStockImport, request()->file('file'));
    //     return response()->json([
    //         'success' => 'Record imported successfully!'
    //     ]);
    // }
}
