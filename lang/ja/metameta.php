<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'contacts_information' => '連絡先情報',
    'authors_information' => 'メタデータ作成者情報',
    'data_application_information' => 'データ利用/ダウンロードアプリケーション情報',

    'metameta' => 'メタメタ',
    'add_metameta' => 'メタメタ登録',
    'edit_metameta' => 'メタメタ編集',
    'id' => 'メタデータNo.',
    'metameta_id' => 'メタデータId.',
    'metameta_element_id' => 'メタメタ要素ID',
    'metameta_element' => 'メタメタ要素',
    'dataset_name_ja' => 'データセット名ja',
    'dataset_name_en' => 'データセット名en',
    'dataset_id' => 'データセットID',
    'dataset_number' => 'データセットNo.',
    'severity' => '重大度',
    'remarks' => '備考',
    'manager' => '担当',
    'reception_id' => '受付ID',
    'application_progress' => '申請書進捗',
    'data_meeting_progress' => 'データ会議進捗',
    'leader_meeting_progress' => 'リーダー会議進捗',
    'data_transfer_progress' => 'データ転送進捗',
    'metadata_progress' => 'メタデータ進捗',
    'download_progress' => 'ダウンロードシステム進捗',
    'search_progress' => '俯瞰検索システム進捗',
    'pr_progress' => '広報進捗',
    'permission' => '利用許可申請',
    'contacts_name' => '連絡先名前',
    'contacts_email' => '連絡先e-mail',
    'authors_name' => 'メタデータ作成者名前',
    'authors_email' => 'メタデータ作成者e-mail',
    'category' => 'カテゴリ（データ分類）',
    'doi' => 'DOI',
    'release_method' => 'データセット公開方法',
    'access_permission' => 'アクセス権',
    'data_directory' => '格納ディレクトリ',
    'data_applications_name_ja' => 'データ利用/ダウンロードアプリケーション名ja',
    'data_applications_name_en' => 'データ利用/ダウンロードアプリケーション名en',
    'data_applications_url' => 'データ利用/ダウンロードアプリケーションURL',
    'metadata_ja_url' => 'ドキュメントメタデータja URL',
    'metadata_en_url' => 'ドキュメントメタデータen URL',
    'search_url' => '公開URL',
    'name_ja_required' => 'データ利用/ダウンロードアプリケーション名jaを入力してください。',
    'name_en_required' => 'データ利用/ダウンロードアプリケーション名enを入力してください。',
    'url_required' => 'データ利用/ダウンロードアプリケーションURLを入力してください。',
    'least_one_field' => '少なくとも1つのフィールドに入力してください。',
    'metameta_element_id_integer' => 'メタメタ要素IDには整数型で入力してください。',
    'metadata_no_integer' => 'メタデータNoには整数型で入力してください。',
    'metameta_element_id_required' => 'データ利用/ダウンロードアプリケーションメタメタ要素ID',
    'metadata_no_required' => 'データ利用/ダウンロードアプリケーションメタデータNo',
    'severity_normal' => '通常',
    'severity_emergency' => '緊急',
    'confirm_delete' => '削除してもよろしいでしょうか。',
    'confirm_delete_text_1' => 'メタデータを誤って作成したため削除します。よろしいでしょうか。',
    'confirm_delete_text_2' => '次のキーワードを下記のボックスに入力してください。',
    'confirm_delete_text_3' => '状況を理解しました上で、このメタデータを削除します。',
    'setting' => [
        'table_setting' => "ターブル設定",
        'is_display' => "表示",
        'column_name' => "コラム名",
        'width' => "幅(px)",
        'is_freeze' => "固定",
    ],
    'status' => [
        'undecided' => '未定',
        'in_process' => '作業中',
        'completed' => '完了',
        'canceled' => '中止',
    ],
    'attach_form' => '申請書等',
    'delete_file_confirm' => '本当に削除してよろしいですか。',
    'severity_status' => [
        'normal' => '通常',
        'urgent' => '緊急',
    ],
    'permission_status' => [
        'unnecessary' => '不要',
        'need' => '必要',
    ],
    'category_status' => [
        'on_site_observation' => '現地観測',
        'satellite_observation' => '衛星観測',
        'weather_forecast' => '気象予測',
        'climate_change_prediction' => '気候変動予測',
        'others' => 'その他',
    ],
    'release_method_status' => [
        'data_private' => 'データ非公開',
        'data_disclosure_on_DIAS' => 'DIASでデータ公開',
        'publish_data_externally' => '外部でデータ公開',
        'others' => 'その他',
        'metadata_private' => 'メタデータ非公開',
    ],
    'access_permission_status' => [
        'free_open' => 'フリーオープン',
        'agree_to_terms' => '規約同意',
        'permission_required' => '要利用許可',
        'special_permission_required' => '要特別許可',
    ],
    'dataset_name_not-match' => "データセット名enは一致しません。",
    'not_found' => [
        'file' => 'ファイルが見つかりません。',
        'element_id' => 'メタデータ要素を見つけません。',
        'memo' => 'メモを見つけません。',
        'comment' => 'コメントが見つかりません。',
    ],
    'access_denied' => 'アクセス権限が必要です。',
    'validate' => [
        'exists' => 'メタメタがありません。',
        'url' => 'URLでは有効なリンクを入力してください。',
    ]
];
