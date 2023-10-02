<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;

class DataApplication extends Base
{

    use Sortable;

    public $sortable = ['id', 'name_ja', 'name_en', 'url', 'metadata_no', 'created_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name_ja', 'name_en', 'url', 'metadata_no'
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
}
