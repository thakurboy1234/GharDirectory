<?php

namespace Botble\ACL\Services;

use Illuminate\Support\Facades\Auth;
use Botble\ACL\Repositories\Interfaces\UserInterface;
use Botble\Support\Services\ProduceServiceInterface;
use Exception;
use Hash;
use Illuminate\Http\Request;

class ChangePasswordService implements ProduceServiceInterface
{
    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(Request $request): Exception|bool
    {
        if (! $request->user()->isSuperUser()) {
            if (! Hash::check($request->input('old_password'), $request->user()->getAuthPassword())) {
                return new Exception(trans('core/acl::users.current_password_not_valid'));
            }
        }

        $user = $this->userRepository->findOrFail($request->input('id', $request->user()->getKey()));

        $user->password = Hash::make($request->input('password'));
        $this->userRepository->createOrUpdate($user);

        if ($user->id != $request->user()->id) {
            Auth::setUser($user)->logoutOtherDevices($request->input('password'));
        }

        do_action(USER_ACTION_AFTER_UPDATE_PASSWORD, USER_MODULE_SCREEN_NAME, $request, $user);

        return $user;
    }
}
