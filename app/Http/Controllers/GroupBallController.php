<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupBallRequest;
use App\Http\Requests\GroupRequest;
use App\Models\GroupBall;
use App\Models\User;
use App\Services\GroupService;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class GroupBallController extends Controller
{
    public function __construct(
        public GroupBall $modal
    ) {}


    public function index()
    {
//        dd(111);
        return view('groupBall.index');
    }


    public function get()
    {
        $groups = $this->modal->get()->toArray();

        return DataTables::of($groups)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('text', function ($group) {
                return nl2br($group['text']);
            })
            ->addColumn('action', function ($group) {
                return '<div class="d-flex justify-content-end">
                            <a class="js_edit_btn mr-3 btn btn-outline-primary btn-sm"
                                data-update_url="'.route('groupBall.update', $group['id']).'"
                                data-one_url="'.route('groupBall.getOne', $group['id']).'"
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

    public function getOne(int $id): object
    {
        try {
            return response()->success($this->modal->findOrFail($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function update(GroupBallRequest $request, int $id): JsonResponse
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

}
