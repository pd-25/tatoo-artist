<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'subscription_plan',
        'status',
        'payment_option',
        'zell_email',
        'zell_phone',
        'ach_bank_name',
        'ach_type',
        'ach_routing_number',
        'ach_account_number',
        'subscription_date',
    ];

    /**
     * Define the relationship to the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'subscription_date' => 'datetime',
    ];
}
