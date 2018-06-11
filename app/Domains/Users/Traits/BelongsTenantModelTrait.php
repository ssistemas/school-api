<?php

namespace Emtudo\Domains\Users\Traits;

use Emtudo\Domains\Users\User;

trait BelongsTenantModelTrait
{
    /**
     * Validate the model, so you will always have a user_id.
     */
    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            if (empty($model->user_id)) {
                $model->setOwnerUser();
                if (empty($model->user_id)) {
                    throw new \InvalidArgumentException(get_class($model) . ' need to be a valid user_id attribute');
                }
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setOwnerUser()
    {
        $user = User::currentUser();
        if ($user) {
            $this->user_id = $user->id;
        }
    }
}
