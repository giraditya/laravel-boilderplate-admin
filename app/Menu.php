<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'title', 'url', 'order_no', 'active'
    ];

    public static function getMenuTree()
    {
        $headers = DB::table('menu')
            ->select('id', 'title')
            ->where('active', 1)
            ->where('parent_id', null)
            ->get();

        foreach ($headers as &$header) {
            $childs = DB::table('menu')
                ->where('active', 1)
                ->where('parent_id', $header->id)
                ->orderBy('order_no', 'asc')
                ->get();

            $header->childs = $childs;
        }

        return $headers;
    }
}