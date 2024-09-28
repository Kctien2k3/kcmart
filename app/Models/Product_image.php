<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product_image extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    // use SoftDeletes;

    protected $table = 'product_images'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'product_image_id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

    protected $fillable = [
        'image_id',
        'product_id',
        'pin',
        // Thêm các cột khác ở đây nếu cần
    ];
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
