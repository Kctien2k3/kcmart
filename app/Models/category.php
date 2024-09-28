<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// class Post_category extends Model
// {
//     use HasApiTokens, HasFactory, Notifiable;
//     // use SoftDeletes;
//     protected $table = 'post_categories'; // Tên bảng trong cơ sở dữ liệu
//     protected $primaryKey = 'category_id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id
//     protected $fillable = [
//         'category_name',
//         'category_desc',
//         'category_slug',
//         'parent_id',
//         // Thêm các cột khác ở đây nếu cần
//     ];

//     public function childs() {
//         return $this->hasMany(Post_category::class, 'parent_id', 'category_id');
//     }
//     public function parent() {
//         return $this->belongsTo(Post_category::class, 'parent_id');
//     }
//     // public function data_tree($list_cat, $parent_id = 0, $level = 0)
//     // {
//     //     $result = [];
//     //     foreach ($list_cat as $item) {
//     //         if ($item['parent_id'] == $parent_id) {
//     //             $item['level'] = $level;
//     //             $result[] = $item;
//     //             unset($list_cat[$item['id']]);
//     //             $child = self::data_tree($list_cat, $item['id'], $level + 1);
//     //             $result = array_merge($result, $child);
//     //         }
//     //     }
//     //     return $result;
//     // }

//     // public function recursive($Categories, $parents = 0, $level = 0, &$listCategory){
//     //     if (count($Categories) > 0) {
//     //         foreach ($Categories as $key => $value) {
//     //             if ($value->parent_id == $parents) {
//     //                 $value->level = $level;
//     //                 $listCategory[] = $value;
//     //                 unset($Categories[$key]);
//     //                 $parent = $value->category_id;
//     //                 self::recursive($Categories, $parent, $level + 1, $listCategory);
//     //             }
//     //         }
//     //     }
//     // }
//     // public function recursive($Categories, $parents = 0, $level = 0, &$listCategory)
//     // {
//     //     if (count($Categories) > 0) {
//     //         foreach ($Categories as $key => $value) {
//     //             if ($value->parent_id == $parents) {
//     //                 $value->level = $level;
//     //                 $listCategory[] = $value;
//     //                 unset($Categories[$key]);
//     //                 $parent = $value->category_id;
//     //                 $this->recursive($Categories, $parent, $level + 1, $listCategory);
//     //             }
//     //         }
//     //     }
//     // }
// }
