<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Image;

class BrandController extends Controller
{
    //
    public function brandView()
    {
        $brands = Brand::latest()->get();
        return view('backend.brand.brand_view', compact('brands'));
    }

    public function brandStore(Request $request)
    {
        $request->validate(
            [
            'brand_name_en' => 'required',
            'brand_name_hin' => 'required',
            'brand_image' => 'required'
        ],
            [
                'brand_name_en.required' => 'Input Brand English Name',
                'brand_name_hin.required' => 'Input Brand Hindu Name',
            ]
        );
        $image = $request->file('brand_image');
        $nameGen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300, 300)->save('upload/brand/'.$nameGen);
        $save_url = 'upload/brand/'.$nameGen;
        Brand::insert([
            'brand_name_en' => $request->brand_name_en,
            'brand_name_hin' => $request->brand_name_hin,
            'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
            'brand_slug_hin' => strtolower(str_replace(' ', '-', $request->brand_name_hin)),
            'brand_image' => $save_url
        ]);
        $notification = array(
            'message'=>'Brand Inserted Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function brandEdit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.brand.brand_edit', compact('brand'));
    }

    public function update(Request $request)
    {
        $brandId = $request->id;
        $oldImage = $request->old_image;

        if ($request->file('brand_image')) {
            $image = $request->file('brand_image');
            $nameGen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300, 300)->save('upload/brand/'.$nameGen);
            $save_url = 'upload/brand/'.$nameGen;
            Brand::findOrFail($brandId) -> update([
                'brand_name_en' => $request->brand_name_en,
                'brand_name_hin' => $request->brand_name_hin,
                'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
                'brand_slug_hin' => strtolower(str_replace(' ', '-', $request->brand_name_hin)),
                'brand_image' => $save_url,
            ]);
            $notification = array(
                'message'=>'Brand Updated Successfully',
                'alert-type' => 'info'
            );
            return redirect()->route('all.brand')->with($notification);
        } else {
            Brand::findOrFail($brandId) -> update([
                'brand_name_en' => $request->brand_name_en,
                'brand_name_hin' => $request->brand_name_hin,
                'brand_slug_en' => strtolower(str_replace(' ', '-', $request->brand_name_en)),
                'brand_slug_hin' => strtolower(str_replace(' ', '-', $request->brand_name_hin))
            ]);
            $notification = array(
                'message'=>'Brand Updated Successfully',
                'alert-type' => 'info'
            );
            return redirect()->route('all.brand')->with($notification);
        }
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        $image = $brand->brand_image;
        unlink($image);
        Brand::findOrFail($id)->delete();
        $notification = array(
            'message'=>'Brand Deleted Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
