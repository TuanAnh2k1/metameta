<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MetadataElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('metadata_elements')->truncate();
        DB::table('metadata_elements')->insert([
            [
                'name' => 'メタデータNo.',
                'column_name' => 'metameta.id',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'データセット名ja',
                'column_name' => 'metameta.dataset_name_ja',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'データセット名en',
                'column_name' => 'metameta.dataset_name_en',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'データセットID',
                'column_name' => 'metameta.dataset_id',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'データセットNo.',
                'column_name' => 'metameta.dataset_number',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '対応方法',
                'column_name' => 'metameta.severity',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '備考',
                'column_name' => 'metameta.remarks',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '担当',
                'column_name' => 'metameta.manager',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '受付ID',
                'column_name' => 'metameta.reception_id',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '申請書進捗',
                'column_name' => 'metameta.application_progress',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'データ会議進捗',
                'column_name' => 'metameta.data_meeting_progress',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'リーダー会議進捗',
                'column_name' => 'metameta.leader_meeting_progress',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'データ転送進捗',
                'column_name' => 'metameta.data_transfer_progress',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'メタデータ進捗',
                'column_name' => 'metameta.metadata_progress',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'ダウンロードシステム進捗',
                'column_name' => 'metameta.download_progress',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '俯瞰検索システム進捗',
                'column_name' => 'metameta.search_progress',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '広報進捗',
                'column_name' => 'metameta.pr_progress',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '利用許可申請',
                'column_name' => 'metameta.permission',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '連絡先名前',
                'column_name' => 'contacts.name',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '連絡先e-mail',
                'column_name' => 'contacts.email',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'メタデータ作成者名前',
                'column_name' => 'authors.name',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'メタデータ作成者e-mail',
                'column_name' => 'authors.email',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'DOI',
                'column_name' => 'metameta.doi',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'カテゴリ（データ分類）',
                'column_name' => 'metameta.category',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'データセット公開方法',
                'column_name' => 'metameta.release_method',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'アクセス権',
                'column_name' => 'metameta.access_permission',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '格納ディレクトリ',
                'column_name' => 'metameta.data_directory',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'データ利用/ダウンロードアプリケーション名ja',
                'column_name' => 'data_applications.name_ja',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'データ利用/ダウンロードアプリケーション名en',
                'column_name' => 'data_applications.name_en',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'データ利用/ダウンロードアプリケーションURL',
                'column_name' => 'data_applications.url',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'ドキュメントメタデータja URL',
                'column_name' => 'metameta.metadata_ja_url',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'ドキュメントメタデータen URL',
                'column_name' => 'metameta.metadata_en_url',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => '公開URL',
                'column_name' => 'metameta.search_url',
                'created_at' => Carbon::now(),
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
