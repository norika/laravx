<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompanyMail;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'logo'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            Mail::to(Auth::user()->email)->queue(new CompanyMail([
                "title" => $model->title,
                "admin" => Auth::user()->name
            ]));
        });
    }

    public function industry()
    {
        return $this->belongsToMany(Industry::class);
    }

    public function employee()
    {
        return $this->hasMany(Employee::class, "company_id", "id");
    }
}
