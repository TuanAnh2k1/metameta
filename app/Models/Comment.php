<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;

class Comment extends Base
{

    use Sortable;

    public $sortable = ['id', 'comment', 'metadata_no', 'metameta_element_id', 'created_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comment', 'comment_date', 'user_id', 'metadata_no', 'metameta_element_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function metadata_element()
    {
        return $this->hasOne(MetadataElement::class, 'id', 'metameta_element_id');
    }
}
