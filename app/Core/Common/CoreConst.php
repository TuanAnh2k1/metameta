<?php

namespace App\Core\Common;

class CoreConst
{
    public const LOCALE_SESSION_NAME = 'locale';
    public const EN_LOCALE = 'en';
    public const JA_LOCALE = 'ja';
    public const METAMETA_STORAGE_DISK = 'local';
    public const PARAM_TOKEN = '_token';
    public const HAS_COMMENT_CLASS = 'comment-yellow';
    public const TOKEN_EXPIRATION_TIME = 60; // Unit: minutes
    public const PREFIX_DELETE_CONFIRM_MESSAGE = 'delete';
    public const PAGE_SIZES = [10,20,50,100, 1000];
    public const METAMETA_FILE_FOLDER = '/meta';
    public const PREFIX_METADATA_COLUMN_NAME = 'metameta.';
    public const DEFAULT_METAMETA_MIN_WIDTH = 150;
    public const DEFAULT_METAMETA_EDIT_WIDTH = 50;
    public const METAMETA_DEFAULT_ITEM_SETTING = [
        'is_display' => false,
        'column_name' =>  '',
        'width' => null,
        'is_freeze' => false,
    ];

    public const METAMETA_DEFAULT_SETTING = [
        [
            'is_display' => true,
            'column_name' =>  'id',
            'width' => 150,
            'is_freeze' => true,
        ],
        [
            'is_display' => true,
            'column_name' =>  'dataset_name_ja',
            'width' => 215,
            'is_freeze' => true,
        ],
        [
            'is_display' => true,
            'column_name' =>  'dataset_name_en',
            'width' => 215,
            'is_freeze' => false,
        ],
    ];
    public const METAMETA_SORTABLE_COLUMN = [
        'id', 'dataset_name_ja', 'dataset_name_en', 'severity', 'remarks'
    ];

    public const METAMETA_STATUS = [
        'UNDECIDED' => 0,
        'IN_PROCESS' => 1,
        'COMPLETED' => 2,
        'CANCELED' => 9,
    ];

