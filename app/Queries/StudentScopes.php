<?php


namespace App\Queries;

use App\Features\CashManagement\CostCenter\Domains\Models\CostCenter;
use App\Features\Contact\Domains\Models\InvoicingCompany;
use Illuminate\Database\Eloquent\Builder;

trait StudentScopes
{
    /**
     * Query Scopes
     */
    public function scopeSearch(Builder $query, ?string $args): Builder
    {
        if ($args) {
            return $query->where('id', 'like',"%{$args}%")
                ->orWhereHas('user_id',function($user_id) use($args){
                    $user_id->where('name','like',"%{$args}%");
                });
        }
        return $query;
    }
    public function scopeLimitBy(Builder $query, int $start, int $length): Builder
    {
        if($length != -1)
        {
            return $query->offset($start)->limit($length);
        }
        return $query;
    }
    public function scopeOrder(Builder $query, array $order): Builder
    {
        if ($order) {
            $columns = ['actions','id', 'name'];
            if($order[0]['column'] == 2){
                return $query->whereHas('user_id',function($user_id) use($order){
                    return $user_id->orderBy('name',$order[0]['dir']);
                });
            }
            return $query->orderBy($columns[$order[0]['column']], $order[0]['dir']);
        }
        return $query;
    }
}
