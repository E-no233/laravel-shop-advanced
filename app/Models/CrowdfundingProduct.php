<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdfundingProduct
 *
 * @property int $id
 * @property int $product_id
 * @property float $target_amount
 * @property float $total_amount
 * @property int $user_count
 * @property \Illuminate\Support\Carbon $end_at
 * @property string $status
 * @property-read mixed $percent
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdfundingProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdfundingProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdfundingProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdfundingProduct whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdfundingProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdfundingProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdfundingProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdfundingProduct whereTargetAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdfundingProduct whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CrowdfundingProduct whereUserCount($value)
 * @mixin \Eloquent
 */
class CrowdfundingProduct extends Model
{
    // 定义众筹的 3 种状态
    const STATUS_FUNDING = 'funding';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL    = 'fail';

    public static $statusMap = [
        self::STATUS_FUNDING => '众筹中',
        self::STATUS_SUCCESS => '众筹成功',
        self::STATUS_FAIL    => '众筹失败',
    ];

    protected $fillable = [
        'target_amount',
        'total_amount',
        'user_count',
        'end_at',
        'status',
    ];

    // end_at 会自动转为 Carbon 类型
    protected $dates = ['end_at'];

    // 不需要 created_at 和 updated_at 字段
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // 定义一个名为 percent 的访问器，返回当前众筹进度
    public function getPercentAttribute()
    {
        // 已筹金额除以目标金额
        $value = $this->attributes['total_amount'] / $this->attributes['target_amount'];
        return (float)number_format($value * 100, 2, '.', '');
    }
}
