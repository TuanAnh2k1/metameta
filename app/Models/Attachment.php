<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Base
{
    use HasFactory;
    public const MIMETYPE = ['docx','doc','xls','xlsx', 'ppt', 'pdf', 'txt', 'jpg'];

    protected $table = 'attachments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'note',
        'user_id',
        'metadata_no',
        'original_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    public function created_by_user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
