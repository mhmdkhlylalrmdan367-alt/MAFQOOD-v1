<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        $emailChanged = $user->email !== $input['email'];

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'] ?? null,
            'region_id' => $input['region_id'] ?? null,
        ])->save();

        if ($emailChanged && $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && \Laravel\Fortify\Features::enabled(\Laravel\Fortify\Features::emailVerification())) {
            $user->sendEmailVerificationNotification();
        }
    }
}