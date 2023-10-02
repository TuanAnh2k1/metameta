<?php

namespace App\Core\Helper;

use App\Core\Common\CoreConst;
use App\Models\MetadataElement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MetametaElementHelper
{
    /**
     * @return array
     */
    public static function showableColumnNames() : array {
        $prefix = CoreConst::PREFIX_METADATA_COLUMN_NAME;
        $columnNames = [];
        $showableColumns = MetadataElement::where('column_name','LIKE', $prefix . '%')->get();
        foreach ($showableColumns as $column) {
            $fullName = $column->column_name;
            $subName = substr($fullName, strlen($prefix));
            $columnNames[] =  $subName;
        }
        return $columnNames;
    }

    /**
     * @param array $memo
     * @return void
     */
    public static function transformMemo(array &$memo): void
    {
        $creator = User::find($memo['created_by']);
        $created_by_user = $creator ? ($creator->display_name ?: $creator->username ) : null;
        $memo['created_by_user'] = $created_by_user;
        $memo['memo_date'] = DateHelper::format($memo['memo_date']);
    }

    /**
     * @param array $comment
     * @return void
     */
    public static function transformComment(array &$comment ):void
    {
        $creator = User::find($comment['created_by']);
        $created_by_user = $creator ? ($creator->display_name ?: $creator->username ) : null;
        $comment['created_by_user'] = $created_by_user;
        $metadata_element = MetadataElement::find($comment['metameta_element_id']);
        $comment['comment_date'] = DateHelper::format($comment['comment_date']);
        $comment['metadata_element'] = $metadata_element ? $metadata_element->name : null;
        $comment['can_edit'] = CommonHelper::isActionAllow(Auth::user(), $comment['user_id']);
    }

    /**
     * @param $metadata_elements
     * @return array
     */
    public static function transformMetadataElements(): array
    {
        $prefix = CoreConst::PREFIX_METADATA_COLUMN_NAME;
        $metadata_elements = MetadataElement::where('column_name', 'LIKE', $prefix.'%')->get();
        $transformed = [
            [
                'value' => 0,
                'name' => '',
                'column_name' => '',
            ]
        ];
        foreach ($metadata_elements as $element) {
            $columnName = substr($element->column_name, strlen($prefix));
//            if($columnName === "id") {
//                continue;
//            }
            $newElement['value'] = $element->id;
            $newElement['name'] = $element->name;
            $newElement['column_name'] = $columnName;
            $transformed[] = $newElement;
        }
        return $transformed;
    }

    public static function hasComment($metadata_elements, $listComment):array {
        $hasComment = [];
        foreach ($metadata_elements as $element) {
            if($element['value'] === 0) {
                continue;
            }
            $hasComment[$element['column_name']] = false;
            foreach ($listComment as $comment) {
                if($element['value'] == $comment['metameta_element_id']) {
                    $hasComment[$element['column_name']] = true;
                    break;
                }
            }
        }
        return $hasComment;
    }
}