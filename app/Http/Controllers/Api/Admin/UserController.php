<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserStore;
use App\Http\Requests\User\UserUpdate;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

/**
 * @group Users Module
 * @unauthenticated
 */
class UserController extends Controller
{
    protected $userRepository;
    protected $userService;

    public function __construct(UserRepository $userRepository, UserService $userService) {
        $this->authorizeResource(User::class, "user");
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * Users Index
     * @queryParam type.
     * @apiResourceCollection App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User paginate=10
     */
    public function index()
    {
        return ok_response($this->all());
    }

    /**
     * Users Create
     *
     * This endpoint allows you to add a word to the list.
     * It's a really useful endpoint, and you should play around
     * with it for a bit.
     *
     * @apiResourceCollection 201 App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User paginate=10
     *
     */
    public function store(UserStore $request) {
        $this->userService->createUser($request);
        return created_response($this->all());
    }

    /**
     * User Update
     * @urlParam id int required The ID of the User.
     * @apiResourceCollection App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User paginate=10
     */
    public function update(UserUpdate $request, User $user) {
        $this->userService->updateUser($request, $user);
        return ok_response($this->all());
    }

    /**
     * User Show
     * @urlParam id int required The ID of the User.
     * @apiResource App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User
     */
    public function show(Request $request, User $user) {
        return ok_response(new UserResource($user));
    }

    /**
     * User Delete
     * @urlParam id int required The ID of the User.
     * @apiResourceCollection App\Http\Resources\User\UserResource
     * @apiResourceModel App\Models\User paginate=10
     */
    public function destroy(Request $request, User $user) {
        if($user->isSuperAdmin()){
            return forbidden_response();
        }
        $user->delete();
        return ok_response($this->all());
    }

    private function all(){
        return collectionFormat(UserResource::class, $this->userRepository->getUsers());
    }
}
