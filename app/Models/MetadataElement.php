<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;

class MetadataElement extends Base
{

    use Sortable;

    public $sortable = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'metadata_elements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'colum_name'
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
