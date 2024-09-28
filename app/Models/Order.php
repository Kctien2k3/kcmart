<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $table = 'orders'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'order_id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

    protected $fillable = [
        'order_code',
        'product_quantity',
        'total_amount',
        'payment_method',
        'shipping_address',
        'status',
        'order_date',
        'customer_id'

        // Thêm các cột khác ở đây nếu cần
    ];
    public function orderItem()
    {
        return $this->belongsTo(Order_item::class, 'order_id');
    }
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,       // Model cuối cùng bạn muốn lấy
            Order_item::class,    // Model trung gian
            'order_id',           // Khóa ngoại trong bảng order_items (liên kết với bảng orders)
            'product_id',         // Khóa ngoại trong bảng products (liên kết với product_id trong bảng order_items)
            'order_id',           // Khóa chính trong bảng orders
            'product_id'          // Khóa ngoại trong bảng order_items (liên kết với bảng products)
        );
    }
}
