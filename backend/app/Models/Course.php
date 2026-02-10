<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{



        protected $fillable = [
            'title',
            'description',
            'platform',
            'level',        // Level dropdown value
            'tags',         // Comma-separated tags
            'link',         // Regular link
            'linkyoutube',  // YouTube link added
        ];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
