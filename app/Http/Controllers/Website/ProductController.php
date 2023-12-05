<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Paragraph;
use App\Models\Category;
use App\Models\Area;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

      public function __construct()
    {
        if (!session()->get('locale')) {
            session()->put('locale', 'en');
            session()->save();
            app()->setLocale('en');
        }
    }

    public function lang($locale)
    {
        session()->forget('locale');
        session()->put('locale', $locale);
        session()->save();
        app()->setLocale($locale);
        return redirect()->back();
    }

    public function index(Request $request)
    {
        $inputData = $request;
//        App::setLocale(Session::get('locale'));
//        if (session()->get('locale')=='ar')
//        {
//            $sliderImages=Image::where('type','slider')->select('id','image_ar as image')->get();
//            $paragraphs=Paragraph::where('page_number',1)->select('id','value_ar as value')->get();
//        }
//        else
//        {
//            $sliderImages=Image::where('type','slider')->select('id','image_en as image')->get();
//            $paragraphs=Paragraph::where('page_number',1)->select('id','value_en  as value')->get();
//        }
        $categories = Category::where('level', 1)->whereNull('parent_id')->with('sub')->get();

        $products = Product::select('products.stock_status','products.id', 'products.flag', 'products.excluder_flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate',
            'products.price', 'products.old_price', 'products.old_discount', 'products.price_after_discount', 'products.quantity', 'categories.name_en as category_name', 'categories.name_en as category_name_en', 'categories.name_ar as category_name_ar')
            ->leftJoin('product_categories', 'products.id', 'product_categories.product_id')
            ->leftJoin('categories', 'categories.id', 'product_categories.category_id')
            ->where('products.visible_status', '1');
//            ->where('products.stock_status', 'out stock')

//            ->where('products.quantity', '>', 0);

        if (isset($inputData['name']) && $inputData['name'] != '') {
            $valu=$inputData['name'];
            $products->where(function($q) use ($valu) {
                  $q->where('products.name_en', 'like', '%' . $valu . '%')
                    ->orWhere('products.name_ar', 'like', '%' . $valu . '%');
              });
        }
        if (isset($inputData['min_price']) && $inputData['max_price'] != '') {
            $products->whereBetween('products.price', [$inputData['min_price'], $inputData['max_price']]);
        }
        if (isset($inputData['filter_id']) && $inputData['filter_id'] != '') {
            $products->where('products.filter_id', $inputData['filter_id']);
        }
        if (isset($inputData['category_id']) && $inputData['category_id'] != '') {
            $products->where('product_categories.category_id', $inputData['category_id']);
        }

        $products = $products->groupBy('products.id')->orderBy('products.id')->paginate(12);
        return view('product.products', compact('categories', 'products'));
    }

    public function bestseller(Request $request)
    {
        $inputData = $request;
//        App::setLocale(Session::get('locale'));
//        if (session()->get('locale')=='ar')
//        {
//            $sliderImages=Image::where('type','slider')->select('id','image_ar as image')->get();
//            $paragraphs=Paragraph::where('page_number',1)->select('id','value_ar as value')->get();
//        }
//        else
//        {
//            $sliderImages=Image::where('type','slider')->select('id','image_en as image')->get();
//            $paragraphs=Paragraph::where('page_number',1)->select('id','value_en  as value')->get();
//        }
        $categories = Category::where('level', 1)->whereNull('parent_id')->with('sub')->get();

        $products = Product::select('products.stock_status','products.id', 'products.flag', 'products.excluder_flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate',
            'products.price', 'products.old_price', 'products.old_discount', 'products.price_after_discount', 'products.quantity', 'categories.name_en as category_name')
            ->leftJoin('product_categories', 'products.id', 'product_categories.product_id')
            ->leftJoin('categories', 'categories.id', 'product_categories.category_id')
//            ->where('products.stock_status', 'in stock')
            ->where('products.visible_status', '1')
            ->where('products.quantity', '>', 0);

        if (isset($inputData['name']) && $inputData['name'] != '') {
             $valu=$inputData['name'];
            $products->where(function($q) use ($valu) {
                  $q->where('products.name_en', 'like', '%' . $valu . '%')
                    ->orWhere('products.name_ar', 'like', '%' . $valu . '%');
              });
        }
        if (isset($inputData['min_price']) && $inputData['max_price'] != '') {
            $products->whereBetween('products.price', [$inputData['min_price'], $inputData['max_price']]);
        }
        if (isset($inputData['filter_id']) && $inputData['filter_id'] != '') {
            $products->where('products.filter_id', $inputData['filter_id']);
        }
        if (isset($inputData['category_id']) && $inputData['category_id'] != '') {
            $products->where('product_categories.category_id', $inputData['category_id']);
        }

        $products = $products->groupBy('products.id')->orderBy('products.id')->paginate(12);
        return view('product.bestseller', compact('categories', 'products'));
    }

    public function specialoffers(Request $request)
    {
        $inputData = $request;
        $products  = Product::select('products.stock_status','products.id', 'products.flag', 'products.excluder_flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate',
            'products.price', 'products.old_price', 'products.old_discount', 'products.price_after_discount', 'products.quantity', 'categories.name_en as category_name')
            ->leftJoin('product_categories', 'products.id', 'product_categories.product_id')
            ->leftJoin('categories', 'categories.id', 'product_categories.category_id')
//            ->where('products.stock_status', 'in stock')
            ->where('products.visible_status', '1')
            ->whereIn('products.filter_id', ['9'])
            ->where('products.quantity', '>', 0);

        if (isset($inputData['name']) && $inputData['name'] != '') {
            $products->where('products.name_en', 'like', '%' . $inputData['name'] . '%');
        }
        if (isset($inputData['min_price']) && $inputData['max_price'] != '') {
            $products->whereBetween('products.price', [$inputData['min_price'], $inputData['max_price']]);
        }
        if (isset($inputData['filter_id']) && $inputData['filter_id'] != '') {
            $products->where('products.filter_id', $inputData['filter_id']);
        }
        if (isset($inputData['category_id']) && $inputData['category_id'] != '') {
            $products->where('product_categories.category_id', $inputData['category_id']);
        }
        $products = $products->groupBy('products.id')->orderBy('products.id')->paginate(12);

        return view('product.specialoffers', compact('products'));
    }

    public function productDetails(Request $request, $id)
    {
        $inputData = $request;
//        App::setLocale(Session::get('locale'));
//        if (session()->get('locale')=='ar')
//        {
//            $sliderImages=Image::where('type','slider')->select('id','image_ar as image')->get();
//            $paragraphs=Paragraph::where('page_number',1)->select('id','value_ar as value')->get();
//        }
//        else
//        {
//            $sliderImages=Image::where('type','slider')->select('id','image_en as image')->get();
//            $paragraphs=Paragraph::where('page_number',1)->select('id','value_en  as value')->get();
//        }


        $product = Product::select('products.stock_status','products.id', 'products.flag', 'products.excluder_flag', 'products.full_name', 'products.name_en', 'products.name_ar', 'products.description_en',
            'products.description_ar', 'products.image', 'products.oracle_short_code', 'products.discount_rate',
            'products.price', 'products.old_price', 'products.old_discount', 'products.price_after_discount', 'products.quantity', 'categories.name_en as category_name')
            ->leftJoin('product_categories', 'products.id', 'product_categories.product_id')
            ->leftJoin('categories', 'categories.id', 'product_categories.category_id')
//            ->where('products.stock_status', 'in stock')
            ->where('products.visible_status', '1')
            ->where('products.quantity', '>', 0)
            ->where('products.id', $id)->first();
        $reviews=Review::where('product_id',$id)->where('status','1')->with('user')->get();
        $reviewsavg=Review::where('product_id',$id)->where('status','1')->pluck('rate')->avg();
        $reviewsavg=ceil($reviewsavg);
        return view('product.product-details', compact('product','reviews','reviewsavg'));
    }


    public function free()
    {
        App::setLocale(Session::get('locale'));
        if (session()->get('locale') == 'ar') {
            $sliderImages = Image::whereIn('type', ['freePlanBanner', 'freePlanBannerLeft', 'freePlanBannerRigth'])->select('id', 'image_ar as image')->get();
            $paragraphs   = Paragraph::where('page_number', 2)->select('id', 'value_ar as value')->get();
        }
        else {
            $sliderImages = Image::whereIn('type', ['freePlanBanner', 'freePlanBannerLeft', 'freePlanBannerRigth'])->select('id', 'image_en as image')->get();
            $paragraphs   = Paragraph::where('page_number', 2)->select('id', 'value_en  as value')->get();
        }

        return view('free', compact('paragraphs', 'sliderImages'));
    }

    public function getregions(Request $request)
    {

        $data['regions'] = Area::select('region_en')->where("city", $request->city_id)->get();
        return response()->json($data);
    }


    public function insider()
    {
        return view('insider');
    }
    public function blog()
    {
        return view('blog');
    }
    public function start_business()
    {
        return view('start_business');
    }
    public function common_questions()
    {
        return view('common_questions');
    }
    public function fast_facts()
    {
        return view('fast_facts');
    }
public function testimonials()
    {
        return view('testimonials');
    }

    public function category()
    {
        App::setLocale(Session::get('locale'));
        if (session()->get('locale') == 'ar') {
            $titles       = Paragraph::where('page_number', 6)->where('name', 'title')->select('id', 'value_ar as value')->get();
            $descriptions = Paragraph::where('page_number', 6)->where('name', 'description')->select('id', 'value_ar as value')->get();
        }
        else {
            $titles       = Paragraph::where('page_number', 6)->where('name', 'title')->select('id', 'value_en as value')->get();
            $descriptions = Paragraph::where('page_number', 6)->where('name', 'description')->select('id', 'value_en as value')->get();
        }
        return view('category', compact('titles', 'descriptions'));
    }


}
