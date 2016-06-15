<?php

namespace evneandreys\filemanager\components;

use yii\helpers\Html;

/**
 * Class FilemanagerHelper
 * @package evneandreys\filemanager\components
 */
class FilemanagerHelper {

    /**
     *
     */
    const CACHE_TAG = 'dpodium.filemanager.file';


    /**
     * @param $value
     * @param string $key
     * @param bool $thumbnail
     * @param bool $tag
     * @return null
     * @throws \Exception
     */
    public static function getFile($value, $key = 'file_id', $thumbnail = false, $tag = false) {
        if (!in_array($key, ['file_id', 'file_identifier'])) {
            throw new \Exception('Invalid attribute key.');
        }

        $module = \Yii::$app->getModule('filemanager');
        $cacheKey = 'files' . '/' . $key . '/' . $value;

        if (isset($module->cache)) {
            if (is_string($module->cache) && strpos($module->cache, '\\') === false) {
                $cache = \Yii::$app->get($module->cache, false);
            } else {
                $cache = Yii::createObject($module->cache);
            }

            if ($file = $cache->get($cacheKey)) {
                return $file;
            }
        }

        $model = new $module->models['files'];
        $fileObject = $model->find()->where([$key => $value])->one();

        $file = null;
        if ($fileObject) {
            foreach ($fileObject as $attribute => $value) {
                $file['info'][$attribute] = $value;
            }

            $src = $fileObject->object_url . $fileObject->src_file_name;
            if ($thumbnail && !is_null($fileObject->dimension)) {
                $src = $fileObject->object_url . $fileObject->thumbnail_name;
            }

            if (!is_null($fileObject->dimension)) {
                $file['img'] = Html::img($src);
            }

            if ($tag && isset($fileObject->filesRelationships)) {
                foreach ($fileObject->filesRelationships as $relationship) {
                    if (isset($relationship->tag)) {
                        $file['tag'][$relationship->tag->tag_id] = $relationship->tag->value;
                    }
                }
            }
        }

        if ($file !== null && isset($cache)) {
            $cache->set($cacheKey, $file, 86400, new \yii\caching\TagDependency([
                'tags' => self::CACHE_TAG
            ]));
        }

        return $file;
    }

}
