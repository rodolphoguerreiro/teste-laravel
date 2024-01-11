<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'contents',
    ];

    public static function getMaxLength($field)
    {
        $limits = [
            'contents' => 255
        ];

        return $limits[$field] ?? null;
    }

    public function rules()
    {

        $rules = [
            'category_id' => 'required|integer',
            'title' => 'required|string',
            'contents' => 'required|string|max:255',
        ];

        return $rules;
    }

}
