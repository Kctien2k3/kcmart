<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Image extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    // use SoftDeletes;

    protected $table = 'images'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'image_id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

protected $fillable = [
    'image_url',
    'file_name',
    'file_size',
    'user_id',      
    // Thêm các cột khác ở đây nếu cần
];
// public function product()
// {
//     return $this->hasOneThrough(
//         Product::class,            // Model cuối cùng bạn muốn lấy
//         Product_image::class,    // Model trung gian
//         'image_id',            // Khóa ngoại trong bảng Product_image
//         'product_id',              // Khóa ngoại trong bảng Image
//         'image_id',            // Khóa chính trong bảng Product
//         'product_id'               // Khóa chính trong bảng Product_image
//     );
// }

}
