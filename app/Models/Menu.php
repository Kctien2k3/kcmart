<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    // use SoftDeletes;

    protected $table = 'menu'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'menu_id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

protected $fillable = [
    'menu_title',
    'menu_url',
    'menu_status',
    'creator',
    'page_id',
    'user_id',
    'update_at'
    
    // Thêm các cột khác ở đây nếu cần
];
}
