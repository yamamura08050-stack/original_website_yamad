<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'weight',
        'record_date',
    ];

    protected $casts = [
        'record_date' => 'date',
    ];

    // record_date を常に Y-m-d で返す
    protected function recordDate(): Attribute
    {
        return Attribute::get(fn($value) => \Carbon\Carbon::parse($value)->format('Y-m-d'));
    }






    public function diffFromPrevious(){

        $previous= self::where('user_id', $this->user_id)//weightclassのカラム名user_idの$this->user_id番め
            ->where('record_date', '<', $this->record_date)//$this->user_id番目のuserの日付のでーた
            ->orderBy('record_date','desc')
            ->first();

        if(!$previous){
            return 0;
        }

        $diff = $this->weight - $previous->weight;

        $diff = $this->weight - $previous->weight;

        // 差に+-とkgをつける
        if ($diff > 0) {
            return '+' . number_format($diff, 1) . 'kg';
        } elseif ($diff < 0) {
            return number_format($diff, 1) . 'kg';
        } else {
            return '±0kg';
        }
}
}
