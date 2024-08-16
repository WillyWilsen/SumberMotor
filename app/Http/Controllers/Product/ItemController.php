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

class ItemController extends Controller
{
    public function index(Request $request)
    {
        return view('product.item.item');
    }
    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $data = Item::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->setTransformer(function ($item) {
                    if (auth()->user()->can('product-item-admin')) {
                        $editUrl = route('product.item.edit', $item->id);
                        $editButton = '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>';
                        // delete button with onclick event

                        $deleteButton = '<button class="delete btn btn-danger btn-sm" onclick="deleteData(' . $item->id . ' )">Delete</button>';

                        $buttonList = $editButton . ' ' . $deleteButton;
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'type' => $item->type,
                            'code' => $item->code,
                            'sell_price' => number_format($item->sell_price, 0, '.', ','),
                            'action' => $buttonList,
                        ];
                    } else {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'type' => $item->type,
                            'code' => $item->code,
                            'sell_price' => number_format($item->sell_price, 0, '.', ','),
                        ];
                    }
                })
                ->make(true);
        }
    }

    public function Create(Request $request)
    {
        return view('product.item.item_create');
    }

    public function CreateSubmit(Request $request)
    {
        if (!$request->name) {
            return redirect()->back()->with('error', 'Name must be filled');
        } else if (!$request->type) {
            return redirect()->back()->with('error', 'Brand/Type must be filled');
        } else if (!$request->code) {
            return redirect()->back()->with('error', 'Code must be filled');
        } else if (!$request->sell_price) {
            return redirect()->back()->with('error', 'Sell Price must be filled');
        }

        $item = new Item();
        $item->name = $request->name;
        $item->type = $request->type;
        $item->code = $request->code;
        $item->sell_price = $request->sell_price;

        $item->save();

        $stock = new Stock();
        $stock->item_id = $item->id;
        $stock->quantity = 0;

        $stock->save();

        $log = new Log();
        $log->message = 'Create Item ' . $item->name . ' with sell price ' . $item->sell_price;
        $log->created_by = auth()->user()->id;

        $log->save();
        return redirect()->route('product.item.index');
    }

    public function Update(Request $request)
    {
        $id = $request->id;

        $detail = Item::where('id', $id)->first();
        return view('product.item.item_detail', compact('detail'));
    }

    public function UpdateSubmit(Request $request)
    {
        if (!$request->name) {
            return redirect()->back()->with('error', 'Name must be filled');
        } else if (!$request->type) {
            return redirect()->back()->with('error', 'Brand/Type must be filled');
        } else if (!$request->code) {
            return redirect()->back()->with('error', 'Code must be filled');
        } else if (!$request->sell_price) {
            return redirect()->back()->with('error', 'Sell Price must be filled');
        }

        $id_item = $request->id;
        $find = Item::where('id', $id_item)->first();

        $log = new Log();
        $log->message = 'Update Item from ' . $find->name . ' to ' . $request->name . ' with sell price from ' . $find->sell_price . ' to ' . $request->sell_price;
        $log->created_by = auth()->user()->id;

        $log->save();

        $find->name = $request->name;
        $find->type = $request->type;
        $find->code = $request->code;
        $find->sell_price = $request->sell_price;
        $find->save();
        return redirect()->route('product.item.index');
    }

    public function Delete(Request $request)
    {
        $id = $request->id;
        $find = Item::where('id', $id)->first();
        $deleted = Item::where('id', $id)->delete();
        $deleted = Stock::where('item_id', $id)->delete();

        $log = new Log();
        $log->message = 'Delete Item ' . $find->name . ' with sell price ' . $find->sell_price;
        $log->created_by = auth()->user()->id;

        $log->save();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    // public function Import(Request $request)
    // {
    //     Excel::import(new ItemImport, request()->file('file'));
    //     return response()->json([
    //         'success' => 'Record imported successfully!'
    //     ]);
    // }
}
