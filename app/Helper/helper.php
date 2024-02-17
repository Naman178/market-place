<?php
namespace App\helper;

use Illuminate\Http\Request;
use App\Models\ContactsCountryEnum;
class helper
{

    public static function dateFormatForView($date)
    {
        return \Carbon\Carbon::parse($date)->format('d-m-Y');
    }
    public static function ContactCountryAll()
    {
        return ContactsCountryEnum::all();
    }
    public static function sysDelete($model,$id)
    {
        $model->where('id',$id)->update(['sys_state' => '-1']);
    }
}

?>
