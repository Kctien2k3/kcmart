<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $table = 'products'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'product_id'; // định hình product_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

    protected $fillable = [
        'product_title',
        'product_code',
        'product_slug',
        'product_desc',
        'product_price',
        'product_oldPrice',
        'product_status',
        'product_details',
        'stock_quantity',
        'image_id',
        'category_id',
        'user_id',
        'is_featured'

        // Thêm các cột khác ở đây nếu cần
    ];
    // public function images()
    // {
    //     return $this->hasManyThrough(
    //         Image::class,            // Model cuối cùng bạn muốn lấy
    //         Product_image::class,    // Model trung gian
    //         'product_id',            // Khóa ngoại trong bảng Product_image
    //         'image_id',              // Khóa ngoại trong bảng Image
    //         'product_id',            // Khóa chính trong bảng Product
    //         'image_id'               // Khóa chính trong bảng Product_image
    //     );
    // }
    public function image()
    {
        return $this->hasOneThrough(
            Image::class,            // Model cuối cùng bạn muốn lấy
            Product_image::class,    // Model trung gian
            'product_id',            // Khóa ngoại trong bảng Product_image
            'image_id',              // Khóa ngoại trong bảng Image
            'product_id',            // Khóa chính trong bảng Product
            'image_id'               // Khóa chính trong bảng Product_image
        );
    }
    public function product_image()
    {
        return $this->belongsTo( Product_image::class, 'product_id');
    }
    // Hàm format giá
    public function formatPrice($currency = 'VND', $decimals = 0)
    {
        return number_format($this->product_price, $decimals, ',', '.') . ' ' . $currency;
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function product_category()
    {
        return $this->belongsTo(Product_category::class, 'category_id');
    }

}
