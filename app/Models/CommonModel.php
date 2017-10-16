<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonModel extends Model {
    // 如果数据库表的名称不是Topics ，则可以使用下面的方法，进行声明
    // protected $table = 'Topics';

    // Eloquent 也会假设每个数据库表都有一个字段名称为 id 的主键。
    // 可以在类里定义 primaryKey 属性来重写。
    // protected $primaryKey = 'o_id';

    // 可以定义 connection 属性，指定模型连接到指定的数据库连接。
    // protected $connection = '';

    // 在默认情况下，在数据库表里需要有 updated_at 和 created_at 两个字段。
    // 如果不想设定或自动更新这两个字段，则将类里的 $timestamps 属性设为 false即可。
    // protected $timestamps = false;

    // fillable 属性指定了哪些字段支持批量赋值 。可以设定在类的属性里或是实例化后设定。好像只针对 create 方法
    // protected $fillable = ['first_name', 'last_name', 'email'];

    // Guarded 属性指定了哪些字段不支持批量赋值 。fillable ，为白名单，guarded 为黑名单   好像只针对 create 方法
    // protected $Guarded  = ['id', 'password'];


    // 可以使用 guard 属性阻止所有属性被批量赋值：
    // protected $guarded = ['*'];

    // 通常 Eloquent 模型主键值会自动递增。但是您若想自定义主键，将 incrementing 属性设成 false 。
    // protected $incrementing = false;

    // 模型使用软删除功能，只要在模型类里加入下面语句，数据库添加 deleted_at字段
    // protected $softDelete  = true;

    // 有时您可能想要限制能出现在数组或 JSON 格式的属性数据，比如密码字段。只要在模型里增加 hidden 属性即可
    // protected $hidden = ['password'];

    // $dates属性里面包含的字段可以直接后面跟carbon类时间操作的任何方法，例如一个模型：$user->disabled_at->getTimestamp();
    // protected $dates = ['created_at', 'updated_at', 'disabled_at'];

    // $touches 当一个模型 belongsTo 或 belongsToMany 另一个模型时，可以设置此属性，之后当前模型只要更新，自动联动到对应父模型
    // post 为模型关联名称
    // protected $touches = ['post'];

    // $appends 增加 查询结果中不存在的字段，可以使用访问器设置不存在的字段，如 getProfitAttribute
    // protected $appends = ['profit'];

    // 访问器 getImagesAttribute, $model->images, 取到的为 处理过的结果，
    // 如果Images为数据库字段名，则自动在 json 的结果集中为处理过的结果，
    // print_r($model)显示为原始数据库数据，但是无法$model->images取出，需要使用 $model->getOriginal('images')
    // public function getImagesAttribute($value){
    //     return trim($value);
    // }

    // 出现和 model 字段冲突的问题（比如original），这时候 $model->original 会被过滤掉，这时候可以使用，
    // $model->__set($key, $value)|$model->setAttribute($key, $value);这个方法底层使用了 'set'.Str::studly($key).'Attribute';

}
