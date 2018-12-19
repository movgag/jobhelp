<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class PortfoliosEmployee extends Model
{
    protected $table = 'portfolios_of_employee';

    public static function get_portfoliosByEmployeeID($employee_id,$per_page = 2){
        return self::query()->where('employee_id',$employee_id)->paginate($per_page);
    }

    public static function get_portfolioByID($id){
        return self::query()->find($id);
    }

    public static function add_portfolio($request)
    {
        $portfolio = new self();
        $portfolio->employee_id = auth()->guard('employee')->user()->id;
        $portfolio->title = $request->input('title');
        $portfolio->description = $request->input('description');

        if($request->hasFile('image')){
            $file_name = "";
            $generated_string = time();
            $extension = $request->file('image')->getClientOriginalExtension();
            $file_name = $generated_string.".".$extension;

            //$new_file = "images/emp-portfolios/".$file_name;

            $request->file('image')->move(public_path('images/emp-portfolios'), $file_name);

            //File::move($request->file('image'),$new_file);

            $portfolio->image = $file_name;
        }
        $portfolio->save();

        if($portfolio && isset($portfolio->id)){
            return true;
        } else {
            return false;
        }
    }

    public static function edit_portfolio($portfolio,$request){
        $portfolio->title = $request->input('title');
        $portfolio->description = $request->input('description');

        if($request->hasFile('image')){

            if($request->input('old_image') != '' && $request->input('old_image') == $portfolio->image ){
                File::delete('images/emp-portfolios/'.$request->input('old_image'));
            }
            $file_name = "";
            $generated_string = time();
            $extension = $request->file('image')->getClientOriginalExtension();
            $file_name = $generated_string.".".$extension;

            //$new_file = "images/emp-portfolios/".$file_name;

            $request->file('image')->move(public_path('images/emp-portfolios'), $file_name);

            //File::move($request->file('image'),$new_file);

            $portfolio->image = $file_name;
        }
        $portfolio->update();
        if($portfolio && isset($portfolio->id)){
            return true;
        } else {
            return false;
        }
    }

    public static function delete_portfolio($portfolio){

        $res = $portfolio->delete();

        if($res && isset($res->id)){
            return true;
        } else {
            return false;
        }
    }

    public static function get_portfolio($portfolio_id,$employee_id){
        return self::query()->where('employee_id',$employee_id)
            ->where('id',$portfolio_id)
            ->first();
    }

    public static function get_random_portfolios($limit = 3){
        return self::query()->inRandomOrder()->limit($limit)->get();
    }


// relations -------------------------------------start
    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id','id');
    }

}
