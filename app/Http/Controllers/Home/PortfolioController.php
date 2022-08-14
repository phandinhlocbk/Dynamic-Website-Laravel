<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\HomeSlide;
use App\Models\Portfolio;

use PDO;
use Image;

class PortfolioController extends Controller
{
    //
    public function AllPortfolio() {
        $portfolio = Portfolio::latest()->get();
        return view('admin.portfolio.portfolio_all', compact('portfolio'));

    }// end method


    public function AddPortfolio() {
        return view('admin.portfolio.portfolio_add');
    }//end method

    public function StorePortfolio(Request $request) {
        $request->validate([
            'portfolio_name' => 'required',
            'portfolio_title' => 'required',
            'portfolio_image' => 'required',
            
        ], [
            'portfolio_name.required' => 'Portfolio Name is required',
            'portfolio_title.required' => 'Portfolio Title is required',
             
        ]);

      
            $image = $request->file('portfolio_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  // 3434343443.jpg

            Image::make($image)->resize(1020,519)->save('upload/portfolio/'.$name_gen);
            $save_url = 'upload/portfolio/'.$name_gen;

            Portfolio::insert([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image' => $save_url,
                'created_at' => carbon::now(),

            ]); 
            $notification = array(
            'message' => 'Portfolio inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);

    }//end method

    public function EditPortfolio($id){

        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolio.portfolio_edit',compact('portfolio'));
    }// End Method

    public function UpdatePortfolio(Request $request){

        $portfolio_id = $request->id;

        if ($request->file('portfolio_image')) {
            $image = $request->file('portfolio_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  // 3434343443.jpg

            Image::make($image)->resize(1020,519)->save('upload/portfolio/'.$name_gen);
            $save_url = 'upload/portfolio/'.$name_gen;

            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image' => $save_url,
              

            ]); 
            $notification = array(
            'message' => 'Portfolio Updated with Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);

        } else{

            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description, 

            ]); 
            $notification = array(
            'message' => 'Portfolio Updated without Image Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);

        } // end Else

     } // End Method 

     public function DeletePortfolio($id) {
        $multi = Portfolio::findOrFail($id);
        $img = $multi->portfolio_image;
        unlink($img);

        Portfolio::findOrFail($id)->delete();

        $notification = array(
           'message' => 'Portfolio Deleted Successfully', 
           'alert-type' => 'success'
        );
        return redirect()->route('all.portfolio')->with($notification);
    }//end method

    public function PortfolioDetails($id) {
        $portfolio = Portfolio::findOrFail($id);
        return view('frontend.portfolio_details',compact('portfolio'));

    }//end method    
}
