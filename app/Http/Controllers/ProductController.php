<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class= d-flex>';
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    $btn .= ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="view btn btn-info btn-sm">View</a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('products.index');
    }



    public function store(Request $request)
    {
        Product::updateOrCreate(['id' => $request->product_id],
            ['name' => $request->name, 'description' => $request->description, 'price' => $request->price]);
        return response()->json(['success'=>'Product saved successfully.']);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
