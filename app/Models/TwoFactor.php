<?php

namespace App\Models;

use App\Jobs\SendEmail;
use App\Jobs\SendSms;
use App\Mail\SendCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFactor extends Model
{
    use HasFactory;

    const CODE_EXPIRED = 60 ;

    protected $table = 'two_factor';

    protected $fillable = [
        'user_id',
        'code'
    ];

    public static function generateCodeFor(User $user)
    {
        $user->code()->delete();

        return static::create([
            'user_id' => $user->id,
            'code' => mt_rand(1000, 9999)
        ]);
    }

    public function getCodeForSendAttribute()
    {
//        return __(['code' => $this->code]);

    }

    public function sendSms()
    {
        SendSms::dispatch($this->user , $this->code);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {

        return $this->created_at->diffInSeconds(now()) > static::CODE_EXPIRED;
    }

    public function isEqualWith(string $code)
    {
        return $this->code == $code;
    }

    public function sendEmail()
    {
        SendEmail::dispatch($this->user, new SendCode($this->code));

    }


}
