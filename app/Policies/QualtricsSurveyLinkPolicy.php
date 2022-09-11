<?php

namespace App\Policies;

use App\Models\QualtricsSurveyLink;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Auth\Access\HandlesAuthorization;

class QualtricsSurveyLinkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole([Roles::ADMIN, Roles::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualtricsSurveyLink  $qualtricsSurveyLink
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, QualtricsSurveyLink $qualtricsSurveyLink)
    {
        return $user->hasRole([Roles::ADMIN, Roles::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole([Roles::ADMIN, Roles::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualtricsSurveyLink  $qualtricsSurveyLink
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, QualtricsSurveyLink $qualtricsSurveyLink)
    {
        return $user->hasRole([Roles::ADMIN, Roles::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualtricsSurveyLink  $qualtricsSurveyLink
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, QualtricsSurveyLink $qualtricsSurveyLink)
    {
        return $user->hasRole([Roles::ADMIN, Roles::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualtricsSurveyLink  $qualtricsSurveyLink
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, QualtricsSurveyLink $qualtricsSurveyLink)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\QualtricsSurveyLink  $qualtricsSurveyLink
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, QualtricsSurveyLink $qualtricsSurveyLink)
    {
        //
    }
}
