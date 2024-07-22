<?php

namespace App\Http\Controllers;

use App\Http\Requests\ElonRequest;
use App\Http\Requests\GroupBallRequest;
use App\Models\Elon;
use App\Models\Group;
use App\Models\GroupBall;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class GroupBallController extends Controller
{
    public function __construct(
        public GroupBall $modal
    ) {}


    public function index()
    {
        $groups = Group::whereNull('deleted_at')->where('status', 1)->get();

        return view('groupBall.index', compact('groups'));
    }


    public function getBall()
    {
        $groups = $this->modal->get();

        return DataTables::of($groups)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('text', function ($group) {
                return nl2br($group->text);
            })
            ->addColumn('action', function ($group) {
                return '<div class="d-flex justify-content-end">
                            <a class="js_edit_btn mr-3 btn btn-outline-primary btn-sm"
                                data-update_url="'.route('groupBall.update', $group->id).'"
                                data-one_url="'.route('groupBall.getOne', $group->id).'"
                                href="javascript:void(0);" title="Edit">
                                <i class="fas fa-pen"></i> Taxrirlash
                            </a>
                        </div>';
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['text', 'action'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function getOneBall(int $id): object
    {
        try {
            return response()->success($this->modal->findOrFail($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function updateBall(GroupBallRequest $request, int $id): JsonResponse
    {
        try {
            $this->modal->where('id', $id)
            ->update([
                'text'=> $request->validated('text')
            ]);
            return response()->success($id);
        }
        catch(\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }



    public function getElon()
    {
        $elon = Elon::orderBy('id', 'DESC')->get();

        return DataTables::of($elon)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('group', function($elon) {
                Log::info(json_encode($elon->groupIds));
                $group = Group::whereIn('id', $elon->groupIds)->get();
                $groupName = '';
                foreach($group as $g) {
                    $groupName .= $g->name.', ';
                }
                return $groupName;
            })
            ->editColumn('message', function ($elon) {
                return nl2br($elon->message);
            })
            ->editColumn('created_at' ,function($elon) {
                return date('d.m.Y H:i', strtotime($elon->created_at));
            })
            ->addColumn('action', function ($elon) {
                return '<div class="d-flex justify-content-end">
                            <a class="js_edit_btn mr-3 btn btn-outline-danger btn-sm"
                                data-one_url="'.route('groupBall.getOne', $elon->id).'"
                                href="javascript:void(0);" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>';
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['message', 'action'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function storeElon(ElonRequest $request): JsonResponse
    {
        try {
            Elon::create([
                'groupIds' => $request->validated('group_id'),
                'message' => $request->validated('message'),
                'status' => 1
            ]);
            return response()->success('ok');
        }
        catch(\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

}
