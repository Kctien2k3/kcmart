<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use \DateTimeInterface;
use Illuminate\Support\Facades\Auth;


class Post_category extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    // use SoftDeletes;
    protected $table = 'post_categories'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'category_id'; // định hình page_id là khóa chính rất quang trọng khi nào mục điều chỉnh về id
    protected $fillable = [
        'category_name',
        'category_desc',
        'category_status',
        'category_slug',
        'parent_id',
        'user_id',
        // Thêm các cột khác ở đây nếu cần
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }


    public function childs()
    {
        return $this->hasMany(Post_category::class, 'parent_id', 'category_id');
    }
    public function parent()
    {
        return $this->belongsTo(Post_category::class, 'parent_id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // public static function data_tree($data, $parent_id = 1, $level = 0) {
    //     $result = [];
    //     //duyệt dữ liệu
    //     foreach ($data as $item) {
    //         if ($item['parent_id'] == $parent_id) {
    //             $item['level'] = $level;
    //             $result[] = $item;
    //             // unset($data[$item['cat_id']]);
    //             // duyệt mảng con 
    //             $child = self::data_tree($data, $item['cat_id'], $level + 1);
    //             $result = array_merge($result, $child);
    //         }
    //     }
    //     return $result;
    // }

    public static function ShowCategories($post_cats, $parent_id = 0, $char = '')
    {
        $output = '';
        foreach ($post_cats as $key => $item) {
            if ($item->parent_id == $parent_id) {
                $output .= '<option value="' . $item->category_id . '">' . $char . $item->category_name . '</option>';
                $output .= self::ShowCategories($post_cats, $item->category_id, $char . ' -- ');
            }
        }
        return $output;
    }
    

    public static function TableCategories($post_cats, $parent_id = 0, $char = '', &$t = 0)
    {
        $output = '';
        foreach ($post_cats as $key => $item) {
            if ($item->parent_id == $parent_id) {
                $t++;
                $output .= '<tr>';
                $output .= '<th scope="row" class="text-center">' . $t . '</th>';
                $output .= '<td>' . $char . $item->category_name . '</td>';
                $output .= '<td class="text-center">' .
                    ($item->category_status == 'draft'
                        ? '<span class="badge bg-warning">' .
                        "Chờ duyệt" .
                        '</span>'
                        : ($item->category_status == 'published'
                            ? '<span class="badge bg-success">' .
                            "Công khai" .
                            '</span>'
                            : '')) .
                    '</td>';
                $output .= '<td class="text-center">' . ($item->user->name ?? '---') . '</td>';
                $output .= '<td class="text-center">' . ($item->created_at->format('d/m/Y H:i:s') ?? '---') . '</td>';
                $output .= '<td class="text-center">';
                $output .= '<a href="' . route('post_cat.edit', ['category_id' => $item->category_id]) . '" class="btn btn-success btn-sm rounded-1 text-white mx-1" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>';
                $output .= '<a href="' . route('delete_post_cat', ['category_id' => $item->category_id]) . '" onclick="return confirm(\'Bạn có chắc xóa bản ghi này không?\')" class="btn btn-danger btn-sm rounded-1 mx-1 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>';
                $output .= '</td>';
                $output .= '</tr>';
                $output .= self::TableCategories($post_cats, $item->category_id, $char . ' -- ', $t);
            }
        }
        return $output;
    }

}
