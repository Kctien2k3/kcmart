<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Post extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    protected $table = 'posts'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'post_id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

protected $fillable = [
    'post_title',
    'post_content',
    'post_status',
    'post_slug',
    'image_id',
    'post_excerpt',
    'category_id',
    'user_id'
    
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
public function post_category() {
    return $this->belongsTo(Post_category::class, 'category_id');
}
}
