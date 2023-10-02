<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;

class Memo extends Base
{

    use Sortable;

    public $sortable = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'memos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['memo', 'memo_date', 'user_id', 'metadata_no', 'metameta_element_id'
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

    public function creator_memo()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
