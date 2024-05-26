<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getpermissionGroups(){

        $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();

        return $permission_groups;

    }

    public static function getpermissionByGroupName($group_name){

        $permission = DB::table('permissions')->select('name','id')->where('group_name',$group_name)->get();

        return $permission;

    }

    public static function following(){
        return $this->belongsToMany(User::class, 'follower_user', 'follower_id', 'user_id')->withTimestamps();
    }

    public static function followers(){
        return $this->belongsToMany(User::class, 'follower_user', 'user_id', 'follower_id')->withTimestamps();
    }

    public function follows(User $user){
        return $this->following()->where('user_id', $user->id)->exists();
    }

    public function likes(){
        return $this->belongsToMany(NewsPost::class, 'idea_like')->withTimestamps();
    }

    public function likePost(NewsPost $newsPost){
        return $this->likes()->where('newsPost_id', $newsPost->id)->exists();

    }

    public static function roleHasPermissions($role,$permission){

        $hasPermission = true;

        foreach ($permission as $perm) {

            // hasPermissionTo() merupakan fungsi dari laravel spatie

            if (!$role->hasPermissionTo($perm->name)) {

                $hasPermission = false;

                return $hasPermission;

            }

            return $hasPermission;

        }

    }

}
