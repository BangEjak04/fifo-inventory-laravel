<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ProductRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductRequestPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ProductRequest');
    }

    public function view(AuthUser $authUser, ProductRequest $productRequest): bool
    {
        return $authUser->can('View:ProductRequest');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ProductRequest');
    }

    public function update(AuthUser $authUser, ProductRequest $productRequest): bool
    {
        return $authUser->can('Update:ProductRequest');
    }

    public function delete(AuthUser $authUser, ProductRequest $productRequest): bool
    {
        return $authUser->can('Delete:ProductRequest');
    }

    public function restore(AuthUser $authUser, ProductRequest $productRequest): bool
    {
        return $authUser->can('Restore:ProductRequest');
    }

    public function forceDelete(AuthUser $authUser, ProductRequest $productRequest): bool
    {
        return $authUser->can('ForceDelete:ProductRequest');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ProductRequest');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ProductRequest');
    }

    public function replicate(AuthUser $authUser, ProductRequest $productRequest): bool
    {
        return $authUser->can('Replicate:ProductRequest');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ProductRequest');
    }

}