<?php

namespace App\Http\Controllers;

use App\Core\Helper\CommonHelper;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request): View|Factory|Application
    {
        $authUser = Auth::user();
        $sql = User::whereNull('users.deleted_at');
        $page_size = number_format($request->input('page_size', 10));
        $search = $request->input('search', '');
        if (!empty($search)) {
            $sql = $sql->where(function ($sql) use ($search) {
                $sql->where('display_name', 'like', "%$search%")
                    ->orWhere('username', 'like', "%$search%");
            });
        }

        $users = $sql->sortable(['created_at' => 'desc'])->paginate($page_size);

        return view('pages.user.index', compact('users', 'authUser', 'search', 'page_size'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|Factory|Application
     */
    public function create(): View|Factory|Application
    {
        $roles = Role::all();
        return view('pages.user.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            if (empty($data)) {
                return redirect()->back();
            }
            User::create($data);
            DB::commit();
            return redirect()->route('users.index')->with('status_success', __('app.save_successfully'));
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(int $id): Application|Factory|View|RedirectResponse
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index');
        }
        $roles = Role::all();
        return view('pages.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $this->authorize('update', $user);
            if (empty($user)) {
                return redirect()->back();
            }
            $data = $request->validated();
            $user->update($data);
            DB::commit();
            return redirect()->route('users.index')->with('status_success', __('app.edit_successfully'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error(
                'Error when delete file',
                [
                    'line' => __LINE__,
                    'method' => __METHOD__,
                    'error_message' => $e->getMessage(),
                ]
            );
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $this->authorize('delete', $user);

            if (empty($user)) {
                return redirect()->back();
            }
            $user->delete();
            DB::commit();
            return redirect()->route('users.index')->with('status_success', __('app.delete_successfully'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error(
                'Error when delete file',
                [
                    'line' => __LINE__,
                    'method' => __METHOD__,
                    'error_message' => $e->getMessage(),
                ]
            );
            return CommonHelper::AbortError(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }
}
