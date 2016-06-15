<?php
/**
 * Copyright (c) 2016.
 * @Author: Scherban Andrey
 */

namespace evneandreys\yii2_filemanager\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use evneandreys\yii2_filemanager\models\Files;

/**
 * FilesSearch represents the model behind the search form about `evneandreys\yii2_filemanager\models\Files`.
 */
class FilesSearch extends Files {

//    public $filesRelationships;
    /**
     * @var
     */
    public $tags;
    /**
     * @var
     */
    public $keywords;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['file_id', 'folder_id'], 'integer'],
            [['url', 'thumbnail_name', 'src_file_name', 'mime_type', 'caption', 'alt_text', 'description', 'tags', 'keywords'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Files::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 25],
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC,
                    'file_id' => SORT_ASC
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $filesType = \Yii::$app->controller->module->acceptedFilesType;
        $mime_type = isset($filesType[$this->mime_type]) ? $filesType[$this->mime_type] : $this->mime_type;

        $query->andFilterWhere([
            'mime_type' => $mime_type,
            'folder_id' => $this->folder_id
        ]);

        if (!empty($this->tags)) {
            $tagKeyword = $this->tags;
            $this->tags = [];
            $query->joinWith(['filesRelationships' => function($query) use ($tagKeyword) {
                $query->joinWith(['tag' => function($query) use ($tagKeyword) {
                        foreach ($tagKeyword as $tkey) {
                            $query->orFilterWhere(['like', 'value', $tkey]);
                        }
                    }], true, 'INNER JOIN');
            }], false, 'INNER JOIN');
            foreach ($tagKeyword as $tkey) {
                $this->tags[$tkey] = $tkey;
            }
        }

        $query->andFilterWhere(['OR',
            ['like', 'src_file_name', $this->keywords],
            ['like', 'caption', $this->keywords],
            ['like', 'alt_text', $this->keywords],
            ['like', 'description', $this->keywords]
        ]);

        return $dataProvider;
    }

}
