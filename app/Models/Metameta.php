<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;

class Metameta extends Base
{    public const METAMETA_ELEMENTS = [
        'application_progress',
        'data_meeting_progress',
        'leader_meeting_progress',
        'data_transfer_progress',
        'metadata_progress',
        'download_progress',
        'search_progress',
        'pr_progress',
        'permission',
    ];

    use Sortable;

    public $sortable = ['id', 'dataset_name_ja', 'dataset_name_en', 'severity', 'remarks',];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'metameta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dataset_name_ja',
        'dataset_name_en',
        'dataset_id',
        'dataset_number',
        'severity',
        'remarks',
        'manager',
        'reception_id',
        'application_progress',
        'data_meeting_progress',
        'leader_meeting_progress',
        'data_transfer_progress',
        'metadata_progress',
        'download_progress',
        'search_progress',
        'pr_progress',
        'permission',
        'doi',
        'category',
        'release_method',
        'access_permission',
        'data_directory',
        'metadata_ja_url',
        'metadata_en_url',
        'search_url',
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
