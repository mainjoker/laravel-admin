<?php

namespace Tanmo\Admin\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use Tanmo\Search\Traits\Search;

class Administrator extends User
{
    use Search;

    /**
     * @var string
     */
    protected $table = 'admins';

    /**
     * @var array
     */
    protected $fillable = ['username', 'password', 'name', 'avatar'];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param $avatar
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        if ($avatar) {
            return Storage::disk(config('admin.upload.disk.avatar'))->url($avatar);
        }

        return admin_asset('/AdminLTE/dist/img/user2-160x160.jpg');
    }

    /**
     * @return BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'admin_role_users', 'user_id', 'role_id');
    }

    /**
     * @return array
     */
    public function allPermissions()
    {
        $permissions = [];
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $permission) {
                foreach ($permission->toPermissions() as $method => $uri) {
                    $permissions[$method][] = $uri;
                }
            }
        }

        return $permissions;
    }

    /**
     * 是否是超级管理员
     *
     * @return bool
     */
    public function isAdmin()
    {
        $adminstrators = config('admin.administrators');
        return in_array($this->id, $adminstrators) || $this->isRole('administrator');
    }

    /**
     * Check if user is $role.
     *
     * @param string $role
     *
     * @return mixed
     */
    public function isRole(string $role) : bool
    {
        return $this->roles->pluck('slug')->contains($role);
    }
}
