<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'host',
        'email',
        'email_password',
        'port',
        'email_name',
        'enc_type'
    ];
}
