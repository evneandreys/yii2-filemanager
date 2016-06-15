<?php
/**
 * Copyright (c) 2016.
 * @Author: Scherban Andrey
 */

namespace evneandreys\filemanager\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "files_tag".
 *
 * @property integer $tag_id
 * @property string $value
 * @property integer $created_at
 *
 * @property FilesRelationship[] $filesRelationships
 */
class FilesTag extends ActiveRecord {

    /**
     * @return array
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'files_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'tag_id' => Yii::t('filemanager', 'Tag ID'),
            'value' => Yii::t('filemanager', 'Value'),
            'created_at' => Yii::t('filemanager', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFilesRelationships() {
        return $this->hasMany(FilesRelationship::className(), ['tag_id' => 'tag_id']);
    }

    /**
     * @param $tagArray
     * @return array
     */
    public function saveTag($tagArray) {
        $saveTags = [];

        if (is_array($tagArray)) {
            foreach ($tagArray as $tag) {
                if ($tagObj = $this->find()->where('value=:value', [':value' => $tag])->one()) {
                    $saveTags[] = $tagObj->tag_id;
                } else if (!$this->find()->where('tag_id=:tag_id', [':tag_id' => (int) $tag])->exists()) {
                    $this->value = \yii\helpers\Html::encode($tag);
                    if ($this->save()) {
                        $saveTags[] = $this->tag_id;
                        $this->setIsNewRecord(true);
                        unset($this->tag_id);
                    } else {
                        return ['error' => $this->errors['value'][0]];
                    }
                } else {
                    $saveTags[] = $tag;
                }
            }
        }

        return $saveTags;
    }

}
