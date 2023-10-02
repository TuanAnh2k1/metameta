<?php

namespace App\Http\Controllers;

use App\Core\Helper\CommonHelper;
use App\Core\Helper\LogHelper;
use App\Core\Helper\MetametaElementHelper;
use App\Http\Requests\Metameta\AddMemoRequest;
use App\Models\Memo;
use App\Models\MetadataElement;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemoController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function listMemo(Request $request)
    {
        $metameta_elements = $request->get('field');
        $metameta_data = MetadataElement::where('column_name', $metameta_elements)->first();
        if (!$metameta_data) {
            return response()->json(['list_memo' => []]);
        }
        $metameta_element_id = $metameta_data->id;
        $memo_list = Memo::whereNull('memos.deleted_at')->with('creator');

        $metadata_no = $request->get('metadata_no');
        $memo_list = $memo_list->where('metadata_no', $metadata_no)->where('metameta_element_id', $metameta_element_id)->get();
        if (empty($memo_list)) {
            return response()->json(['list_memo' => []]);
        }
        foreach ($memo_list as $memo) {
            $memo->can_edit = CommonHelper::isActionAllow(Auth::user(), $memo->user_id);
        }
        return response()->json(['list_memo' => $memo_list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function addMemo(AddMemoRequest $request, $metametaId)
    {
        DB::beginTransaction();
        try {
            $disabled = !CommonHelper::isActionAllowMeta(Auth::user());
            if ($disabled) {
                return CommonHelper::AbortError(Response::HTTP_FORBIDDEN, trans('metameta.access_denied'));
            }
            $data = $request->validated();
            if(!array_key_exists('metameta_element_id', $data) || empty(MetadataElement::find($data['metameta_element_id']))) {
                return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, trans('metameta.not_found.element_id'));
            }

            $data['user_id'] = Auth::id();
            $data['metadata_no'] = $metametaId;
            $memo = Memo::create($data)->toArray();
            DB::commit();
            MetametaElementHelper::transformMemo($memo);
            $html = Blade::render('<x-metameta.memo-element :memo="$memo" :disabled="$disabled" />', compact('memo', 'disabled'));
            return response()->json([
                'metadata_element_id' => $data['metameta_element_id'],
                'memo' => $html,
                'status_success' => __('app.save_successfully'),
            ],Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when add memo', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param AddMemoRequest $request
     * @param $id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function editMemo(AddMemoRequest $request, $id = null)
    {
        if (!CommonHelper::isActionAllowMeta(Auth::user())) {
            return CommonHelper::AbortError(Response::HTTP_FORBIDDEN, trans('metameta.access_denied'));
        }
        DB::beginTransaction();
        try {
            if(empty($id) || empty($memo = Memo::find($id))) {
                return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, trans('metameta.not_found.memo'));
            }
            $data = $request->validated();
            $this->authorize('update', $memo);
            $memo->update($data);
            DB::commit();

            return CommonHelper::ResponseSuccess(__('app.edit_successfully'));
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when update memo', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroyMemo($id = null)
    {
        if (!CommonHelper::isActionAllowMeta(Auth::user())) {
            return CommonHelper::AbortError(Response::HTTP_FORBIDDEN, trans('metameta.access_denied'));
        }

        DB::beginTransaction();
        try {
            if(empty($id) || empty($memo = Memo::find($id))) {
                return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, trans('metameta.not_found.memo'));
            }
            $this->authorize('delete', $memo);
            $memo->delete();
            DB::commit();

            return CommonHelper::ResponseSuccess(__('app.delete_successfully'));
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when delete memo', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
