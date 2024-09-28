<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Slider extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    // use SoftDeletes;

    protected $table = 'sliders'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'slider_id'; // định hình slider_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

protected $fillable = [
    'image_id',
    'slider_title',
    'slider_url',
    'slider_desc',
    'display_order',
    'user_id',
    'slider_status',
    
    
    // Thêm các cột khác ở đây nếu cần
];

public function image()
{
    return $this->belongsTo(Image::class, 'image_id');
}
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
