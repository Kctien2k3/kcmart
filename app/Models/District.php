<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class District extends Model
{
    use HasFactory;
    protected $table = 'district'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'district_id'; // định hình product_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

    protected $fillable = [
        'name',
        'province_id'
        // Thêm các cột khác ở đây nếu cần
    ];
}