    public const METAMETA_PROGRESS_STATUS = [
        self::METAMETA_STATUS['UNDECIDED'] => [
            'text' => 'metameta.status.undecided',
            'class' => 'bg-undecided',
            'value' => self::METAMETA_STATUS['UNDECIDED'],
        ],
        self::METAMETA_STATUS['IN_PROCESS'] => [
            'text' => 'metameta.status.in_process',
            'class' => 'bg-in-progress',
            'value' => self::METAMETA_STATUS['IN_PROCESS'],
        ],
        self::METAMETA_STATUS['COMPLETED'] => [
            'text' => 'metameta.status.completed',
            'class' => 'bg-success',
            'value' => self::METAMETA_STATUS['COMPLETED'],
        ],
        self::METAMETA_STATUS['CANCELED'] => [
            'text' => 'metameta.status.canceled',
            'class' => 'bg-canceled',
            'value' => self::METAMETA_STATUS['CANCELED'],
        ],
    ];
    public const METAMETA_SEVERITY = [
        'NORMAL' => 1,
        'URGENT' => 2,
    ];
    public const METAMETA_PREMISSION = [
        'UNNECESSARY' => 1,
        'NEED' => 2,
    ];
    public const METAMETA_CATEGORY = [
        'ON_SITE_OBSERVATION' => 1,
        'SATELLITE_SITE_OBSERVATION' => 2,
        'WEATHER_FORECAST' => 3,
        'CLIMATE_CHANGE_PREDICTION' => 4,
        'OTHERS' => 5,
    ];
    public const METAMETA_RELEASE_METHOD = [
        'DATA_PRIVATE' => 0,
        'DATA_DISCLOSURE_ON_DIAS' => 1,
        'PUBLISH_DATA_EXTERNALLY' => 2,
        'OTHERS' => 3,
        'METADATA_PRIVATE' => 4,
    ];
    public const METAMETA_ACCESS_PREMISSION = [
        'FREE_OPEN' => 0,
        'AGREE_TO_TERMS' => 1,
        'PERMISSION_REQUIRED' => 2,
        'SPECIAL_PERMISSION_REQUIRED' => 3,
    ];
    public const METAMETA_VALUE = [
        'severity' => [
            self::METAMETA_SEVERITY['NORMAL'] => [
                'text' => 'metameta.severity_status.normal',
                'class' => '',
                'value' => self::METAMETA_SEVERITY['NORMAL'],
            ],
            self::METAMETA_SEVERITY['URGENT'] => [
                'text' => 'metameta.severity_status.urgent',
                'class' => 'bg-red',
                'value' => self::METAMETA_SEVERITY['URGENT'],
            ]
        ],
        'application_progress' => self::METAMETA_PROGRESS_STATUS,
        'data_meeting_progress' => self::METAMETA_PROGRESS_STATUS,
        'leader_meeting_progress' => self::METAMETA_PROGRESS_STATUS,
        'data_transfer_progress' => self::METAMETA_PROGRESS_STATUS,
        'metadata_progress' => self::METAMETA_PROGRESS_STATUS,
        'download_progress' => self::METAMETA_PROGRESS_STATUS,
        'search_progress' => self::METAMETA_PROGRESS_STATUS,
        'pr_progress' => self::METAMETA_PROGRESS_STATUS,
        'permission' => [
            self::METAMETA_PREMISSION['UNNECESSARY'] => [
                'text' => 'metameta.permission_status.unnecessary',
                'class' => '',
                'value' => self::METAMETA_PREMISSION['UNNECESSARY'],
            ],
            self::METAMETA_PREMISSION['NEED'] => [
                'text' => 'metameta.permission_status.need',
                'class' => '',
                'value' => self::METAMETA_PREMISSION['NEED'],
            ]
        ],
        'category' => [
            self::METAMETA_CATEGORY['ON_SITE_OBSERVATION'] => [
                'text' => 'metameta.category_status.on_site_observation',
                'class' => '',
                'value' => self::METAMETA_CATEGORY['ON_SITE_OBSERVATION'],
            ],
            self::METAMETA_CATEGORY['SATELLITE_SITE_OBSERVATION'] => [
                'text' => 'metameta.category_status.satellite_observation',
                'class' => '',
                'value' => self::METAMETA_CATEGORY['SATELLITE_SITE_OBSERVATION'],
            ],
            self::METAMETA_CATEGORY['WEATHER_FORECAST'] => [
                'text' => 'metameta.category_status.weather_forecast',
                'class' => '',
                'value' => self::METAMETA_CATEGORY['WEATHER_FORECAST'],
            ],
            self::METAMETA_CATEGORY['CLIMATE_CHANGE_PREDICTION'] => [
                'text' => 'metameta.category_status.climate_change_prediction',
                'class' => '',
                'value' => self::METAMETA_CATEGORY['CLIMATE_CHANGE_PREDICTION'],
            ],
            self::METAMETA_CATEGORY['OTHERS'] => [
                'text' => 'metameta.category_status.others',
                'class' => '',
                'value' => self::METAMETA_CATEGORY['OTHERS'],
            ]
        ],
        'release_method' => [
            self::METAMETA_RELEASE_METHOD['DATA_PRIVATE'] => [
                'text' => 'metameta.release_method_status.data_private',
                'class' => '',
                'value' => self::METAMETA_RELEASE_METHOD['DATA_PRIVATE'],
            ],
            self::METAMETA_RELEASE_METHOD['DATA_DISCLOSURE_ON_DIAS'] => [
                'text' => 'metameta.release_method_status.data_disclosure_on_DIAS',
                'class' => '',
                'value' => self::METAMETA_RELEASE_METHOD['DATA_DISCLOSURE_ON_DIAS'],
            ],
            self::METAMETA_RELEASE_METHOD['PUBLISH_DATA_EXTERNALLY'] => [
                'text' => 'metameta.release_method_status.publish_data_externally',
                'class' => '',
                'value' => self::METAMETA_RELEASE_METHOD['PUBLISH_DATA_EXTERNALLY'],
            ],
            self::METAMETA_RELEASE_METHOD['OTHERS'] => [
                'text' => 'metameta.release_method_status.others',
                'class' => '',
                'value' => self::METAMETA_RELEASE_METHOD['OTHERS'],
            ],
            self::METAMETA_RELEASE_METHOD['METADATA_PRIVATE'] => [
                'text' => 'metameta.release_method_status.metadata_private',
                'class' => '',
                'value' => self::METAMETA_RELEASE_METHOD['METADATA_PRIVATE'],
            ]
        ],
        'access_permission' => [
            self::METAMETA_ACCESS_PREMISSION['FREE_OPEN'] => [
                'text' => 'metameta.access_permission_status.free_open',
                'class' => '',
                'value' => self::METAMETA_ACCESS_PREMISSION['FREE_OPEN'],
            ],
            self::METAMETA_ACCESS_PREMISSION['AGREE_TO_TERMS'] => [
                'text' => 'metameta.access_permission_status.agree_to_terms',
                'class' => '',
                'value' => self::METAMETA_ACCESS_PREMISSION['AGREE_TO_TERMS'],
            ],
            self::METAMETA_ACCESS_PREMISSION['PERMISSION_REQUIRED'] => [
                'text' => 'metameta.access_permission_status.permission_required',
                'class' => '',
                'value' => self::METAMETA_ACCESS_PREMISSION['PERMISSION_REQUIRED'],
            ],
            self::METAMETA_ACCESS_PREMISSION['SPECIAL_PERMISSION_REQUIRED'] => [
                'text' => 'metameta.access_permission_status.special_permission_required',
                'class' => '',
                'value' => self::METAMETA_ACCESS_PREMISSION['SPECIAL_PERMISSION_REQUIRED'],
            ],
        ],
    ];
}