<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



#[Fillable(['user_id', 'subscription_package_id'])]
class SubscriptionPackageUser extends Model


{
    public function subscriptionPackage(): BelongsTo
    {
        return $this->BelongsTo(SubscriptionPackage::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
