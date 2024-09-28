<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'roles'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

    protected $fillable = [
        'name',
        'description',
        // Thêm các cột khác ở đây nếu cần
    ];
    public function permissions() {
        return $this->belongsToMany( Permission::class, 'role_permission');
    }

    
}
