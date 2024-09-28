<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    protected $table = 'wards'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'wards_id'; // định hình product_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id

    protected $fillable = [
        'name',
        'district_id'
        // Thêm các cột khác ở đây nếu cần
    ];
}
