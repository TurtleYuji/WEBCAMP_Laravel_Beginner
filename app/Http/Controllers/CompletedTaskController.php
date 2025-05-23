<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use App\Models\CompletedTask;
use Illuminate\Support\Facades\Auth;

class CompletedTaskController extends Controller
{
    
    protected function getListBuilder()
    {
        return CompletedTask::where('user_id', Auth::id())
                     ->orderBy('priority', 'DESC')
                     ->orderBy('period')
                     ->orderBy('created_at');
    }  

    public function list()
    {
       // 1Page辺りの表示アイテム数を設定
       $per_page = 2;
        
       // 一覧の取得
       $list = $this->getListBuilder()
                    ->paginate($per_page);
                       // ->get();
       /*
       $sql =  $this->getListBuilder()
           ->toSql();
       //echo "<pre>\n"; var_dump($sql, $list); exit;
       var_dump($sql);
       */
       
       return view('task.completed_list', ['list' => $list]);
    }
}