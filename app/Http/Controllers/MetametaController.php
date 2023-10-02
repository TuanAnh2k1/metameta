<?php

namespace App\Http\Controllers;

use App\Core\Common\CoreConst;
use App\Core\Helper\CommonHelper;
use App\Core\Helper\DateHelper;
use App\Core\Helper\LogHelper;
use App\Core\Helper\MetametaElementHelper;
use App\Http\Requests\Metameta\AddMetametaCommentRequest;
use App\Http\Requests\Metameta\ConfirmDeleteRequest;
use App\Http\Requests\Metameta\StoreMetametaRequest;
use App\Http\Requests\Metameta\UpdateSettingRequest;
use App\Http\Requests\Metameta\UploadFileRequest;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\StoreDataApplicationRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Attachment;
use App\Models\Author;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\DataApplication;
use App\Models\Memo;
use App\Models\MetadataElement;
use App\Models\Metameta;
use App\Models\MetametaSetting;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MetametaController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $settings = $this->getMetaListSetting();
        $page_size = intval($request->input('page_size', 10));
        $sql = Metameta::whereNull('metameta.deleted_at');
        $metameta = $sql->sortable(['created_at' => 'desc'])->paginate($page_size);
        $authUser = CommonHelper::isActionAllowMeta(Auth::user());
        $editColumnStyle = "width: " . CoreConst::DEFAULT_METAMETA_EDIT_WIDTH . "px !important;";
        $editColumnClass = "fixed-side";
        return view('pages.metameta.index', compact(
            'metameta',
            'page_size',
            'settings',
            'authUser',
            'editColumnStyle',
            'editColumnClass',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|Factory|Application
     */
    public function create(Request $request)
    {
        $severity = CoreConst::METAMETA_VALUE['severity'];
        return view('pages.metameta.add', compact('severity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse|JsonResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            if (empty($data)) {
                return redirect()->back();
            }

            Metameta::create($data);
            DB::commit();
            return redirect()->route('metameta.index')->with('status_success', __('app.save_successfully'));
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when add new metameta', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * Show edit screen
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(int $id)
    {
        $metameta = Metameta::find($id);
        if (!$metameta) {
            return redirect()->route('metameta.index');
        }
        $contacts = Contact::whereNull('contacts.deleted_at')->where('metadata_no', $id)->get();
        $authors = Author::whereNull('authors.deleted_at')->where('metadata_no', $id)->get();
        $data_applications = DataApplication::whereNull('data_applications.deleted_at')->where('metadata_no', $id)->get();
        $disabled = !CommonHelper::isActionAllowMeta(Auth::user());
        $comments = Comment::whereNull('deleted_at')->where('metadata_no', $id)->get()->toArray();
        $list_comment = [];
        foreach ($comments as $commentItem) {
            MetametaElementHelper::transformComment($commentItem);
            $list_comment[] = $commentItem;
        }
        $metadata_elements = MetadataElement::where('column_name', 'LIKE', 'metameta.%')->get();
        $list_memo = [];
        foreach (Metameta::METAMETA_ELEMENTS as $element) {
            for ($i = 0; $i < count($metadata_elements); $i++) {
                $columnName = $metadata_elements[$i]->column_name;
                if ($columnName === 'metameta.' . $element) {
                    $elementId = $metadata_elements[$i]->id;
                    $memos = Memo::where('metadata_no', $id)->where('metameta_element_id', $elementId)->get()->toArray();
                    $transformerMemos = [];
                    foreach ($memos as $memoElement) {
                        MetametaElementHelper::transformMemo($memoElement);
                        $transformerMemos[] = $memoElement;
                    }
                    $list_memo[$element] = [
                        'metameta_element_id' => $elementId,
                        'memos' => $transformerMemos,
                    ];
                    break;
                }
            }
        }
        $metadata_elements = MetametaElementHelper::transformMetadataElements();
        $files = Attachment::where('metadata_no', $id)->get();
        $respondFiles = [];
        foreach ($files as $file) {
            $respondFile['id'] = $file->id;
            $respondFile['original_name'] = $file->original_name;
            $respondFile['note'] = $file->note;
            $respondFile['created'] = DateHelper::format($file->created_at, 'Y-m-d H:i:s');
            $respondFile['url'] = $this->urlEncode($file->id);

            if (!empty($file->created_by_user))
                $respondFile['author'] = $file->created_by_user->display_name;
            else
                $respondFile['author'] = null;

            $respondFile['type'] = pathinfo($file->url, PATHINFO_EXTENSION);
            $respondFiles[] = $respondFile;
        }
        $has_comment = MetametaElementHelper::hasComment($metadata_elements, $list_comment);
        return view('pages.metameta.edit', compact(
            'metameta',
            'contacts',
            'authors',
            'data_applications',
            'disabled',
            'list_memo',
            'list_comment',
            'metadata_elements',
            'respondFiles',
            'has_comment',
        ));
    }

    /**
     * @param StoreMetametaRequest $request
     * @param int $id
     * @return JsonResponse|RedirectResponse
     */
    public function update(StoreMetametaRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            $metameta = Metameta::find($id);
            if (!CommonHelper::isActionAllowMeta(Auth::user())) {
                return redirect()->back();
            }
            $data = $request->all();
            $this->authorize('update', $metameta);
            if (empty($metameta) || empty($data['metameta'])) {
                return redirect()->back();
            }

            $metameta->update($data['metameta']);
            DB::commit();
            return redirect()->route('metameta.index')->with('status_success', __('app.edit_successfully'));
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when edit metameta', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function delete(ConfirmDeleteRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            if (empty($id) || empty($metameta = Metameta::find($id))) {
                return CommonHelper::AbortError(ResponseAlias::HTTP_NOT_FOUND, __('app.item_not_found'));
            }

            $data = $request->validated();
            if ($data['delete-confirm'] != CoreConst::PREFIX_DELETE_CONFIRM_MESSAGE . $id) {
                return CommonHelper::AbortError(ResponseAlias::HTTP_BAD_REQUEST, __('metameta.confirm_message_not_match'));
            }
            $this->authorize('delete', $metameta);

            $comments = Comment::whereNull('comments.deleted_at')->where('metadata_no', '=', $metameta->id)->get();
            foreach ($comments as $comment) {
                $comment->delete();
            }
            $metameta->delete();
            Session::flash('status_success', __('app.delete_successfully'));
            DB::commit();
            return CommonHelper::ResponseSuccess();
        } catch (Exception $e) {
            DB::rollBack();
            LogHelper::Log('Error when delete metameta', $e);
            return CommonHelper::AbortError(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param StoreContactRequest $request
     * @return JsonResponse
     */
    public function addContact(StoreContactRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            if (empty($data)) {
                return response()->json(['status_errors' => __('app.save_errors')]);
            }
            $id = Contact::create($data)->id;
            DB::commit();
            return response()->json(['contact_id' => $id, 'status_success' => __('app.save_successfully')]);
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when add new contact', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param StoreContactRequest $request
     * @return JsonResponse
     */
    public function editContact(StoreContactRequest $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->get('id');
            if (empty($id)) {
                return response()->json(['status_errors' => __('app.edit_errors')]);
            }

            $contact = Contact::find($id);
            if (empty($contact)) {
                return response()->json(['status_errors' => __('app.edit_errors')]);
            }
            $data = $request->all();
            $contact->update($data);
            DB::commit();
            return response()->json(['status_success' => __('app.edit_successfully')]);

        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when update contact', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroyContact(Request $request)
    {
        DB::beginTransaction();
        try {

            $id = $request->get('id');
            if (empty($id)) {
                return response()->json(['status_errors' => __('app.delete_errors')]);
            }
            $contact = Contact::find($id);
            if (empty($contact)) {
                return response()->json(['status_errors' => __('app.delete_errors')]);
            }

            $contact->delete();
            DB::commit();
            return response()->json(['id' => $id, 'status_success' => __('app.delete_successfully')]);

        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when delete contact');
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param StoreAuthorRequest $request
     * @return JsonResponse
     */
    public function addAuthor(StoreAuthorRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            if (empty($data)) {
                return response()->json(['status_errors' => __('app.save_errors')]);
            }
            $id = Author::create($data)->id;
            DB::commit();
            return response()->json(['author_id' => $id, 'status_success' => __('app.save_successfully')]);
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when add author', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param StoreAuthorRequest $request
     * @return JsonResponse
     */
    public function editAuthor(StoreAuthorRequest $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->get('id');
            if (empty($id)) {
                return response()->json(['status_errors' => __('app.delete_errors')]);
            }

            $author = Author::find($id);
            if (empty($author)) {
                return response()->json(['status_errors' => __('app.delete_errors')]);
            }

            $data = $request->all();
            $author->update($data);
            DB::commit();
            return response()->json(['status_success' => __('app.edit_successfully')]);

        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when update author', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroyAuthor(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->get('id');
            if (empty($id)) {
                return response()->json(['status_errors' => __('app.delete_errors')]);
            }

            $author = Author::find($id);
            if (empty($author)) {
                return response()->json(['status_errors' => __('app.delete_errors')]);
            }
            $author->delete();
            DB::commit();
            return response()->json(['id' => $id, 'status_success' => __('app.delete_successfully')]);

        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when delete author', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param StoreDataApplicationRequest $request
     * @return JsonResponse
     */
    public function addDataApplication(StoreDataApplicationRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $id = DataApplication::create($data)->id;
            DB::commit();
            return response()->json([
                'data_application_id' => $id,
                'status_success' => __('app.save_successfully')
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when add metameta data application', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editDataApplication(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->get('id');
            if (empty($id)) {
                return response()->json(['status_errors' => __('app.edit_errors')]);
            }

            $data_application = DataApplication::find($id);
            if (empty($data_application)) {
                return response()->json(['status_errors' => __('app.edit_errors')]);
            }
            $data = $request->all();
            if (empty($data['name_ja']) && empty($data['name_en']) && empty($data['url'])) {
                return response()->json(['status_errors' => __('metameta.least_one_field')]);
            }
            $data_application->update($data);
            DB::commit();
            return response()->json(['status_success' => __('app.edit_successfully')]);

        } catch (Exception $e) {
            // Tuong tu
            DB::rollback();
            LogHelper::Log('Error when update data application', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroyDataApplication(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->get('id');
            if (empty($id)) {
                return response()->json(['status_errors' => __('app.edit_errors')]);
            }
            $data_application = DataApplication::find($id);

            if (empty($data_application)) {
                return response()->json(['status' => (bool)$data_application, 'status_errors' => __('app.delete_errors')]);
            }
            $data_application->delete();
            DB::commit();
            return response()->json(['id' => $id, 'status_success' => __('app.delete_successfully')]);

        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when delete data application', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function upload(UploadFileRequest $request, $id = null)
    {
        if (empty($id)) {
            return CommonHelper::AbortError(ResponseAlias::HTTP_NOT_FOUND, trans('item_not_found'));
        }

        DB::beginTransaction();
        try {
            $data = $request->validated();
            $file = $data['files'];

            $uploadData['note'] = $data['note'];
            $uploadData['name'] = md5(uniqid(rand(), 1)) . $file->getClientOriginalName();
            $uploadData['user_id'] = Auth::id();
            $uploadData['metadata_no'] = $id;
            $uploadData['original_name'] = $file->getClientOriginalName();
            $filePath = Storage::disk(CoreConst::METAMETA_STORAGE_DISK)->putFileAs(CoreConst::METAMETA_FILE_FOLDER, $file, $uploadData['name']);

            $uploadData['url'] = $filePath;
            $uploadData['type'] = $file->getClientMimeType();
            $uploadData['size'] = $file->getSize();

            $upload = Attachment::create($uploadData);
            $upload['type'] = pathinfo($upload->url, PATHINFO_EXTENSION);
            $upload['created'] = DateHelper::format($upload->created_at, 'Y-m-d H:i:s');
            $upload['author'] = Auth::user()->display_name;
            $upload['url'] = $this->urlEncode($upload->id);
            DB::commit();

            return response()->json($upload);
        } catch (Exception $e) {
            DB::rollBack();
            LogHelper::Log('Error when import file', $e);
            return CommonHelper::AbortError(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }

    }

    /**
     * @param int $id
     * @return string
     */
    private function urlEncode(int $id): string
    {
        $token = User::find(Auth::id())->createToken('previewFile')->plainTextToken;
        $previewRoute = route('preview_file', ['id' => $id]);
        return CommonHelper::url_encode($previewRoute . '?' . CoreConst::PARAM_TOKEN . '=' . $token);
    }

    public function previewFile($id = null)
    {
        if (empty($id) || empty($file = Attachment::find($id))) {
            return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, 'metameta.not_found.file');
        }
        if (!Storage::disk(CoreConst::METAMETA_STORAGE_DISK)->has($file->url)) {
            LogHelper::Log('File not found in storage path ' . $file->url . '.');
            return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, 'metameta.not_found.file');
        }
        $url = $file->url;
        $name = $file->original_name;
        $header = [
            'Content-Type' => Storage::mimeType($url),
        ];
        return Storage::disk(CoreConst::METAMETA_STORAGE_DISK)->download($file->url, $name, $header);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteFile($id = null)
    {
        if (empty($id) || empty($file = Attachment::find($id))) {
            return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, trans('metameta.not_found.file'));
        }

        DB::beginTransaction();
        try {
            $is_admin = CommonHelper::isActionAllowMeta(Auth::user());
            if (!$is_admin) {
                return response()->json([
                    'msg' => trans('app.delete_errors'),
                ]);
            }
            Storage::delete($file->url);
            $file->delete();
            DB::commit();
            return response()->json([
                'msg' => trans('app.delete_successfully'),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            LogHelper::Log('Error when delete file', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param UpdateSettingRequest $request
     * @return JsonResponse
     */
    public function updateSettings(UpdateSettingRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            if (!array_key_exists('settings', $data)) {
                return CommonHelper::AbortError(ResponseAlias::HTTP_NOT_FOUND, 'Error msg');
            }
            $settings = [];
            foreach ($data['settings'] as $setting) {
                $columnSetting = [];
                $columnSetting['is_display'] = filter_var($setting['is_display'], FILTER_VALIDATE_BOOLEAN);
                $showableColumn = MetametaElementHelper::showableColumnNames();
                for ($i = 0; $i < count($showableColumn); $i++) {
                    if (trans('metameta.' . $showableColumn[$i]) == $setting['column_name']) {
                        $columnSetting['column_name'] = $showableColumn[$i];
                        break;
                    }
                }
                $width = $setting['width'];
                $columnSetting['width'] = empty($width) ? null : intval($width);
                $columnSetting['is_freeze'] = filter_var($setting['is_freeze'], FILTER_VALIDATE_BOOLEAN);
                $settings[] = $columnSetting;
            }

            $userId = Auth::id();
            $updateData['user_id'] = $userId;
            $updateData['settings'] = json_encode($settings);
            $updateData['created_by'] = $userId;

            if (empty($metametaSetting = MetametaSetting::where(['user_id' => $updateData['user_id']])->first())) {
                MetametaSetting::create($updateData);
                dump('created');
            } else {
                $metametaSetting->update($updateData);
                dump('updated');
            }

            DB::commit();
            Session::flash('status_success', __('app.save_successfully'));
            return CommonHelper::ResponseSuccess();
        } catch (Exception $e) {
            DB::rollBack();
            LogHelper::Log('Error when update metameta settings', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param $metametaId
     * @param $metaElementId
     * @return JsonResponse
     */
    public function listComment($metametaId = null, $metaElementId = 0)
    {
        if (empty($metametaId) || empty($metameta = Metameta::find($metametaId))) {
            return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, trans('metameta.validate.exists'));
        }
        $comments = $this->getCommentsByElementId($metametaId, $metaElementId);
        $list_comment = [];
        foreach ($comments as $commentItem) {
            MetametaElementHelper::transformComment($commentItem);
            $list_comment[] = $commentItem;
        }
        $modal_list = Blade::render('<x-metameta.comment.modal-list :comments="$list_comment"/>', compact('list_comment'));
        return response()->json([
            'comment' => $modal_list,
        ], Response::HTTP_OK);
    }

    /**
     * @param AddMetametaCommentRequest $request
     * @param $metametaId
     * @return JsonResponse|void
     */
    public function addComment(AddMetametaCommentRequest $request, $metametaId = null)
    {
        if (empty($metametaId) || empty($metameta = Metameta::find($metametaId))) {
            return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, 'metameta.validate.exists');
        }
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $data['metadata_no'] = $metametaId;
            $comment = Comment::create($data);
            DB::commit();
            $commentTransform = $comment->toArray();
            MetametaElementHelper::transformComment($commentTransform);
            $metadata_elements = MetametaElementHelper::transformMetadataElements();
            $modal_element = Blade::render('<x-metameta.comment.modal-element :comment="$commentTransform"/>', compact('commentTransform'));
            $element = Blade::render('<x-metameta.comment.element :comment="$commentTransform" 
                :options="$metadata_elements" :disabled="true"/>', compact('commentTransform', 'metadata_elements'));
            return response()->json([
                'element_id' => $comment->metameta_element_id,
                'modal_element' => $modal_element,
                'element' => $element,
                'status_success' => __('app.save_successfully')]);
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when add comment', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    public function editComment(AddMetametaCommentRequest $request, $metametaId, $id)
    {
        if (empty($metametaId) || empty($metameta = Metameta::find($metametaId))) {
            return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, 'metameta.validate.exists');
        }
        DB::beginTransaction();
        try {
            if (empty($id) || empty($comment = Comment::find($id))) {
                return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, 'metameta.not_found.comment');
            }
            $this->authorize('update', $comment);
            $data = $request->validated();
            $oldElementId = $comment->metameta_element_id;
            $metametaNo = $comment->metadata_no;
            $comment->update($data);
            $oldElementRemain = $this->getCommentCountByElementId($metametaNo, $oldElementId);
            DB::commit();
            return response()->json([
                'old_element_id' => $oldElementId,
                'old_element_remain' => $oldElementRemain,
                'new_element_id' => intval($comment->metameta_element_id),
                'status_success' => __('app.edit_successfully')]
            );
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when update comment', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param $metametaId
     * @param $id
     * @return JsonResponse
     */
    public function deleteComment($metametaId, $id): JsonResponse
    {
        if (empty($metametaId) || empty($metameta = Metameta::find($metametaId))) {
            return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, 'metameta.validate.exists');
        }
        DB::beginTransaction();
        try {
            if (empty($id) || empty($comment = Comment::find($id))) {
                return CommonHelper::AbortError(Response::HTTP_NOT_FOUND, 'metameta.not_found.comment');
            }
            $this->authorize('delete', $comment);
            $elementId = $comment->metameta_element_id;
            $comment->delete();
            $commentRemain = $this->getCommentCountByElementId($comment->metadata_no, $elementId);
            DB::commit();
            return response()->json([
                'id_comment' => $id,
                'comment_remain' => $commentRemain,
                'element_id' => $elementId,
                'status_success' => __('app.delete_successfully'),
            ]);
        } catch (Exception $e) {
            DB::rollback();
            LogHelper::Log('Error when update comment', $e);
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param $metametaId
     * @param $id
     * @return array
     */
    private function getCommentsByElementId($metametaId, $id): array
    {
        if ($id == 0) {
            return Comment::whereNull('deleted_at')->where('metadata_no', $metametaId)->get()->toArray();
        }
        return Comment::whereNull('deleted_at')->where('metadata_no', $metametaId)->where('metameta_element_id', $id)->get()->toArray();
    }

    /**
     * @param $metametaId
     * @param $id
     * @return int
     */
    private function getCommentCountByElementId($metametaId, $id): int
    {
        return Comment::whereNull('deleted_at')->where('metadata_no', $metametaId)->where('metameta_element_id', $id)->count();
    }

    /**
     * @return array
     */
    private function getMetaListSetting(): array
    {
        $newSettings = [];
        $totalWidthFreeze = CoreConst::DEFAULT_METAMETA_EDIT_WIDTH;
        try {
            $showableColumn = MetametaElementHelper::showableColumnNames();
            $userSetting = MetametaSetting::where('user_id', Auth::id())->first();
            if (!empty($userSetting) && !empty(json_decode($userSetting->settings, true))) {
                $settings = json_decode($userSetting->settings, true);
            }

            if (empty($settings)) {
                $settings = CoreConst::METAMETA_DEFAULT_SETTING;
                foreach ($showableColumn as $columnName) {
                    $newSettingItem = CoreConst::METAMETA_DEFAULT_ITEM_SETTING;
                    $newSettingItem['column_name'] = $columnName;
                    for ($i = 0; $i < count($settings); $i++) {
                        if ($columnName === $settings[$i]['column_name']) {
                            $newSettingItem = $settings[$i];
                            break;
                        }
                    }
                    $newSettings[] = $newSettingItem;
                }
                $settings = $newSettings;
                $newSettings = [];
            }
            foreach ($settings as $settingItem) {
                $this->additionSetting($settingItem, $totalWidthFreeze);
                $newSettings[] = $settingItem;
                if (in_array($settingItem['column_name'], $showableColumn)) {
                    $index = array_search($settingItem['column_name'], $showableColumn);
                    unset($showableColumn[$index]);
                }
            }
            foreach ($showableColumn as $columnName) {
                $newSettingItem = CoreConst::METAMETA_DEFAULT_ITEM_SETTING;
                $newSettingItem['column_name'] = $columnName;
                $this->additionSetting($newSettingItem, $totalWidthFreeze);
                $newSettings[] = $newSettingItem;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return $newSettings;
    }

    /**
     * @param array $currentSetting
     * @param int $totalWidthFreeze
     * @return void
     */
    private function additionSetting(array &$currentSetting, int &$totalWidthFreeze)
    {
        $currentSetting['sortable'] = in_array($currentSetting['column_name'], CoreConst::METAMETA_SORTABLE_COLUMN);
        $width = empty($currentSetting['width']) ? CoreConst::DEFAULT_METAMETA_MIN_WIDTH : $currentSetting['width'];
        $currentSetting['style'] = 'width:' . $width . 'px !important;';
        $currentSetting['th-class'] = "";
        $currentSetting['td-class'] = "";
        if ($currentSetting['is_freeze'] && $currentSetting['is_display']) {
            $currentSetting['th-class'] = 'fixed-side';
            $currentSetting['td-class'] .= $currentSetting['th-class'];
            $currentSetting['style'] .= ' left:' . $totalWidthFreeze . 'px;';
            $totalWidthFreeze += $width;
        }
        $currentSetting['column_name_trans'] = trans(CoreConst::PREFIX_METADATA_COLUMN_NAME . $currentSetting['column_name']);
    }
}
