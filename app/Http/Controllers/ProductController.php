<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // return view('admin.v_product');
        return 'Ini adalah halaman product yang hanya bisa diakses oleh admin';
    }

    public function create(Request $request)
    {

        if ($request->hasFile('pic')) {
            $fileName = Str::slug($request->name) . '-' . time() . '.' . $request->pic->extension();
            $request->pic->move(public_path('images'), $fileName);
        } else {
            $fileName = 'default.jpg';
        }

        $create = Product::create(
            [
                'name' => $request->name,           // input name='name'
                'pic' => $fileName,             // <input type='file' name='pic'>
                'desc' => $request->desc,           // input name='desc'
                'price' => $request->price,         // input name='price'
                'discount' => $request->discount    // input name='discount'
            ]
        );

        if ($create) {
            $result = [
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ];
        } else {
            $result = [
                'status' => false,
                'message' => 'Data gagal disimpan'
            ];
        }

        return response()->json($result);
    }

    public function read()
    {
        $dataProducts = Product::latest()->get();

        return response()->json($dataProducts);
    }

    public function update(Request $request)
    {
        // $dataSebelumnya = Product::where('id', $request->id)->first();
        $dataSebelumnya = Product::find($request->id);

        if ($request->hasFile('pic')) {
            $fileName = Str::slug($request->name) . '-' . time() . '.' . $request->pic->extension();
            $request->pic->move(public_path('images'), $fileName);
            File::delete(public_path('images/' . $dataSebelumnya->pic));
        } else {
            $fileName = $dataSebelumnya->pic;
        }

        $update = Product::where('id', $request->id)->update(
            [
                'name' => $request->name,           // input name='name'
                'pic' => $fileName,                 // <input type='file' name='pic'>
                'desc' => $request->desc,           // input name='desc'
                'price' => $request->price,         // input name='price'
                'discount' => $request->discount    // input name='discount'
            ]
        );

        if ($update) {
            $result = [
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ];
        } else {
            $result = [
                'status' => false,
                'message' => 'Data gagal diupdate'
            ];
        }

        return response()->json($result);
    }

    public function delete(Request $request)
    {
        $dataSebelumnya = Product::find($request->id);

        $delete = Product::where('id', $request->id)->delete();

        File::delete(public_path('images/' . $dataSebelumnya->pic));

        if ($delete) {
            $result = [
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ];
        } else {
            $result = [
                'status' => false,
                'message' => 'Data gagal dihapus'
            ];
        }

        return response()->json($result);
    }

    private function _hitungDiscount(float $harga, float $diskon)
    {
        return $harga - ($harga * ($diskon / 100));
    }
}
