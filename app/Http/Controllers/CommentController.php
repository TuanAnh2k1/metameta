<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\AddCommentRequest;
use App\Models\Comment;
use App\Models\MetadataElement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $users = User::all();
        $authUser = Auth::user();
        $search = $request->input('search', '');
        $page_size = intval($request->input('page_size', 10));
        $created_by = $request->input('created_by', '');
        $sql = Comment::whereNull('comments.deleted_at');
        if (!empty($created_by)) {
            $sql->where('created_by', $created_by);
        }
        if (!empty($search)) {
            $sql->where(function ($sql) use ($search) {
                $sql->where('comment', 'like', "%$search%")
                    ->orWhere('metadata_no', 'like', "%$search%")
                    ->orWhere('metameta_element_id', 'like', "%$search%");
            });
        }
        $comment = $sql->sortable(['created_at' => 'desc'])->paginate($page_size);
        return view('pages.comment.index',
            [
                'comment' => $comment,
                'users' => $users,
                'authUser' => $authUser,
                'page_size' => $page_size,
                'search' => $search,
                'created_by' => $created_by,
            ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function create(Request $request)
    {
        $metadata_elements = MetadataElement::where('column_name','LIKE','metameta.%')->get();
        return view('pages.comment.add', compact('metadata_elements'));
    }

    /**
     * @param AddCommentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddCommentRequest $request)
    {
        $data = $request->all();
        $data['comment_date'] = Carbon::now()->format('Y-m-d');
        $data['user_id'] = Auth::user()->id;
        Comment::create($data);
        return redirect()->route('comments.index')->with('status_success', __('app.save_successfully'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\Http\RedirectResponse
     */
    public function edit(int $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return redirect()->route('comments.index');
        }
        $metadata_elements = MetadataElement::where('column_name','LIKE','metameta.%')->get();
        return view('pages.comment.edit', compact('comment', 'metadata_elements'));
    }

    /**
     * @param AddCommentRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(AddCommentRequest $request, int $id)
    {
        $comment = Comment::find($id);
        $this->authorize('update', $comment);
        if ($comment) {
            $data = $request->validated();
            $comment->update($data);
        }
        return redirect()->route('comments.index')->with('status_success', __('app.edit_successfully'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(int $id)
    {
        $comment = Comment::find($id);
        $this->authorize('delete', $comment);
        if ($comment) {
            $comment->delete();
        }
        return redirect()->route('comments.index')->with('status_success', __('app.delete_successfully'));
    }
}
