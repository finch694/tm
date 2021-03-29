<?php

namespace common\widgets\fileInput;

use yii\widgets\InputWidget;

/**
 * Class FileInputWidget
 * @package common\widgets\fileInput
 */
class FileInputWidget extends InputWidget
{
    /**
     * @return string
     */
    public function run()
    {
        return $this->renderInputHtml('');
    }

    /**
     * @param string $type
     * @return string
     */
    protected function renderInputHtml($type)
    {
        return  $this->render('file-input',[
            'model' => $this->model,
            'attribute' => $this->attribute,
            'id'=>$this->getId(),
        ]);
    }
}
