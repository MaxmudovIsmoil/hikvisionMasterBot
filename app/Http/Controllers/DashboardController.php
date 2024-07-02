<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Opcodes\LogViewer\Logs\Log;
use PhpParser\Node\Expr\FuncCall;

class DashboardController extends Controller
{
    public function index(): View
    {
        $groupCount = Group::where('status', 1)->count();
        $userCount = User::where(['status' => 1, 'role' => 2])->count();


        return view('dashboard',
            compact('groupCount', 'userCount')
        );
    }


    public function getGroup()
    {
        try {
            $group = Group::select('id', 'name')
                ->withCount('user')
                ->get()
                ->toArray();

            return response()->success($group);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

}
