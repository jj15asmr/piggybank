<?php

namespace App\Models;

use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomainPrice extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'registration_price' => MoneyIntegerCast::class,
        'renewal_price' => MoneyIntegerCast::class,
    ];

    /**
     * Scope a query to get the models for a specific set of TLDs.
     */
    public function scopeByTlds(Builder $query, array $tlds): void
    {
        // We will increment this counter on each TLD constrained so we can add an "orWhere" when needed
        $tlds_constrained = 0;

        foreach ($tlds as $tld) {
            if ($tlds_constrained === 0) {
                $query->where('tld', $tld);
            } else {
                $query->orWhere('tld', $tld);
            }

            $tlds_constrained++;
        }
    }
}
