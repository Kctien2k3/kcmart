<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    // use SoftDeletes;

    protected $table = 'customers'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'customer_id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

protected $fillable = [
    'fullname',
    'email',
    'phone_number',
    'address',
   
    
    // Thêm các cột khác ở đây nếu cần
];

protected $hidden = [
    'password',
    'remember_token',
];

protected $casts = [
    'email_verified_at' => 'datetime',
    'created_at' => 'datetime'
    // Định dạng các cột khác ở đây nếu cần
];
public function order()
    {
        return $this->belongsTo(Order::class, 'customer_id');
    }
}
