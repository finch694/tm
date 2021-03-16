<?php


namespace common\widgets\fileInput;


use yii\widgets\InputWidget;

class FileInputWidget extends InputWidget
{
    public function run()
    {
        return $this->renderInputHtml('');
    }

    protected function renderInputHtml($type)
    {
        return  $this->render('file-input',[
            'model' => $this->model,
            'attribute' => $this->attribute,
        ]);
    }

}