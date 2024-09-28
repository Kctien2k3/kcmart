<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Order_item extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    // use SoftDeletes;

    protected $table = 'order_items'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'item_id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

protected $fillable = [
    'order_id',
    'product_id',
    'quantity',
    'price',

    
    // Thêm các cột khác ở đây nếu cần
];
public $timestamps = false; // Disable both timestamps

public function product() {
    return $this->belongsTo(Product::class, 'product_id');
}



}
