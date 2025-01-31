<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'inquiry_type',
        'content'
    ];
    public function scopeQuerySearch($query, $params){
        if(!empty($params['query'])){
            $query->where(function($q) use ($params) {
                $q->where('name', 'like', '%' . $params['query'] . '%')->orWhere('email', 'like', '%' . $params['query'] . '%');
        });
    }
        return $query;
    }

    public function scopeGenderSearch($query, $params){
        if(!empty($params)){
            $query->where('gender', $params['gender']);
        }
        return $query;
    }

    public function scopeInquirytypeSearch($query, $params){
        if(!empty($params)){
            $query->where('inquiry_type', $params['inquiry_type']);
        }
        return $query;
    }

}
