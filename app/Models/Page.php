<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
        use HasApiTokens, HasFactory, Notifiable;
        use SoftDeletes;
    
        protected $table = 'pages'; // Tên bảng trong cơ sở dữ liệu
        protected $primaryKey = 'page_id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

    protected $fillable = [
        'page_title',
        'page_content',
        'page_status',
        'page_slug',
        'user_id'
        // Thêm các cột khác ở đây nếu cần
    ];
    public function orderItem()
    {
        return $this->belongsTo(Order_item::class, 'order_id');
    }
    
}
